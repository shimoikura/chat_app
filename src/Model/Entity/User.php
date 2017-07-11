<?php
  namespace App\Model\Entity;
  use Cake\ORM\Entity;
  use Cake\Auth\DefaultPasswordHasher;  //暗号化するため

  class User extends Entity{
    protected $_accessible = array("*"=>true,"id"=>false);

    protected $_hidden = array("password");

    protected function _setPassword($value)
    {
      $hasher = new DefaultPasswordHasher();
      return $hasher->hash($value);
    }
  }
 ?>
