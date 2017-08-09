<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;

class CommentsTable extends Table{
  public function initialize(array $config){
    parent::initialize($config);
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
          ->notEmpty('commenterId');
    $validator
          ->requirePresence('contentId','create')
          ->notEmpty('contentId');
    $validator
          ->requirePresence('comment','create')
          ->notEmpty('comment');
    return $validator;
  }
}
 ?>
