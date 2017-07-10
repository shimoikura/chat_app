<?php
namespace App\Controller;
use App\Controller\AppController;

class HomesController extends AppController
{
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
