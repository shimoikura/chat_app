<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<!-- A content -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<?php foreach ($contents as $value) { ?>
  <div class="container">
    <div class="row">
      <div class="content-box col-md-6">
        <p><?php echo $value['body']; ?></p>
        <p><?php echo $value['favo']; ?><span class="glyphicon glyphicon-heart favo" url="<?php echo $this->Url->build(['controller'=>'Contents','action'=>'favo']); ?>" id="<?php echo $value['id'].'favo'; ?>"></span></p>
        <p><?php echo $value['created']; ?></p>
      </div>
    </div>
  </div>
<?php } ?>
