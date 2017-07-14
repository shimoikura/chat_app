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




    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
  <?php $this->request->session(); ?>
  <?php $f_req_num = $this->request->session()->read("f_req_num"); ?>
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
			     <ul class="nav navbar-nav">
				      <li><?php echo $this->Html->link("HOME",'/'); ?></li>
			     </ul>
		    </div>
        <div class="navbar-right">
          <p class="navbar-text">ようこそ</p>
          <p class="navbar-text"><?php echo $f_req_num; ?></p>
          <ul class="nav navbar-nav">
            <li><a href="<?php echo $this->Url->build('/mypage'); ?>" data-toggle="mypage" title="MY PAGE"><span class="glyphicon glyphicon-user"></span></a></li>
            <li><span class="glyphicon glyphicon-bell navbar-text" id="btn-notice" data-toggle="notice" title="NOTICE"></span></li>
            <li><a href="<?php echo $this->Url->build('/login'); ?>" data-toggle="login" title="LOGIN"><span class="glyphicon glyphicon-log-in"></span></a></li>
            <li><a href="<?php echo $this->Url->build('/addfriends'); ?>" data-toggle="addfriends" title="SERCH FRIENDS"><span class="glyphicon glyphicon-zoom-in"></span></a></li>
          </ul>
        </div>
      </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>


    <script>
      $(document).ready(function(){
        $("#btn-notice").click(function(){
          $('[data-toggle="mypage"]').tooltip();
          $('[data-toggle="notice"]').tooltip();
          $('[data-toggle="login"]').tooltip();
          $('[data-toggle="addfriends"]').tooltip();
        });
      });
    </script>
</body>
</html>
