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

    if ($this->request->is('POST')) {
      $message = $this->Messages->newEntity();
      $message = $this->Messages->patchEntity($message,$this->request->getData());
      if ($this->Messages->save($message)) {
        $this->Flash->success('sent message');
        $this->redirect("/");
      }
      else {
        $this->Flash->error('did not send message');
        $this->redirect("/");
      }
    }
  }

  public function getmesinfo(){
    $userid = $this->request->session()->read('userid');
    $senderId = $userid;
    $receiverId = $_POST['receiverid'];
    $this->autoRender = false;
    //MessagesTableからメッセージ情報を取得
    $query = $this->Messages->find()
      ->where([ 'senderId' => $senderId, 'receiverId' => $receiverId])
      ->orwhere([ 'senderId' => $receiverId, 'receiverId' => $senderId])
      ->all();
    $mymessages = $query->toArray();
        if ($this->request->is("ajax")) {
            echo json_encode($mymessages);
        } else {
            echo "not ajax";
        }
  }
}
 ?>
