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
            <h1>Password</h1>
            <p>
                Change your password.
            </p>
        </div>
        <div class="infos">
            <?= $this->Form->create(false, array(
                'url' => array('controller' => 'users', 'action' => 'editpassword')
            )); ?>

            <div class="seizure">
                <?= $this->Form->input('password',array(
                    'label' => 'New password :',
                    'class' => 'textform',
                    'name' => 'newpassword'
                )); ?>
            </div>

            <div class="seizure">
                <?= $this->Form->input('password',array(
                    'label' => 'Comfirm new password :',
                    'class' => 'textform',
                    'name' => 'newpasswordbis'
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