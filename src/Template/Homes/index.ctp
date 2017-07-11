<h1>Hello</h1>

<?php
  $this->request->session();
  $userid = $this->request->session()->read('userid');
  echo $this->Form->create(null,['url' => ['controller'=>'Contents','action' => 'add']]);
  // echo $this->Form->input("userId",['type'=>'hidden','value'=>$userid]);
  echo $this->Form->input("body",['placeholder'=>'What are you doing now?']);
  echo $this->Form->submit("GO");
  echo $this->Form->end();
 ?>
