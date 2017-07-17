<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

class Message extends Entity{
  protected $_accessible = array("*"=>true,"id"=>false);
}
 ?>
