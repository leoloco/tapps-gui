<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Http\Client;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loggedIn = $this->Auth->user();
        $user = $this->Users->get($id, [
            'contain' => ['Ownerships', 'Tapps']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loggedIn = $this->Auth->user();
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }
    
    
    public function ssoLogin($id = null)
    {
        $user = null;
        $users = TableRegistry::get('Users');
        $tapps = TableRegistry::get('Tapps');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $query = $users->find('all')
                ->where(['Users.email =' => $request['email']]);
            if($query->first()==null)
            {
                $this->Flash->error("You don't have an account here, buy the tas licence on thingPark, you will be automatically provided an account on this platform");
            }
            else
            {
                
                $http = new Client();
                $url = "https://dx-api.thingpark.com/admin/latest/api/oauth/token?renewToken=true&validityPeriod=5minutes";
                $data_string = 'grant_type=client_credentials&client_id=poc-api%2F'.urlencode($request['email']).'&client_secret='.$request['password'];
                $headers = array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Accept: application/json',
                );
                
                $response = $http->post(
                    $url,
                    $data_string,
                    ['headers' => $headers]
                );
 
                if(isset($response->json['access_token']))
                {
                    $token = $response->json['access_token'];
                    $user = $this->Users->get($query->first()['id'], [
                    'contain' => []
                    ]);
                    $user = $this->Users->patchEntity($user, $request);
                    if ($this->Users->save($user)) {
                        $user = $this->Auth->identify();
                        if ($user) {
                            $this->Auth->setUser($user);
                            $url = "https://dx-api.thingpark.com/core/latest/api/applications";
                            $http = new Client([
                                'headers' => ['Authorization' => 'Bearer '.$token, 'Accept: application/json']
                            ]);
                            $response = $http->get($url);
                            
                            foreach ($response->json as $elements)
                            {
                                if(is_array($elements)){
                                    if($tapps->find()->where(['id' => $elements['id']])->isEmpty())
                                    {
                                        $query1 = $tapps->query();
                                        $query1->insert(['id','name','cdn_uri','cdn_login','cdn_password','user_id'])
                                                ->values([
                                                    'id' => $elements['id'],
                                                    'name' => $elements['name'],
                                                    'cdn_uri' => '0',
                                                    'cdn_login' => '0',
                                                    'cdn_password' => '0',
                                                    'user_id' => $user['id'],
                                                ])
                                                ->execute();
                                    }
                                }
                                else {
                                    $this->Flash->error("Problem retrieving your apps : ".$elements['error_code']);
                                }
                            }
                            return $this->redirect($this->Auth->redirectUrl());
                        }
                    }
                }
                else
                {
                    $this->Flash->error('Wrong password');
                }
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout','add']);
        $loggedIn = $this->Auth->user();
        if($loggedIn){
            $this->set(compact('loggedIn'));
        }
    }
    
    
    public function login()
    {
        if ($this->request->is('post')) {
            
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
    
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    
    
    public function isAuthorized($user)
    {
        // Tous les utilisateurs enregistrés peuvent ajouter des articles
        if (in_array($this->request->getParam('action'), ['add','edit','delete']) && $user['id']===(int)$this->request->getParam('pass.0')) {
            return true;
        }
        if ($this->request->getParam('action') === 'index') {
            return true;
        }
        return parent::isAuthorized($user);
    }
    
    
}
