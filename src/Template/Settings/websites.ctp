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
                Manage your websites/RSS Feed.
            </p>
        </div>

        <div class="tab">
            <?php $i = 0; ?>
            <?php foreach ($websites as $web): ?>
                <div class="ligne" <?php if($i == 1){ $i = 0; ?> style="background-color: #f7f7f7;" <?php }else{ $i++;} ?>>
                    <div class="text">
                        <p>
                            <?= $web->title; ?>
                            <?php if($web->active == 1){ ?>
                                <span style="background-color: #d4eed7;">Enable</span>
                            <?php }else{ ?>
                                <span style="background-color: #ecc9c9;">Disable</span>
                            <?php } ?>
                        </p>
                    </div>

                    <div class="actions">
                        <p>
                            <?php echo $this->Html->link('Edit', array('controller' => 'websites', 'action' => 'edit', $web->id)); ?>
                            -
                            <?php echo $this->Html->link('Delete', array('controller' => 'websites', 'action' => 'deletewebsite', $web->id)); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="tab">
            <?= $this->Flash->render(); ?>
        </div>

        <div class="button">
            <?php echo $this->Html->link('Add website', array('controller' => 'websites', 'action' => 'add')); ?>
        </div>

    </div><!-- /SETTINGS : ACCOUNTS -->
<?php $this->end();