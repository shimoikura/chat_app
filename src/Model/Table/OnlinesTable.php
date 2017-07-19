<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;

class OnlinesTable extends Table{
  public function initialize(array $config){
    parent::initialize($config);
    $this->setTable("onlines");
    $this->setDisplayField("id");
    $this->setPrimaryKey("id");
  }

  public function validationDefault(Validator $validator){
    $validator
          ->integer('id')
          ->allowEmpty('id','create');
    $validator
          ->requirePresence('userId','create')
          ->notEmpty('userId','create');
    return $validator;
  }

  public function buildRules(RulesChecker $rules){
    $rules->add($rules->isUnique(array("userId")));
    return $rules;
  }
}
 ?>
