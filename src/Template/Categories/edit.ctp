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
                Edit category.
            </p>
        </div>

        <div class="infos">
            <?= $this->Form->create(false, array(
                'url' => array('controller' => 'categories', 'action' => 'editcategories')
            )); ?>

            <?php foreach($mycategories as $mycat): $mycatname = $mycat->name; $myid = $mycat->id; endforeach; ?>

            <div class="seizure">
                <?= $this->Form->input('name',array(
                    'value' => $mycatname,
                    'label' => 'Edit yout category name :',
                    'class' => 'textform'
                )); ?>
            </div>

            <?= $this->Form->hidden('id', array(
                'value' => $myid,
                'name' => 'id'
            )); ?>

            <?= $this->Form->button('Save',array(
                'class' => 'submit'
            )); ?>

            <?= $this->Flash->render(); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div><!-- /SETTINGS : ACCOUNTS -->
<?php $this->end();