<div class="container">
  <div class="row">
    <?php
    $this->request->session();
    $userid = $this->request->session()->read("userid");
    ?>
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <!-- User Box -->
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <?php foreach ($users as $value) { ?>
      <div class="user-box">
        <p><?php echo $value['username']; ?></p>
        <?php echo $this->Form->create(); ?>
        <?php echo $this->Form->input('senderId',['type'=>'hidden','value'=>$userid]); ?>
        <?php echo $this->Form->input('receiverId',['type'=>'hidden','value'=>$value['id']]) ?>
        <?php echo $this->Form->submit('ADD FRIEND'); ?>
        <?php echo $this->Form->end(); ?>
      </div>
    <?php } ?>
  </div>
</div>
