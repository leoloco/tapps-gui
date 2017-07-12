<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Devices Controller
 *
 * @property \App\Model\Table\DevicesTable $Devices
 *
 * @method \App\Model\Entity\Device[] paginate($object = null, array $settings = [])
 */
class DevicesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        //AppController::retrieveDevicesApplications($this->Auth->user());
        $devices = $this->paginate($this->Devices);

        $this->set(compact('devices'));
        $this->set('_serialize', ['devices']);
    }

    /**
     * View method
     *
     * @param string|null $id Device id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $device = $this->Devices->get($id, [
            'contain' => ['Ownerships']
        ]);
        $this->set('device', $device);
        $this->set('_serialize', ['device']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $device = $this->Devices->newEntity();
        if ($this->request->is('post')) {
            $device = $this->Devices->patchEntity($device, $this->request->getData());
            if ($this->Devices->save($device)) {
                $this->Flash->success(__('The device has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The device could not be saved. Please, try again.'));
        }
        $this->set(compact('device'));
        $this->set('_serialize', ['device']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Device id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $device = $this->Devices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $device = $this->Devices->patchEntity($device, $this->request->getData());
            if ($this->Devices->save($device)) {
                $this->Flash->success(__('The device has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The device could not be saved. Please, try again.'));
        }
        $this->set(compact('device'));
        $this->set('_serialize', ['device']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Device id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $device = $this->Devices->get($id);
        if ($this->Devices->delete($device)) {
            $this->Flash->success(__('The device has been deleted.'));
        } else {
            $this->Flash->error(__('The device could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /*
     * Defines authorized actions for a non logged in user.
     * 
     * @param \Cake\Event\Event $event The beforeFilter event
     * @return \Cake\Network\Response|null|void
     */   
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index']);
        $loggedIn = $this->Auth->user();
        if($loggedIn){
            $this->set(compact('loggedIn'));
        }
    }
    
    
    /*
     * Defines user rights depending on their type (subscriber, appmanager, vendor, admin)
     * 
     * @param Cake\Auth\user
     */
    public function isAuthorized($user)
    {
        if ($this->request->getParam('action') === 'index' && $user['type']==='appmanager'){
            return true;
        }
        if ($this->request->getParam('action') === 'add' && $user['type']==='appmanager'){
            return true;
        }
        if (in_array($this->request->getParam('action'), ['edit']) && $user['type']==='appmanager'){
            return true;
        }
        return parent::isAuthorized($user);
    }
    
}
