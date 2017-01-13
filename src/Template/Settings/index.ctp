<?php
$this->layout = 'settings';


/* SETTING TITLE */
$this->start('queue'); ?>
    <p>
        <?= $this->Html->image("settings/settings.png", ["alt" => "Settings"]); ?>
        Settings
    </p>
<?php $this->end();


/* SETTING MENU */
$this->start('settings_menu'); ?>
    <ul>
        <li><a href="<?= $this->Url->build(['controller' => 'Settings','action' => 'index']); ?>">Account</a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Settings','action' => 'password']); ?>">Password</a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Settings','action' => 'categories']); ?>">Categories</a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Settings','action' => 'websites']); ?>">Websites/RSS feed</a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Settings','action' => 'general']); ?>">General settings</a></li>
    </ul>
<?php $this->end();


/* SETTING CONTENT */
$this->start('settings_account'); ?>
    <!-- SETTINGS : ACCOUNTS -->
    <div id="account">
        <div class="title">
            <h1>Account</h1>
            <p>
                Change the basic settings of your account.
            </p>
        </div>
        <div class="infos">
            <?= $this->Form->create(false, array(
                'url' => array('controller' => 'users', 'action' => 'editaccount')
            )); ?>
            <div class="seizure">
                <?php $username = $this->request->session()->read('Auth.User.username')?>
                <?= $this->Form->input('username',array(
                    'value' => $username,
                    'label' => 'Username :',
                    'class' => 'textform'
                )); ?>
            </div>

            <div class="seizure">
            <?php $mail = $this->request->session()->read('Auth.User.mail')?>
            <?= $this->Form->input('mail',array(
                    'value' => $mail,
                    'label' => 'Mail :',
                    'class' => 'textform'
            )); ?>
            </div>

            <?= $this->Form->button('Save',array(
                'class' => 'submit'
            )); ?>

            <?= $this->Flash->render(); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div><!-- /SETTINGS : ACCOUNTS -->
<?php $this->end();