<?php
namespace App\Controller;

use App\Controller\AppController;

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
        $ownership = $this->Ownerships->newEntity();
        if ($this->request->is('post')) {
            $ownership = $this->Ownerships->patchEntity($ownership, $this->request->getData());
            if ($this->Ownerships->save($ownership)) {
                $this->Flash->success(__('The ownership has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ownership could not be saved. Please, try again.'));
        }
        $devices = $this->Ownerships->Devices->find('list', ['limit' => 200]);
        $users = $this->Ownerships->Users->find('list', ['limit' => 200]);
        $tapps = $this->Ownerships->Tapps->find('list', ['limit' => 200]);
        $this->set(compact('ownership', 'devices', 'users', 'tapps'));
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
        $ownership = $this->Ownerships->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ownership = $this->Ownerships->patchEntity($ownership, $this->request->getData());
            if ($this->Ownerships->save($ownership)) {
                $this->Flash->success(__('The ownership has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ownership could not be saved. Please, try again.'));
        }
        $devices = $this->Ownerships->Devices->find('list', ['limit' => 200]);
        $users = $this->Ownerships->Users->find('list', ['limit' => 200]);
        $tapps = $this->Ownerships->Tapps->find('list', ['limit' => 200]);
        $this->set(compact('ownership', 'devices', 'users', 'tapps'));
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
    
    
    public function isAuthorized($user)
    {
        if ($this->request->getParam('action') === 'index') {
            return true;
        }
        if ($this->request->getParam('action') === 'add' && $user['type']==='vendor') {
            return true;
        }
        return parent::isAuthorized($user);
    }
    
    
}
