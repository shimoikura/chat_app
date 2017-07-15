<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\Helper\HtmlHepler;

class UsersController extends AppController{

  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['login','logout','register','addfriends','frequest']);
  }

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// ログイン機能
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function login(){
    $this->viewBuilder()->setLayout('login');
    if ($this->request->is("POST")) {
      // $target= $this->request->data['targetPage'];
      // $targetArray = ['carts','ships','register'];

      $user = $this->Auth->identify();
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
        $this->redirect('/');
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


// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// LOGOUT
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function logout(){
    $this->autoRender = false;
    $this->request->session()->destroy();
    $this->redirect('/');
  }


// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// USER登録
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
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
    }
    $this->set('user',$user);
}

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// Userの検索、Fried Requestの送信     ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function addfriends(){
    $this->request->session();
    $userid = $this->request->session()->read("userid");
    if ($userid == null) {
      $this->redirect(["controller"=>"users",'action'=>'login']);
    }
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // 自分以外のuserをVIEW表示する
    $users = $this->Users->find()
                            ->where(['id IS NOT' => $userid])
                            ->all();
    $this->set("users",$users);
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // F_requestsTableへinsert
    $this->loadModel("F_requests");
    if ($this->request->is('POST')) {
      $senderid =  $this->request->data['senderId'];
      $receiverid =  $this->request->data['receiverId'];
      $f_requests = $this->F_requests->find()
                                    ->where(['senderId IS' => $senderid])
                                    ->where(['receiverId IS' => $receiverid])
                                    ->all();
      if (count($f_requests) == 0) //requestがまだ送られていない場合
      {
        echo "ok";
        $f_request = $this->F_requests->newEntity();
        $f_request = $this->F_requests->patchEntity($f_request,$this->request->getData());
        if ($this->F_requests->save($f_request)) {
          $this->Flash->success("Your addfriend request is successfully send.");
        }
        else {
          $this->Flash->error("Your addfriend request is not send.....try again!");
        }
      }
      else {
        echo "no";
      }
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    }
  }

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// 友達リクエストの回答.Response
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function frequest(){
    $this->auotRender = false;
    $this->request->session();
    $userid = $this->request->session()->read("userid");
    $this->loadModel("F_requests");
    if ($this->request->is('POST')) {
      $senderid =  $this->request->data['senderId'];
      if (isset($this->request->data['confirm']) && $this->request->data['confirm']) {
        // F_requestsTableにインサート（↓要らないのでは？　UserTableへのインサートだけで十分かも）
        $query = $this->F_requests->query();
        $query->update()
                  ->set(['status'=>1])
                  ->where(['senderId'=> $senderid])
                  ->where(['receiverId'=>$userid])
                  ->execute();
        // UserTableのfriendsにインサート
            //送られた側のfriends情報取得
        $query = $this->Users->find()
                          ->select('friends')
                          ->where(['id'=>$userid])
                          ->all();
        $friends1 = $query->toArray();
            //送った側のfriends情報取得
        $query = $this->Users->find()
                          ->select('friends')
                          ->where([ 'id' => $senderid ]);
        $friends2 = $query->toArray();
           //送られた側のUsersレコード
        $query = $this->Users->query();
        $query->update()
                  ->set([ 'friends' => $friends1[0]['friends'].$senderid.","])
                  ->where([ 'id' => $userid])
                  ->execute();
            //送った側のUsersレコード
        $query = $this->Users->query();
        $query->update()
                  ->set([ 'friends' => $friends2[0]['friends'].$userid.","])
                  ->where([ 'id' => $senderid])
                  ->execute();

        $this->redirect('/notice');
      }
      else {
        $query = $this->F_requests->query();
        $query->delete()
                  ->where(['senderId'=> $senderid])
                  ->where(['receiverId'=>$userid])
                  ->execute();
        $this->redirect('/notice');
      }

          // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
          // count of Freindsrequests(Notice) SESSION
          // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
          $this->loadModel("F_requests");
          $notices = $this->F_requests->find()
                                          ->where(['receiverId IS' => $userid,'status'=>0])
                                          ->all();
          $this->request->session()->write("f_req_num",count($notices));
    }
    else {
      $this->redirect("/");
    }
  }
}
 ?>
