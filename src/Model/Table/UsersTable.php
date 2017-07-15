<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;

class UsersTable extends Table{
  public function initialize(array $config){
    parent::initialize($config);
    $this->setTable("users");
    $this->setDisplayField("id");
    $this->setPrimaryKey("id");
  }

  public function validationDefault(Validator $validator){
    $validator
          ->integer('id')
          ->allowEmpty('id','create');
    $validator
          ->requirePresence('username','create')
          ->notEmpty('username','create');
    $validator
          ->requirePresence('email','create')
          ->notEmpty('email','create');
    $validator
          ->varchar('userImg')
          ->allowEmpty('userImg','create');
    $validator
          ->requirePresence('password','create')
          ->notEmpty('password','create')
          ->alphaNumeric("password")
          ->lengthBetween("password",[6,12],"please enter only 8 to 12 digit");
    $validator
          ->varchar('friends')
          ->allowEmpty('friends','create');
    return $validator;
  }

  public function buildRules(RulesChecker $rules){
    $rules->add($rules->isUnique(array("email")));
    return $rules;
  }
}
 ?>
