<?php
namespace App\Controller;

use App\Controller\AppController;

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
        $tapp = $this->Tapps->newEntity();
        if ($this->request->is('post')) {
            $tapp = $this->Tapps->patchEntity($tapp, $this->request->getData());
            $tapp->user_id = $this->Auth->user('id');
            if ($this->Tapps->save($tapp)) {
                $this->Flash->success(__('The new application has been saved'));

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
    
    
    public function isAuthorized($user)
    {
        // Tous les utilisateurs enregistrés peuvent ajouter des articles
        if ($this->request->getParam('action') === 'add') {
            if($user['type']==='appmanager')
            {
                return true;
            }
        }
        if ($this->request->getParam('action') === 'index') {
            return true;
        }
        // The owner of an app can modify or delete it
        if (in_array($this->request->getParam('action'), ['edit', 'delete']) && $user['type']==='appmanager') {
            $tappId = (int)$this->request->getParam('pass.0');
            if ($this->Tapps->isOwnedBy($tappId, $user['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    
    
}
