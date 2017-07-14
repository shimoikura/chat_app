<?php
  foreach ($r_users as $value) {
    echo $this->Form->create(null,['url'=>['controller'=>'Users','action'=>'frequest']]);
    echo $value['username'];
    echo $this->Form->input('senderId',['value'=>$value['id'],'type'=>'hidden']);
    echo $this->Form->submit('confirm',['name'=>'confirm']);
    echo $this->Form->submit("cancel");
    echo $this->Form->end();
 ?>
 <?php } ?>
