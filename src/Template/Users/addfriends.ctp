<div class="container">
  <div class="row">
    <?php
    $this->request->session();
    $userid = $this->request->session()->read("userid");
    ?>
    <?php
      //Friendリクエストの状況を確認する関数
      function frequest( $f , $sender , $receiver ){
        foreach ($f as $key) {
          //自分がすでにリクエストを送っている場合
          if ( ($key['senderId'] == $sender) && ($key['receiverId'] == $receiver) ) {
            return 'a';
            break;
          }
          //相手からすでにリクエストが送られている場合
          elseif ( ($key['senderId'] == $receiver) && ($key['receiverId'] == $sender) ) {
            return 'b';
            break;
          }
          //お互いにまだリクエスト送っていない場合
          else {
            continue;
          }
          return 'c';
        }
      }
     ?>

    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <!-- User Box -->
    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
    <?php foreach ($users as $value) { ?>
      <div class="user-box">
        <?php echo $this->Form->create(); ?>
        <?php
            if ( frequest($f_requests,$userid,$value['id']) == 'a') {
              echo "<p>". $value['username']. "</p>";
              echo $this->Form->submit('CANCEL REQUEST',[ 'name' => 'cancel' ]);
            }
            elseif (frequest($f_requests,$userid,$value['id']) == 'b') {
              continue;
            }
            else {
              echo "<p>". $value['username']. "</p>";
              echo $this->Form->submit('ADD FRIEND',[ 'name' => 'send' ]);
            }
        ?>
        <?php echo $this->Form->input('senderId',['type'=>'hidden','value'=>$userid]); ?>
        <?php echo $this->Form->input('receiverId',['type'=>'hidden','value'=>$value['id']]) ?>

        <?php echo $this->Form->end(); ?>
      </div>
    <?php } ?>
  </div>
</div>
