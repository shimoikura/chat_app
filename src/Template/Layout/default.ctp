<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?> -->
    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('cropper.css') ?>
    <?= $this->Html->script(array('jquery.js')) ?>
    <?= $this->Html->script(array('bootstrap.js')) ?>
    <?= $this->Html->script(array('home.js')) ?>
    <?= $this->Html->script(array('mypage.js')) ?>
    <?= $this->Html->script(array('favo.js')) ?>
    <?= $this->Html->script(array('online.js')) ?>
    <?= $this->Html->script(array('message.js')) ?>
    <?= $this->Html->script(array('userImg.js')) ?>
    <?= $this->Html->script(array('cropper.js')) ?>
    <?= $this->Html->script(array('comment.js')) ?>




    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
  <?php $this->request->session(); ?>
  <?php $f_req_num = $this->request->session()->read("f_req_num"); ?>
  <?php $mes_num = $this->request->session()->read("mes_num"); ?>
  <?php $userid = $this->request->session()->read('userid'); ?>
  <?php $username = $this->request->session()->read("username"); ?>
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
			     <ul class="nav navbar-nav">
				      <li><?php echo $this->Html->link("HOME",'/'); ?></li>
			     </ul>
		    </div>
        <div class="navbar-right">
          <ul class="nav navbar-nav">
          <!-- Users -->
            <li class="dropdown" role="menu">
              <a href="" class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class="glyphicon glyphicon-user"></span> <span><?php echo $username; ?></span><span class='caret'></span></a>
              <ul class='dropdown-menu' role='menu'>
                <li><?php echo  $this->Html->link('My page',['controller'=>'Homes','action'=>'mypost']) ?></li>
                <li><a id="logout-link" href=" <?php echo $this->Url->build('/logout',true); ?> ">LOGOUT</a></li>
                <li><a href=" <?php echo $this->Url->build('/login',true); ?> ">Login as another account</a></li>
              </ul>
            </li>
            <!-- MESSAGE -->
            <li  style="cursor:pointer;">
              <p id="btn-message" class="glyphicon glyphicon-envelope navbar-text" data-toggle='message' title="MESSAGE"></p>
              <span id="mes-num" style="<?php if($mes_num ==0){echo 'display:none';} ?>"><?php echo $mes_num; ?></span>
            </li>
            <!-- NOTICE -->
            <li id="li-f_req">
              <a href="<?php echo $this->Url->build('/notice'); ?>" data-toggle="notice" title="NOTICE"><span class="glyphicon glyphicon-bell"></span></a>
              <span id="f-req-num" style="<?php if($f_req_num ==0){echo 'display:none';} ?>"><?php echo $f_req_num; ?></span>
            </li>
            <!-- SERCH FRIENDS -->
            <li><a href="<?php echo $this->Url->build('/addfriends'); ?>" data-toggle="addfriends" title="SERCH FRIENDS"><span class="glyphicon glyphicon-zoom-in"></span></a></li>
          </ul>
        </div>
      </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>

    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <!-- MESSAGE-USER -->
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <div class="message-user-box col-md-3 modal-box">
      <table style=" text-align:right;">
      <?php foreach ($mesusers as $value) { ?>
            <tr>
              <td style="width:20%;"><p style="float:left;"><?php echo $value['username']; ?></p></td>
              <td style="width:80%; padding-left:150px; position:relative;"><button id="<?php echo $value['id']; ?>" class="send-mes glyphicon glyphicon-envelope" url="<?php echo $this->Url->build("/mymessages"); ?>" style="float:left;"></button>
                <span class="message-user-num" style="<?php if($value['count'] ==0){echo 'display:none';} ?>"><?php echo $value['count']; ?></span>
              </td>
            </tr>
        <?php } ?>
      </table>
    </div>
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <!-- MESSAGE-BOX -->
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <div class="message-box col-md-3 modal-box">
      <div class="message-content-box">

      </div>
      <div class="message-send-box">
        <?php echo $this->Form->create(); ?>
        <?php
        echo $this->Form->input('senderId', [
          'type' => 'hidden',
          'value' => $userid
        ]);
        echo $this->Form->input('receiverId',[
          'type' => 'hidden',
          'value' => '',
          'id' => 'mes-receiverId'
        ]);
         ?>
        <table border="1">
          <tr>
            <td><?php echo $this->Form->input('message',['label' => false , 'id' => 'mes-body']); ?></td>
            <?php $url = $this->Url->build('/sendmes'); ?>
            <td><?php echo $this->Form->submit('SEND',['id' => 'send-mes' , 'type' => 'button' ,'url' => $url]); ?></td>
          </tr>
        </table>
        <?php echo $this->Form->end(); ?>
      </div>
    </div>

    <footer>
    </footer>
    <!-- <div id="modal-overlay"></div> -->
</body>
</html>
