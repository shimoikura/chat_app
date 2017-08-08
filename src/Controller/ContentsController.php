<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\View\Helper\HtmlHepler;
use Cake\Event\Event;



class ContentsController extends AppController{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['add','favo','comment']);
  }

  public function add(){
    $this->autoRender = false;
    $content = $this->Contents->newEntity();
    if ($this->request->is("post")){
      $img = $this->request->data['postImg'];
      $image_name = $img['name'];
      $image_size = $img['size'];
      if ($image_size < 1000000) {
        if(empty($image_name))
        {
          $image_name = "null";
        }else{
          $image_name = "contentImages/".time()."_".$image_name;
        }
        $this->request->data['postImg'] = $image_name;
        $content = $this->Contents->patchEntity($content,$this->request->data);
        if ($this->Contents->save($content)) {
            $this->Flash->success('Your content is successfully created. ');
            move_uploaded_file($img["tmp_name"],WWW_ROOT."img/".$image_name);
            return $this->redirect('/');
          }
          else {
              echo "error";
            }
      }
       else {
        $this->Flash->error("Your image size is too lerge.");  //Flash is class
      }
    }
    $this->set("contents",$content);
  }

  public function favo() {
    $this->autoRender = false;
    $userid = $this->request->session()->read('userid');
    $this->loadModel('Contents');
    if($this->request->is("ajax"))
    {
      $state = $_POST['state'];
      $contentid = $_POST['id'];
      $query = $this->Contents->find()->where(['id' => $contentid]);
      $content = $query->toArray();
      $favo = $content[0]['favo'];
      $favoUsers = $content[0]['favoUsers'];
      if ($state == 0) {
        $favo++;
        $query = $this->Contents->query()->update()
          ->set([ 'favo' => $favo , 'favoUsers' => $favoUsers.$userid.","])
          ->where(['id' => $contentid])
          ->execute();
      }
      else {
        $favo--;
        $query = $this->Contents->find()->select(['favoUsers'])->where(['id'=> $contentid])->toArray();
        $favoUsers = $query[0]['favoUsers'];
        $replace = str_replace($userid.',' , '' ,$favoUsers);
        $query = $this->Contents->query()->update()
          ->set([ 'favo' => $favo , 'favoUsers' => $replace])
          ->where(['id' => $contentid])
          ->execute();
      }
      echo $favo;
    }
    else {
      echo "bad";
      // return $this->redirect('/');
    }
  }


  public function comment(){
    $userid = $this->request->session()->read('userid');
    if ($this->request->is("ajax")) {
      $this->loadModel("Comments");
      $comment = $this->Comments->newEntity();
      $this->autoRender = false;
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
      echo "a";
    }
  }

}

 ?>
