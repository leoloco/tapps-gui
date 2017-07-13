<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Tapps Controller
 *
 * @property \App\Model\Table\TappsTable $Tapps
 *
 * @method \App\Model\Entity\Tapp[] paginate($object = null, array $settings = [])
 */
class TappsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        //AppController::retrieveDevicesApplications($this->Auth->user());
        $this->paginate = [
            'contain' => ['Users']
        ];
        $tapps = $this->paginate($this->Tapps);

        $this->set(compact('tapps'));
        $this->set('_serialize', ['tapps']);
    }

    /**
     * View method
     *
     * @param string|null $id Tapp id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tapp = $this->Tapps->get($id, [
            'contain' => ['Users', 'Ownerships']
        ]);

        $this->set('tapp', $tapp);
        $this->set('_serialize', ['tapp']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        $tapp = $this->Tapps->newEntity();
        if ($this->request->is('post')) {
            $tapp = $this->Tapps->patchEntity($tapp, $this->request->getData());
            $tapp->user_id= $user['id'];
            if ($this->Tapps->save($tapp)) {
                $this->Flash->success(__('The tapp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tapp could not be saved. Please, try again.'));
        }
        $users = $this->Tapps->Users->find('list', ['limit' => 200]);
        $this->set(compact('tapp', 'users'));
        $this->set('_serialize', ['tapp']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tapp id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tapp = $this->Tapps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tapp = $this->Tapps->patchEntity($tapp, $this->request->getData());
            if ($this->Tapps->save($tapp)) {
                $this->Flash->success(__('The tapp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tapp could not be saved. Please, try again.'));
        }
        $users = $this->Tapps->Users->find('list', ['limit' => 200]);
        $this->set(compact('tapp', 'users'));
        $this->set('_serialize', ['tapp']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tapp id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tapp = $this->Tapps->get($id);
        if ($this->Tapps->delete($tapp)) {
            $this->Flash->success(__('The tapp has been deleted.'));
        } else {
            $this->Flash->error(__('The tapp could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    /*
     * @app.route('/sync/')
def device_sync(db):
    """
    1. GET http://dedi.boulsh.net/sync?id=xxxx
    RET: 0 = 'up to date'
         1 = 'sync'
    2. GET http://dedi.boulsh.net/sync?id=xxxx&applist=app-01,app-02
    RET: json
    3. GET http://dedi.boulsh.net/sync?id=xxxx&update=0
    RET: 0 = 'up to date'
         1 = 'sync'
    """
    try:
        dev_id = request.query.id
    except:
        return('Device id missing')
    try:
        app_list = request.query.applist
    except:
        app_list = ""
    dev_status = check_update(db, dev_id)
    print ("dev_status: %s" %  dev_status)
    if dev_status < 0:
        return ('unknown device')
    # request for synchronisation
    if app_list == "":
        if dev_status == 1:
            return ('1') # sync
        else:
            return ('0') # up to date
    # performing synchronization
    return (gen_sync_app_list(db, dev_id, app_list.split(',')))
     */
    public function sync(){
        if ($this->request->is(['get'])){
            $this->Flash->error($this->request->getParam('pass.0'));
        }
        $this->paginate = [
            'contain' => ['Users']
        ];
        $tapps = $this->paginate($this->Tapps);

        $this->set(compact('tapps'));
        $this->set('_serialize', ['tapps']);
        
    }


    /*
     * Defines authorized actions for a non logged in user.
     * 
     * @param \Cake\Event\Event $event The beforeFilter event
     * @return \Cake\Network\Response|null|void
     */   
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->deny();
        $loggedIn = $this->Auth->user();
        if($loggedIn){
            $this->set(compact('loggedIn','sync'));
        }
    }
    
    
    /*
     * Defines user rights depending on their type (subscriber, appmanager, vendor, admin)
     * 
     * @param Cake\Auth\user
     */
    public function isAuthorized($user)
    {
        //Index, view and tapp provisionning authorized to all managers
        if (in_array($this->request->getParam('action'), ['index','add','view']) && $user['type']==='appmanager'){
            return true;
        }
        //The edit and delete actions are only allowed if the app is owned by the current appmanager
        //Importing tapps table
        $tapps = TableRegistry::get('Tapps');
        //Querying all tapps
        $query = $tapps->find();
        //Geting only the tapp the user just tried to edit
        $query->where(['Tapps.id' => (int)$this->request->getParam('pass.0')]);
        //Selecting the id of the owner
        $query->select('user_id');
        //If the owner id is the same as current user, authorize editing or deletion
        if (in_array($this->request->getParam('action'), ['edit','delete']) && $user['type']==='appmanager' && $user['id']===$query->first()['user_id']){
            return true;
        }
        return parent::isAuthorized($user);
    }
}
