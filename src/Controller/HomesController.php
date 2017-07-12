<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

class HomesController extends AppController
{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['index']);
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
    // echo "<pre>";
    // print_r($allcontents);
    // exit();
    $this->set('contents',$allcontents);
  }
}
 ?>
