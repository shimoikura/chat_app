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
    $userid = $this->request->session()->read('userid');
    if ($userid == null) {
      return $this->redirect(['controller'=>'Users','action'=>'login']);
    }
    // username取得
    $this->loadModel("Users");
    $username = $this->Users->find()
                    ->select('username')
                    ->where(['id'=>$userid])
                    ->toArray();
    $username = $username[0]['username'];
    $this->request->session()->write('username',$username);

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // Load Contenstable and Users to Set contents
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    $this->loadModel('Contents');
    $contents = $this->Contents->find('all')->toArray();
    $allcontents = array();
    foreach ($contents as $value) {
      $data = $this->Users->find()->where(['id'=>$value['userId']])->toArray();
      foreach ($data as $user) {
        array_push($allcontents,array(
          'id' => $value['id'],
          'userId' => $user['id'],
          'username' => $user['username'],
          'userImg' => $user['userImg'],
          'body' => $value['body'],
          'favo' => $value['favo'],
          'favoUsers' => $value['favoUsers'],
          'created' => $value['created'],
          'postImg' => $value['postImg']
        ));
      }
    }
    rsort($allcontents);
    $this->set('contents',$allcontents);
  }



// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// Myself Post(マイページ)
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function mypost($id = null){
    $userid = $this->request->session()->read('userid');
    if ($userid == null) {
      return $this->redirect(['controller'=>'Users','action'=>'login']);
    }

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // USER INFORMATION
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
      if (isset($id)) {
        $userid = $id;
      }
    $this->loadModel('Users');
    $user = $this->Users->find()
                              ->where(['id'=> $userid])
                              ->all()
                              ->toArray();
    $friends = explode(",",$user[0]['friends']); //Friendsのidの配列
    $conditions = array();
    for ($i=0; $i < count($friends)-1; $i++) {
      $conditions['OR'][] = [
        'id IS' => $friends[$i]
      ];
    }
    $fusers = $this->Users->find()->where($conditions)->all();
    $this->set(compact('user','fusers','friends'));

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // Load Contenstable and Users to Set contents
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    $this->loadModel('Contents');
    $contents = $this->Contents->find()->where(['userId'=>$userid])->toArray();
    $data = $this->Users->find()->where(['id'=>$userid])->toArray();
    $allcontents = array();
    foreach ($contents as $value) {
      array_push($allcontents,array(
        'id' => $value['id'],
        'userId' => $data[0]['id'],
        'username' => $data[0]['username'],
        'userImg' => $data[0]['userImg'],
        'body' => $value['body'],
        'favo' => $value['favo'],
        'favoUsers' => $value['favoUsers'],
        'created' => $value['created'],
        'postImg' => $value['postImg']
      ));
    }
    rsort($allcontents);
    $this->set('contents',$allcontents);
  }



// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// Freiend Request
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function notice(){
    $this->request->session();
    $userid = $this->request->session()->read('userid');
    if ($userid == null) {
      return $this->redirect('/login');
    }
    $this->loadModel('F_requests');
    $query = $this->F_requests->find()
                                  ->where(['receiverId'=>$userid,'status'=>0])
                                  ->select('senderId');
    $requests = $query->toArray();

    $this->loadModel('Users');
    $all_r_users = array();
    if (count($requests) == 0) {
      $this->Flash->error("Your friend request is nothing!");
    }
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
