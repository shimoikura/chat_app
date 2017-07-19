<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\Helper\HtmlHepler;

class OnlinesController extends AppController{

  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['onlineuser']);
  }

  public function onlineuser(){
    $this->autoRender = false;
    // オンライン中のUsersを取得
    $query = $this->Onlines->find()->all();
    $onlines = $query->toArray();
    // echo "<pre>";
    // print_r($onlines);
    // exit;
    if ($this->request->is("ajax")) {
      // echo "ajax";
        echo json_encode($onlines);
    } else {
        echo "not ajax";
    }
  }
}
 ?>
