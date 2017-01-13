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
            <h1>Websites/RSS Feed</h1>
            <p>
                Add website.
            </p>
        </div>

        <div class="infos">
            <?= $this->Form->create(false, array(
                'url' => array('controller' => 'websites', 'action' => 'addwebsites')
            )); ?>

            <div class="seizure">
                <?= $this->Form->input('url',array(
                    'label' => 'URL :',
                    'class' => 'textform'
                )); ?>
            </div>

            <div class="seizure">
                <?= $this->Form->input('rssfeed',array(
                    'label' => 'Rss feed :',
                    'class' => 'textform'
                )); ?>
            </div>

            <div class="seizure">
                <?= $this->Form->label('Category :'); ?>
                <?= '<br/>' ?>
                <div class="seizure">
                    <select name="category">
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?= $this->Form->button('Add',array(
                'class' => 'submit'
            )); ?>

           <div class="message">
               <?= $this->Flash->render(); ?>
           </div>
            <?= $this->Form->end(); ?>
        </div>
    </div><!-- /SETTINGS : ACCOUNTS -->
<?php $this->end();