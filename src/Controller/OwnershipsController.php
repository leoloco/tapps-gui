<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * Ownerships Controller
 *
 * @property \App\Model\Table\OwnershipsTable $Ownerships
 *
 * @method \App\Model\Entity\Ownership[] paginate($object = null, array $settings = [])
 */
class OwnershipsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Devices', 'Users', 'Tapps']
        ];
        $ownerships = $this->paginate($this->Ownerships);

        $this->set(compact('ownerships'));
        $this->set('_serialize', ['ownerships']);
    }

    /**
     * View method
     *
     * @param string|null $id Ownership id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ownership = $this->Ownerships->get($id, [
            'contain' => ['Devices', 'Users', 'Tapps']
        ]);

        $this->set('ownership', $ownership);
        $this->set('_serialize', ['ownership']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        
        
        $ownershipsApps = TableRegistry::get('OwnershipsApps');
        $queryApps = $ownershipsApps
                ->find()
                ->where(['user_id' => $user['id']])
                ->select('tapp_id');
        $resultsApps = $queryApps->toArray();
        
        echo(print_r($resultsApps));
        
        $ownershipsDevices = TableRegistry::get('OwnershipsDevices');
        $queryDevices = $ownershipsDevices
                ->find()
                ->where(['user_id' => $user['id']])
                ->select('device_id');
        $resultsDevices = $queryDevices->toArray();
        
        
        $ownership = $this->Ownerships->newEntity();
        if ($this->request->is('post')) {
            $ownership = $this->Ownerships->patchEntity($ownership, $this->request->getData());
            $ownership->creation_date = Time::now();
            $ownership->modified_date = Time::now();
            if ($this->Ownerships->save($ownership)) {
                
                $this->Flash->success(__('The ownership has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ownership could not be saved. Please, try again.'));
        }
        if($user['type']==='subscriber'){
            $devices = $this->Ownerships->Devices->find('list', ['limit' => 200])->where(['Devices.id IN'=> $resultsDevices]);
            $users = $user;
            $tapps = $this->Ownerships->Tapps->find('list', ['limit' => 200])->where(['Tapps.id IN'=> $resultsApps]);
        }
        else{
            $devices = $this->Ownerships->Devices->find('list', ['limit' => 200]);
            $users = $this->Ownerships->Users->find('list', ['limit' => 200]);
            $tapps = $this->Ownerships->Tapps->find('list', ['limit' => 200]);
        }
        $tapps->select('version_latest');
        $this->set(compact('ownership', 'devices', 'users', 'tapps','user'));
        $this->set('_serialize', ['ownership']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ownership id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $ownership = $this->Ownerships->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ownership = $this->Ownerships->patchEntity($ownership, $this->request->getData());
            $ownership->modified_date = Time::now();
            if($this->Auth->user()['type']==='subscriber'){
                $ownership->user_id = $this->Auth->user()['id'];
            }
            if ($this->Ownerships->save($ownership)) {
                
                $this->Flash->success(__('The ownership has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ownership could not be saved. Please, try again.'));
        }
        $devices = $this->Ownerships->Devices->find('list', ['limit' => 200]);
        $users = $this->Ownerships->Users->find('list', ['limit' => 200]);
        $tapps = $this->Ownerships->Tapps->find('list', ['limit' => 200]);
        $tapps->select('version_latest');
        $this->set(compact('ownership', 'devices', 'users', 'tapps','user'));
        $this->set('_serialize', ['ownership']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ownership id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ownership = $this->Ownerships->get($id);
        if ($this->Ownerships->delete($ownership)) {
            $this->Flash->success(__('The ownership has been deleted.'));
        } else {
            $this->Flash->error(__('The ownership could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /*
     * Defines user rights depending on their type (subscriber, appmanager, vendor, admin)
     * 
     * @param Cake\Auth\user
     * @return boolean
     */
    public function isAuthorized($user)
    {
        if (in_array($this->request->getParam('action'), ['view','index','add','edit']) && $user['type']==='vendor') {
            return true;
        }
        /*
        $ownershipsApps = TableRegistry::get('OwnershipsApps');
        $queryApp = $ownershipsApps
                ->find()
                ->where(['user_id' => $user['id']])
                ->select('tapp_id');
        
        $ownershipsDevices = TableRegistry::get('OwnershipsDevices');
        $queryDevice = $ownershipsDevices
                ->find()
                ->where(['user_id' => $user['id']])
                ->select('device_id');
        */
        
        if (in_array($this->request->getParam('action'), ['view','index','add','edit']) && $user['type']==='subscriber'){
            return true;
        }
        //The edit and delete actions are only allowed if the app is owned by the current appmanager
        //Importing tapps table
        $ownerships = TableRegistry::get('Ownerships');
        //Querying all tapps
        $query = $ownerships->find();
        //Geting only the tapp the user just tried to edit
        $query->where(['Ownerships.id' => (int)$this->request->getParam('pass.0')]);
        //Selecting the id of the owner
        $query->select('user_id');
        //If the owner id is the same as current user, authorize editing or deletion
        if (in_array($this->request->getParam('action'), ['view','edit','delete']) && $user['type']==='subscriber' && $user['id']===$query->first()['user_id']){
            return true;
        }
        return parent::isAuthorized($user);
    }
    
    
}
