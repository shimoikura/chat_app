<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\Query;

class CommentsTable extends Table{
  public function initialize(array $config){
    parent::initialize(array $config);
    $this->setTable('comments');
    $this->setDisplayField('id');
    $this->setPrimaryKey("id");
  }

  public function validationDefault(Validator $validator){
    $validator
          ->integer('id')
          ->allowEmpty('id','create');
    $validator
          ->requirePresence('commenterId','create')
          ->notEmpty('commenterId','create');
    $validator
          ->requirePresence('contentId','create')
          ->notEmpty('contentId','create');
    $validator
          ->requirePresence('comment','create')
          ->notEmpty('comment','create');
    return $validator;
  }
}
 ?>
