<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

class MessagesController extends AppController{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['sendmes','getmesinfo']);
  }

  public function sendmes(){
    $this->autoRender = false;
    $userid = $this->request->session()->read('userid');
    if ($userid == null) {
      return $this->redirect(['controller'=>'Users','action'=>'login']);
    }

    if ($this->request->is('ajax')) {
      $message = $this->Messages->newEntity();
      $receiverid = $_POST['receiverid'];
      $body = $_POST['body'];
      $data = [
        'senderId' => $userid,
        'receiverId' => $receiverid,
        'message' => $body
      ];
      $message = $this->Messages->patchEntity($message,$data);
      if ($this->Messages->save($message)) {
        $this->Flash->success('sent message');
        echo "success";
      }
      else {
        $this->Flash->error('did not send message');
        echo "error";
      }
    }
  }

}
 ?>
