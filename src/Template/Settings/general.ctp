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
            <h1>General settings</h1>
            <p>
                Change your General settings.
            </p>
        </div>
        <div class="infos">

            <?= $this->Form->create(false, array(
                'url' => array('controller' => 'Settings', 'action' => 'editgeneral')
            )); ?>

            <?php
            foreach($settings as $setting):
                $id = $setting->id;
                $showpictures = $setting->showimg;
                $nbtext = $setting->nbtext;
                $nbshowposts = $setting->nbshowposts;
            endforeach;
            ?>

            <div class="seizure">
                <?= $this->Form->label('Display posts pictures :'); ?>
                <?= '<br/>' ?>
                <div class="seizure">
                    <select name="showpictures">
                        <?php if($showpictures == 1){ ?>
                            <option value="1"selected>Enable</option>
                            <option value="0">Disable</option>
                        <?php }elseif($showpictures == 0){ ?>
                            <option value="0" selected>Disable</option>
                            <option value="1">Enable</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="seizure">
                <?= $this->Form->input('nbtext',array(
                    'value' => $nbtext,
                    'label' => 'Number of characters displayed (1 for unlimited) :',
                    'class' => 'textform'
                )); ?>
            </div>

            <div class="seizure">
                <?= $this->Form->input('nbshowposts',array(
                    'value' => $nbshowposts,
                    'label' => 'Number of posts per page :',
                    'class' => 'textform'
                )); ?>
            </div>

            <?= $this->Form->hidden('id', array(
                'value' => $id,
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