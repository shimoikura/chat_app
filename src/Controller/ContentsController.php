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

}

 ?>
