<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

class MessagesController extends AppController{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['sendmes']);
  }

  public function sendmes(){
    $this->autoRender = false;
    $this->request->session();
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
}
 ?>
