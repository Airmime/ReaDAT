<?php
$this->layout = 'login';


/* LOGIN */
$this->start('login'); ?>
    <div class="login">
        <div class="logo">
            <?= $this->Html->image("logo.png", ["alt" => "ReadAT.io"]); ?>
        </div>

        <div class="form">
            <?= $this->Form->create(null, ['url' => ['action' => 'sendpassword']]); ?>
            <?= $this->Form->input('mail',array(
                'label' => false,
                'class' => 'email',
                'placeholder'=> 'Email'
            )); ?>

            <?= $this->Form->button('Send me my password',array(
                'class' => 'submit'
            )); ?>

            <?= $this->Flash->render(); ?>
            <?= $this->Form->end(); ?>

        </div>
    </div>
<?php $this->end();