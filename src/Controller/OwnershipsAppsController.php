<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OwnershipsApps Controller
 *
 * @property \App\Model\Table\OwnershipsAppsTable $OwnershipsApps
 *
 * @method \App\Model\Entity\OwnershipsApp[] paginate($object = null, array $settings = [])
 */
class OwnershipsAppsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Tapps']
        ];
        $ownershipsApps = $this->paginate($this->OwnershipsApps);

        $this->set(compact('ownershipsApps'));
        $this->set('_serialize', ['ownershipsApps']);
    }

    /**
     * View method
     *
     * @param string|null $id Ownerships App id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ownershipsApp = $this->OwnershipsApps->get($id, [
            'contain' => ['Users', 'Tapps']
        ]);

        $this->set('ownershipsApp', $ownershipsApp);
        $this->set('_serialize', ['ownershipsApp']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ownershipsApp = $this->OwnershipsApps->newEntity();
        if ($this->request->is('post')) {
            $ownershipsApp = $this->OwnershipsApps->patchEntity($ownershipsApp, $this->request->getData());
            if ($this->OwnershipsApps->save($ownershipsApp)) {
                $this->Flash->success(__('The ownerships app has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ownerships app could not be saved. Please, try again.'));
        }
        $users = $this->OwnershipsApps->Users->find('list', ['limit' => 200]);
        $tapps = $this->OwnershipsApps->Tapps->find('list', ['limit' => 200]);
        $this->set(compact('ownershipsApp', 'users', 'tapps'));
        $this->set('_serialize', ['ownershipsApp']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ownerships App id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ownershipsApp = $this->OwnershipsApps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ownershipsApp = $this->OwnershipsApps->patchEntity($ownershipsApp, $this->request->getData());
            if ($this->OwnershipsApps->save($ownershipsApp)) {
                $this->Flash->success(__('The ownerships app has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ownerships app could not be saved. Please, try again.'));
        }
        $users = $this->OwnershipsApps->Users->find('list', ['limit' => 200]);
        $tapps = $this->OwnershipsApps->Tapps->find('list', ['limit' => 200]);
        $this->set(compact('ownershipsApp', 'users', 'tapps'));
        $this->set('_serialize', ['ownershipsApp']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ownerships App id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ownershipsApp = $this->OwnershipsApps->get($id);
        if ($this->OwnershipsApps->delete($ownershipsApp)) {
            $this->Flash->success(__('The ownerships app has been deleted.'));
        } else {
            $this->Flash->error(__('The ownerships app could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
