<?php
$this->layout = 'login';


/* LOGIN */
$this->start('login'); ?>
    <div class="login">
        <div class="logo">
            <?= $this->Html->image("logo.png", ["alt" => "ReadAT.io"]); ?>
        </div>

        <div class="form">
            <?= $this->Form->create(); ?>
            <?= $this->Form->input('username',array(
                'label' => false,
                'class' => 'username',
                'placeholder'=> 'Username'
            )); ?>
            <?= $this->Form->input('password',array(
                'label' => false,
                'class' => 'key',
                'placeholder'=> 'Password'
            )); ?>
            <?= $this->Form->button('Login',array(
                'class' => 'submit'
            )); ?>
            <?= $this->Flash->render(); ?>
            <?= $this->Form->end(); ?>

        </div>
        <div class="password">
            <a href="<?= $this->Url->build(['controller' => 'Users','action' => 'forgot']); ?>">Forgot password ?</a>
        </div>
    </div>
<?php $this->end();