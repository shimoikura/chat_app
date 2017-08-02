<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;

class ContentsTable extends Table{
  public function initialize(array $config){
    parent::initialize($config);
    $this->setTable('contents');
    $this->setDisplayField('id');
    $this->setPrimaryKey("id");
    $this->addBehavior("Timestamp"); //get curently time

  }

  public function validationDefault(Validator $validator){
    $validator
          ->integer('id')
          ->allowEmpty('id','create');
    $validator
          ->requirePresence('userId','create')
          ->notEmpty('userId','create');
    $validator
          ->integer('favo')
          ->allowEmpty('favo','create');
    $validator
          ->requirePresence("postImg","create")
          ->allowEmpty("postImg");
    return $validator;
  }
}
 ?>
