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
    $this->request->session();
    $userid = $this->request->session()->read('userid');
    if ($userid == null) {
      return $this->redirect(['controller'=>'Users','action'=>'login']);
    }
  }
}


 ?>
