<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\Helper\HtmlHepler;

class UsersController extends AppController{

  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['login','register']);
  }

  public function login(){
    if ($this->request->is("POST")) {
      // $target= $this->request->data['targetPage'];
      // $targetArray = ['carts','ships','register'];

      $user = $this->Auth->identify();
      print_r($this->request->data);
      if ($user) {
        $this->Auth->setUser($user);
        $this->Users->id = $this->Auth->user("id"); //ユニークなidをセーブする
        $this->Users->name = $this->Auth->user("username");

        $this->request->session();
        $this->request->session()->write("userid",$this->Users->id);

        $this->Flash->success("You could login successfully.");
        // $this->redirect(['controller'=>'products','action'=>'admin']);
        // if(in_array($target,$targetArray))
        // {
        //   $this->redirect('/'.$target);
        // }
        // else{
        // $this->redirect('/');
        // }
      }
      else {
        $this->Flash->error("You have not logined.");
      }
    }
    else {
      // echo "string";
      // $url = $this->referer();
    }
  }

  public function register(){
    $user = $this->Users->newEntity();
    if ($this->request->is('POST')) {
      $user = $this->Users->patchEntity($user,$this->request->getData());
      if ($this->Users->save($user)) { //save() -> insert
        $this->Flash->success("Your registration is successfully created.");  //Flash is class
        return $this->redirect(array("action"=>"login")); //if function is same class,don't need Controller name.
      }//successしたときにメッセージ Flash messerge
      else {
        $this->Flash->error("Your registration is not created.....try again!");  //Flash is class
      }
    }
    else {
      echo "data did not come";
    }
  }
}
 ?>
