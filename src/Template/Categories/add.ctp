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
            <h1>Categories</h1>
            <p>
                Add category.
            </p>
        </div>

        <div class="infos">
            <?= $this->Form->create(false, array(
                'url' => array('controller' => 'categories', 'action' => 'addcategories')
            )); ?>

            <div class="seizure">
                <?= $this->Form->input('name',array(
                    'label' => 'Name of the new category :',
                    'class' => 'textform'
                )); ?>
            </div>

            <?= $this->Form->button('Add',array(
                'class' => 'submit'
            )); ?>

            <?= $this->Flash->render(); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div><!-- /SETTINGS : ACCOUNTS -->
<?php $this->end();