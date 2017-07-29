<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\View\Helper\HtmlHepler;
use Cake\Event\Event;
use Intervention\Image\ImageManager;

class CroppersController extends AppController{
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['moveimg','imger']);
  }
  public function moveimg(){
    $this->autoRender = false;
    if ($this->request->is("ajax")) {
      if ($_FILES['file']['error'] > 0) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
      }
      else {
        $image_name = $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'],WWW_ROOT."img/userImages/".$image_name);
        echo $image_name;
      }
    }
  }

  public function imger(){
    $this->autoRender = false;
    if ($this->request->is('ajax')) {
      $name = $_POST['name'];
      $name = str_replace("img/userImages/","",$name);
      $dataType = strstr($name, ".");
      $size = $_POST['data']['width'];
      $x = $_POST['data']['x'];
      $y = $_POST['data']['y'];
      $image_name = time()."_".$name;

      if ($dataType == ".png") {
        $img = imagecreatefrompng(WWW_ROOT.'img/userImages/'.$name);
      }
      elseif ($dataType == ".jpeg" || $dataType == ".jpg") {
        $img = imagecreatefromjpeg(WWW_ROOT.'img/userImages/'.$name);
      }
      elseif ($dataType == ".gif") {
        $img = imagecreatefromgif(WWW_ROOT.'img/userImages/'.$name);
      }
      else {
        echo "error";
      }
      $img2 = imagecrop($img, ['x' => $x, 'y' => $y, 'width' => $size, 'height' => $size]);
        if ($img2 !== FALSE) {
            imagepng($img2,WWW_ROOT.'img/userImages/'.$image_name);
            move_uploaded_file($img2,WWW_ROOT."img/userImages/".$image_name);
        }
      echo $image_name;
    }
  }
}
 ?>
