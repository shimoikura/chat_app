<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\View\Helper\HtmlHepler;
use Cake\Event\Event;



class ContentsController extends AppController{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['add','favo']);
  }

  public function add(){
    $this->autoRendor = false;
    $content = $this->Contents->newEntity();
    if ($this->request->is("POST")){
      $content = $this->Contents->patchEntity($content,$this->request->getData());
      if ($this->Contents->save($content)) {
        $this->Flash->success('Your content is successfully created. ');
        return $this->redirect('/');
      }
      else {
        echo "error";
      }
    }
  }

  // public function favo() {
  //   if($this->RequestHandler->isAjax())
  //   {
  //     $this->autoRendor = false;
  //     $this->Layout= 'ajax';
  //     response = 'ok';
  //     $this->response->type('text');
  //     $t
  //   }
    // if ($this->request->is('POST')) {
      // echo "good";
      // $rhis->response->body($response);
      // $this->loadModel('Contents');
      // $favo = $this->Contents->find()->where(['id'=>$id->select('favo')]);
      // if ($this->request->getData('state') == 0) {
      //
      // }
    // }
    // else {
      // echo "bad";
      // return $this->redirect('/');
    // }
  // }

}

 ?>
