<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

class MessagesController extends AppController{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['sendmes','mymessages']);
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

  public function mymessages(){
    //MESSAGE
    if ($this->request->is("ajax")) {
      $this->autoRender = false;
      $userid = $this->request->session()->read('userid');
      $receiverId = $_POST['receiverid'];
      $senderId = $userid;
        //未読から既読にチェンジ
        $this->Messages->query()->update()
          ->set([ 'status' => 1 ])
          ->where([ 'senderId' => $receiverId, 'receiverId' => $senderId])
          ->execute();
        //MessagesTableからメッセージ情報を取得
        $query = $this->Messages->find()
          ->where([ 'senderId' => $senderId, 'receiverId' => $receiverId])
          ->orwhere([ 'senderId' => $receiverId, 'receiverId' => $senderId])
          ->all();
      $mymessages = $query->toArray();
      echo json_encode($mymessages);
    }
  }

}
 ?>
