<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;

class MessagesTable extends Table{
  public function initialize(array $config){
    parent::initialize($config);
    $this->setTable("messages");
    $this->setDisplayField("id");
    $this->setPrimaryKey("id");
  }

  public function validationDefault(Validator $validator){
    $validator
          ->integer('id')
          ->allowEmpty("id","create");
    $validator
          ->requirePresence("senderId","create")
          ->notEmpty("senderId");
    $validator
          ->requirePresence("receiverId","create")
          ->notEmpty("receiverId");
    $validator
          ->requirePresence("message","create")
          ->notEmpty("message");
    return $validator;
  }
}
 ?>
