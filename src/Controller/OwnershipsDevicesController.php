<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OwnershipsDevices Controller
 *
 * @property \App\Model\Table\OwnershipsDevicesTable $OwnershipsDevices
 *
 * @method \App\Model\Entity\OwnershipsDevice[] paginate($object = null, array $settings = [])
 */
class OwnershipsDevicesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Devices', 'Users']
        ];
        $ownershipsDevices = $this->paginate($this->OwnershipsDevices);

        $this->set(compact('ownershipsDevices'));
        $this->set('_serialize', ['ownershipsDevices']);
    }

    /**
     * View method
     *
     * @param string|null $id Ownerships Device id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ownershipsDevice = $this->OwnershipsDevices->get($id, [
            'contain' => ['Devices', 'Users']
        ]);

        $this->set('ownershipsDevice', $ownershipsDevice);
        $this->set('_serialize', ['ownershipsDevice']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ownershipsDevice = $this->OwnershipsDevices->newEntity();
        if ($this->request->is('post')) {
            $ownershipsDevice = $this->OwnershipsDevices->patchEntity($ownershipsDevice, $this->request->getData());
            if ($this->OwnershipsDevices->save($ownershipsDevice)) {
                $this->Flash->success(__('The ownerships device has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ownerships device could not be saved. Please, try again.'));
        }
        $devices = $this->OwnershipsDevices->Devices->find('list', ['limit' => 200]);
        $users = $this->OwnershipsDevices->Users->find('list', ['limit' => 200]);
        $this->set(compact('ownershipsDevice', 'devices', 'users'));
        $this->set('_serialize', ['ownershipsDevice']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ownerships Device id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ownershipsDevice = $this->OwnershipsDevices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ownershipsDevice = $this->OwnershipsDevices->patchEntity($ownershipsDevice, $this->request->getData());
            if ($this->OwnershipsDevices->save($ownershipsDevice)) {
                $this->Flash->success(__('The ownerships device has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ownerships device could not be saved. Please, try again.'));
        }
        $devices = $this->OwnershipsDevices->Devices->find('list', ['limit' => 200]);
        $users = $this->OwnershipsDevices->Users->find('list', ['limit' => 200]);
        $this->set(compact('ownershipsDevice', 'devices', 'users'));
        $this->set('_serialize', ['ownershipsDevice']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ownerships Device id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ownershipsDevice = $this->OwnershipsDevices->get($id);
        if ($this->OwnershipsDevices->delete($ownershipsDevice)) {
            $this->Flash->success(__('The ownerships device has been deleted.'));
        } else {
            $this->Flash->error(__('The ownerships device could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    
    
    
    public function isAuthorized($user)
    {
        return true;
        return parent::isAuthorized($user);
    }
}
