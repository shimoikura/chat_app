<div class="container">
  <div class="row">
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- My USER INFORMATION -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<div class="col-md-4">
  <div class="userImg-box">
    <?php echo $this->Html->image('userImages/default-user-image.png',['width'=>'200px']); ?>
  </div>
  <div class="userInfo-box">
    <h3><?php echo $user[0]['username'] ?></h3>
    <?php $friends_num = count($friends) - 1; ?>
    <p><?php echo $friends_num; ?></p>
  </div>
  <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
</div>


<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- A content -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<div class="content-box col-md-8">
<?php foreach ($contents as $value) { ?>
        <p><?php echo $value['body']; ?></p>
        <p><?php echo $value['favo']; ?><span class="glyphicon glyphicon-heart favo" url="<?php echo $this->Url->build(['controller'=>'Contents','action'=>'favo']); ?>" id="<?php echo $value['id'].'favo'; ?>"></span></p>
        <p><?php echo $value['created']; ?></p>
<?php } ?>
</div>

  </div>
</div>
