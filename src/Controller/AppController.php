<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Http\Client;
use Cake\I18n\Time;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'ssoLogin'
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password']
                ]
            ]   
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        //$this->Auth->allow(['logout']);
        $this->Auth->allow();
        $loggedIn = $this->Auth->user();
        if($loggedIn){
            $this->set(compact('loggedIn'));
        }
    }
    
    
    
    public function isAuthorized($user)
    {
        // Admin peuvent accéder à chaque action
        if (isset($user['type']) && $user['type'] === 'admin') {
            return true;
        }
        // Par défaut refuser
        return false;
    }
    
    public function updateOwnerships($user){
        $exists = false;
        
        //Importing tapps table
        $tapps = TableRegistry::get('Tapps');
        //Importing devices table
        $devices = TableRegistry::get('Devices');
        //Importing ownerships table
        $ownerships = TableRegistry::get('Ownerships');
        
        //Importing ownerships
        $query = $ownerships->find();
        $query->select(['user_id', 'tapp_id','device_id']);
        $query->where(['user_id' => $user['id']]);
        $query->all();
        
        $url = "https://dx-api.thingpark.com/core/latest/api/applications";
        $http = new Client([
            'headers' => ['Authorization' => 'Bearer '.$user['API_KEY'], 'Accept: application/json']
        ]);
        $response = $http->get($url);
        foreach ($response->json as $elements){
            if(is_array($elements)){
                if(strpos($elements['id'], 'device') !== false){
                    foreach ($query as $ownership){
                        if($elements['id'] === $query->device_id)
                        {
                            
                        }
                    }
                    

                }  elseif (strpos($elements['id'], 'application') !== false) {

                }

            }
        }
    }
    public function retrieveDevicesApplications($user){
        //Importing tapps table
        $tapps = TableRegistry::get('Tapps');
        //Importing devices table
        $devices = TableRegistry::get('Devices');
        $url = "https://dx-api.thingpark.com/core/latest/api/applications";
        $http = new Client([
            'headers' => ['Authorization' => 'Bearer '.$user['API_KEY'], 'Accept: application/json']
        ]);
        $response = $http->get($url);
        foreach ($response->json as $elements){
            if(is_array($elements)){
                if(strpos($elements['id'], 'device') !== false){
                    if($devices->find()->where(['tp_id' => $elements['id']])->isEmpty()){
                        $queryDevices=$devices->query();
                        $queryDevices->insert(['tp_id','name','creation_date'])
                                ->values([
                                    'tp_id' => $elements['id'],
                                    'name' => $elements['name'],
                                    'creation_date' => Time::now(),
                                ])
                                ->execute();
                    }

                }  elseif (strpos($elements['id'], 'application') !== false) {
                    if($tapps->find()->where(['tp_id' => $elements['id']])->isEmpty())
                    {
                        $queryTapps = $tapps->query();
                        $queryTapps->insert(['tp_id','name','cdn_uri','cdn_login','cdn_password','user_id'])
                                ->values([
                                    'tp_id' => $elements['id'],
                                    'name' => $elements['name'],
                                    'cdn_uri' => '0',
                                    'cdn_login' => '0',
                                    'cdn_password' => '0',
                                    'user_id' => $user['id'],
                                ])
                                ->execute();
                    }
                }
            }
        }
    }
}
