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
            'authorize'=>'Controller',
            'authenticate'=>[
                  'Form'=>[
                    'fields'=>[
                      'username'=>'email',
                      'password'=>'password'
                    ]
                  ]
              ],
              'loginAction' => [
                        'controller' => 'Users',
                        'action' => 'login'
                ],
              'loginRedirect' => [
                  'controller' => 'Users',
                  'action' => 'register'
              ],
              'logoutRedirect' => [
                  'controller' => 'Users',
                  'action' => 'login'
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
        $userid = $this->request->session()->read('userid');
        if ($userid != null) {
          // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
          // count of Notice SESSION
          // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
              // count of friends requests
              $this->loadModel("F_requests");
              $fnotices = $this->F_requests->find()
                                              ->where(['receiverId IS' => $userid,'status'=>0])
                                              ->all();
              $this->request->session()->write("f_req_num",count($fnotices));
              // count of send messeages
              $this->loadModel("Messages");
              $mnotices = $this->Messages->find()
                                              ->where(['receiverId' => $userid,'status' => 0])
                                              ->all();
              $this->request->session()->write("mes_num",count($mnotices));
          // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
          //既に友達になっているUserIdを取得(for MESSAGE)
          // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
              $this->loadModel("Users");
              $query = $this->Users->find()
                              ->select('friends')
                              ->where([ 'id' => $userid]);
              $friends = $query->toArray();
                if (count($friends) == 0) {
                  // $this->Flash->error("Friends are nothing!");
                  $this->set('users',null);
                }
                else {
                  $friends = explode(",",$friends[0]['friends']); //Friendsのidの配列
                  $users = $this->Users->find();
                  $conditions = array();
                  $this->loadModel("Messages");
                  for ($i=0; $i < count($friends)-1 ; $i++) {
                    $id = $friends[$i];
                    $query = $this->Messages->find()
                                                ->where(['senderId' => $id , 'receiverId' => $userid ,'status' => 0])
                                                ->all();
                    $mes = $query->toArray();
                    $users = $this->Users->get($id);
                    $users = $users->toArray();
                    $users['count']=count($mes);
                    array_push($conditions,$users);
                  }
              $this->set("mesusers",$conditions);
            }
        }
    }

    public function beforeFilter(Event $event){
      parent::beforeFilter($event);
    }


    public function isAuthorized()
    {

    }
}
