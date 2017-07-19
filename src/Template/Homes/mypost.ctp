<div class="container">
  <div class="row">
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- My USER INFORMATION -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<div class="col-md-4 col-sm-12">
  <div class="userImg-box">
    <?php echo $this->Html->image('userImages/default-user-image.png',['width'=>'200px']); ?>
  </div>
  <div class="userInfo-box">
    <table class="mypage-user">
      <tr>
        <td rowspan="2"><h3 style=" margin:0;"><?php echo $user[0]['username'] ?></h3></td>
        <?php $friends_num = count($friends) - 1; ?>
        <th>friends</th>
      </tr>
      <tr>
        <td><a href="#" id="flist" url="<?php echo $this->Url->build('/online'); ?>"><?php echo $friends_num; ?></a></td>
      </tr>
    </table>
  </div>
  <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>

  <!-- Friends LIST BOX -->
  <div class="friends-list-box">
    <p>FRIENDS LIST</p>
    <?php foreach ($fusers as $fuser) { ?>
      <div class="fuser-box">
        <p style="float:left; width:70%;"><?php echo $fuser['username']; ?></p>
        <span id="<?php echo $fuser['id']; ?>online" class="glyphicon glyphicon-record" style="float:left; width:30%;"></span>
      </div>
    <?php } ?>
  </div>
</div>


<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- A content -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<div class="col-md-8 col-sm-12">
<?php foreach ($contents as $value) { ?>
        <p><?php echo $value['body']; ?></p>
        <p><?php echo $value['favo']; ?><span class="glyphicon glyphicon-heart favo" url="<?php echo $this->Url->build(['controller'=>'Contents','action'=>'favo']); ?>" id="<?php echo $value['id'].'favo'; ?>"></span></p>
        <p><?php echo $value['createdDate']->format('Y/m/d H:i'); ?></p>
<?php } ?>
</div>

  </div>
</div>
