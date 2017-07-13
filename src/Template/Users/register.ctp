<h1>Register</h1>
<div class="container box-register">
  <?php echo $this->Form->create($user,array('class'=>"form-user-register")); ?>
    <h2>Registration</h2>
    <table>
      <tr>
        <th>User Name</th>
        <td><?php echo $this->Form->input('username',array(
          'class'=>'form-control',
          'placeholder'=>'Username',
          'required'=>false,
          'errors'=>true,
          'label' => false,
          'type'=>"text")) ?>
        </td>
      </tr>
      <tr>
        <th>Email</th>
        <td><?php echo $this->Form->input('email',array(
          'class'=>'form-control',
          'placeholder'=>'email',
          'required'=>false,
          'errors'=>true,
          'label' => false,
          'type'=>"text")) ?>
        </td>
      </tr>
      <tr>
        <th>Password</th>
        <td><?php echo $this->Form->input('password',array(
          'class'=>'form-control',
          'placeholder'=>'password',
          'required'=>false,
          'errors'=>true,
          'label' => false,
          'type'=>"password")) ?>
        </td>
      </tr>
    </table>
    <?php echo $this->Form->input('role',['type'=>'hidden','value'=>'customer']); ?>
    <!-- <?php echo $this->Form->input('Confirm password',array('placeholder'=>'Confirm password','required'=>false,'errors'=>true,'label' => false)) ?> -->
    <!-- <?php echo $this->form->dateTime('registered', ['year' => ['class' => 'year-classname',],'month' => ['class' => 'month-class','data-type' => 'month'],'hour'=>false,'minute'=>false,'meridian'=>false]) ?> -->

    <?php echo $this->Form->submit('submit') ?>
    <!-- <input type="text" class="input-block-level" placeholder="Email address" name="email"> -->

  <?php echo $this->Form->end(); ?>

</div> <!-- /container -->
