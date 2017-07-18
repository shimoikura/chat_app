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
    <?= $this->Html->script(array('jquery-3.2.1.js')) ?>
    <?= $this->Html->script(array('bootstrap.js')) ?>
    <?= $this->Html->script(array('home.js')) ?>




    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
  <?php $this->request->session(); ?>
  <?php $f_req_num = $this->request->session()->read("f_req_num"); ?>
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
                <li><a href="<?php echo $this->Url->build('/mypage'); ?>">MY PAGE</a></li>
                <li><a href=" <?php echo $this->Url->build('/logout',true); ?> ">LOGOUT</a></li>
                <li><a href=" <?php echo $this->Url->build('/login',true); ?> ">Login as another account</a></li>
              </ul>
            </li>
            <!-- MESSAGE -->
            <li  style="cursor:pointer;"><button id="btn-message" class="glyphicon glyphicon-envelope navbar-text" data-toggle='message' title="MESSAGE"></button></li>
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
    <div class="message-user-box" style="display:none">
      <?php foreach ($mesusers as $value) { ?>
        <p><?php echo $value['username']; ?></p>
        <button id="<?php echo $value['id']; ?>" class="send-mes">SEND MESSAGE</button>
      <?php } ?>
    </div>
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <!-- MESSAGE-BOX -->
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <div class="message-box" style="display:none">
      <?php foreach ($mes as $mess) {
        echo $mess['message'];
      } ?>
      <?php echo $this->Form->create(false,['url' => '/sendmes']); ?>
      <?php
      echo $this->Form->input('senderId', [
        'type' => 'hidden',
        'value' => $userid
      ]);
      echo $this->Form->input('receiverId',[
        'id' => 'mes-receiverId',
        'type' => 'hidden',
        'value' => ''
      ]);
      echo $this->Form->input('message');
      echo $this->Form->submit('SEND');
       ?>
      <?php echo $this->Form->end(); ?>
    </div>

    <footer>
    </footer>
</body>
</html>
