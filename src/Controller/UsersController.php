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
          //Generation of session userid
          $this->request->session()->write("userid",$this->Users->id);
          $userid = $this->request->session()->read("userid");
        // OnlineaTableへインサート
        $this->loadModel("Onlines");
        $data = ['userId' => $userid];
        $online = $this->Onlines->newEntity();
        $online = $this->Onlines->patchEntity($online,$data);
        if ($this->Onlines->save($online)) {
          //success Message
          $this->Flash->success("You could login successfully.");
        }
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
        $this->redirect('/login');
      }
    }
    else {
      // echo "string";
      // $url = $this->referer();
    }
  }


// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// LOGOUT機能
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function logout(){
    $this->autoRender = false;
    $userid = $this->request->session()->read('userid');
      // Online user　をOnlinesTableから消去
      $this->loadModel("Onlines");
      $query = $this->Onlines->query();
      $query->delete()
                ->where(['userId'=> $userid])
                ->execute();
    // session Destroy
    $this->request->session()->destroy();
    //redirect
    $this->redirect('/');
  }


// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// USER登録
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function register(){
    $user = $this->Users->newEntity();
    if ($this->request->is('POST')) {
      $user = $this->Users->patchEntity($user,$this->request->getData());
      if ($this->Users->save($user)) {
        $this->Flash->success("Your registration is successfully created.");
        return $this->redirect(array("action"=>"login"));
      }
      else {
        $this->Flash->error("Your registration is not created.....try again!");  //Flash is class
      }
    }
    else {
    }
    $this->set('user',$user);
}

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// Userの検索、Fried Requestの送信
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  public function addfriends(){
    $this->request->session();
    $userid = $this->request->session()->read("userid");
    if ($userid == null) {
      $this->redirect(["controller"=>"users",'action'=>'login']);
    }
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // 自分以外,既に友達になっているユーザー以外のuserをVIEW表示する
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
        //既に友達になっているUserIdを取得
        $query = $this->Users->find()
                        ->select('friends')
                        ->where([ 'id' => $userid]);
        $friends = $query->toArray();
          if (count($friends) == 0) {
            $this->Flash->error("Friends are nothing!");
            $this->set('users',null);
          }
          else {
            $friends = explode(",",$friends[0]['friends']); //Friendsのidの配列

            $users = $this->Users->find();
            $conditions = array();
            for ($i=0; $i < count($friends)-1 ; $i++) {
              $conditions['AND'][]=[
                'id IS NOT' => $friends[$i]
              ];
            }
            $users->where(['id IS NOT' => $userid])->where($conditions);
            $users = $users->toArray();
        $this->set("users",$users);
          }

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // F_requestsTableへinsert
    $this->loadModel("F_requests");
    $f_requests = $this->paginate($this->F_requests);
    $this->set('f_requests',$f_requests);
    if ($this->request->is('POST')) {
      $senderid =  $this->request->data['senderId'];
      $receiverid =  $this->request->data['receiverId'];
      $f_requests = $this->F_requests->find()
                                    ->where(['senderId IS' => $senderid])
                                    ->where(['receiverId IS' => $receiverid])
                                    ->all();
      //Friendリクエストを送信したとき
      if (isset($this->request->data['send']) && $this->request->data['send']) {
        $f_request = $this->F_requests->newEntity();
        $f_request = $this->F_requests->patchEntity($f_request,$this->request->getData());
        if ($this->F_requests->save($f_request)) {
          $this->Flash->success("Your addfriend request is successfully send.");
        }
        else {
          $this->Flash->error("Your addfriend request is not send.....try again!");
        }
      }
      //Friendリクエストをキャンセルするとき
      elseif (isset($this->request->data['cancel']) && $this->request->data['cancel']) {
        $query = $this->F_requests->query();
        $query->delete()
                  ->where(['senderId'=> $userid])
                  ->where(['receiverId'=>$receiverid])
                  ->execute();
      }
      else {
        echo "no";
      }
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    $this->redirect("/addfriends");
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
    //Friendリクエストを許可するとき
      if (isset($this->request->data['confirm']) && $this->request->data['confirm']) {
        // F_requestsTableにインサート
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
    //Friensリクエストをキャンセルするとき
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
