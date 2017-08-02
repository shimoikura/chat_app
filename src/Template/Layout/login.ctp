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
  <h1>Login</h1>

  <div class="container box-login">
    <?php echo $this->Form->create(false,array(
      'class'=>'form-signin'
        )); ?>
      <h2 class="form-signin-heading">Please sign in</h2>
      <!-- <?php echo $this->Form->input('targetPage',['type'=>'hidden','value'=>$_GET['reffer']]); ?> -->
      <?php echo $this->Form->input('email',array(
        'class'=>'form-control',
        'placeholder'=>'email',
        'label' => false,
        'type'=>"text")) ?>
      <?php echo $this->Form->input('password',array(
        'class'=>'form-control',
        'placeholder'=>'password',
        'label' => false,
        'type'=>"password")) ?>
      <?php echo $this->Form->submit('submit',array(
        'class'=>'btn btn-primary',
        'type'=>'submit',
        'name'=>'login'
      )) ?>

    <?php echo $this->Form->end(); ?>

    <p style="text-align:center;">New customer? <?php echo $this->Html->link("Here",['action'=>'register']); ?></p>
  </div> <!-- /container -->

    <footer>
    </footer>
</body>
</html>
