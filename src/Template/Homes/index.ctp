<h1>Hello</h1>

<?php
  $this->request->session();
  $userid = $this->request->session()->read('userid');
  echo $this->Form->create(null,['url' => ['controller'=>'Contents','action' => 'add']]);
  echo $this->Form->input("userId",['type'=>'hidden','value'=>$userid]);
  echo $this->Form->input("body",['placeholder'=>'What are you doing now?']);
  echo $this->Form->submit("GO");
  echo $this->Form->end();
 ?>

<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- A content -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<?php foreach ($contents as $value) { ?>
  <div class="container">
    <div class="row">
      <div class="content-box col-md-6">
        <p><?php echo $value['username']; ?></p>
        <p><?php echo $value['body']; ?></p>
        <p><?php echo $value['favo']; ?><span class="glyphicon glyphicon-heart"></span></p>
        <p><?php echo $value['created']; ?></p>
      </div>
    </div>
  </div>
<?php } ?>
