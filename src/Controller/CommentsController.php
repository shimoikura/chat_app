<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

class CommentsController extends AppController{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['comment']);
  }

  public function comment(){
    $this->autoRender = false;
    $userid = $this->request->session()->read('userid');
    if ($userid == null) {
      return $this->redirect(['controller'=>'Users','action'=>'login']);
    }


    if ($this->request->is("ajax")) {

      $comment = $this->Comments->newEntity();
      $contentId = $_POST["id"];
      $body = $_POST["comment"];
      $data = [
        "commenterId" => $userid,
        "contentId" => $contentId,
        "comment" => $body
      ];
      $comment = $this->Comments->patchEntity($comment,$data);
      if ($this->Comments->save($comment)) {
        echo "success";
      }
      else {
        echo "error";
      }
    }
  }
}
 ?>
