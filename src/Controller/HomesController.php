<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

class HomesController extends AppController
{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['index','mypost','notice']);
  }

  public function index()
  {
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // after login
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    $this->request->session();
    $userid = $this->request->session()->read('userid');
    if ($userid == null) {
      return $this->redirect(['controller'=>'Users','action'=>'login']);
    }

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // Load Contenstable and Users to Set contents
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    $this->loadModel('Contents');
    $this->loadModel('Users');
    $contents = $this->paginate($this->Contents);


    $allcontents = array();
    foreach ($contents as $value) {
      $query = $this->Users->find()->where(['id'=>$value['userId']])->select('username');
      $data = $query->toArray();
      foreach ($data as $user) {
        array_push($allcontents,array(
          'id' => $value['id'],
          'username' => $user['username'],
          'body' => $value['body'],
          'favo' => $value['favo'],
          'created' => $value['createdDate']->format('Y/m/d H:i')
        ));
      }
    }
    rsort($allcontents);
    $this->set('contents',$allcontents);


    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // count of Freindsrequests(Notice) SESSION
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    $this->loadModel("F_requests");
    $notices = $this->F_requests->find()
                                    ->where(['receiverId IS' => $userid,'status'=>0])
                                    ->all();
    $this->request->session()->write("f_req_num",count($notices));
  }

  // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  // Myself Post
  // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function mypost(){
    $this->request->session();
    $userid = $this->request->session()->read('userid');
    if ($userid == null) {
      return $this->redirect(['controller'=>'Users','action'=>'login']);
    }

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // Content
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    $this->loadModel('Contents');
    $query = $this->Contents->find()->where(['userId'=>$userid]);
    $contents = $query->toArray();
    $this->set('contents',$contents);

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // Freiend Request
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    $this->loadModel('F_requests');
    $query = $this->F_requests->find()
                                  ->where(['receiverId'=>$userid,'status'=>0])
                                  ->select('senderId');
    $requests = $query->toArray();

    $this->loadModel('Users');
    $all_r_users = array();
    for ($i=0; $i < count($requests); $i++) {
      $idn = $requests[$i]['senderId'];
      $query1 = $this->Users->find()->where(['id'=>$idn])->first();
      $r_user = $query1->toArray();
      array_push($all_r_users,$r_user);
    }
    $this->set('r_users',$all_r_users);
  }
}
 ?>
