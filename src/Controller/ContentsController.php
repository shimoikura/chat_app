<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\View\Helper\HtmlHepler;
use Cake\Event\Event;



class ContentsController extends AppController{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['add']);
  }

  public function add(){
    $this->autoRendor = false;
    $content = $this->Contents->newEntity();
    if ($this->request->is("POST")){
      $content = $this->Contents->patchEntity($content,$this->request->getData());
      // echo "<pre>";
      // print_r($content);
      // exit();
      if ($this->Contents->save($content)) {
        $this->Flash->success('Your content is successfully created. ');
        return $this->redirect('/');
      }
      else {
        echo "error";
      }
    }
  }
}

 ?>
