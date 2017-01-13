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
                Manage your categories.
            </p>
        </div>

        <div class="tab">
            <?php $i = 0; ?>
            <?php foreach ($categories as $cat): ?>
                <div class="ligne" <?php if($i == 1){ $i = 0; ?> style="background-color: #f7f7f7;" <?php }else{ $i++;} ?>>
                    <div class="text">
                        <p>
                            <?= $cat->name; ?>
                        </p>
                    </div>

                    <div class="actions">
                        <p>
                            <?php echo $this->Html->link('Edit', array('controller' => 'categories', 'action' => 'edit', $cat->id)); ?>
                            -
                            <?php
                                if($cat->websites == null){
                                    echo $this->Html->link('Delete', array('controller' => 'categories', 'action' => 'deletecategories', $cat->id));
                                }else{ ?>
                                    <span style="color: #e1e5e9;">Delete</span>
                               <?php  }
                            ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="margin: 0 10px;">
            <?= $this->Flash->render(); ?>
        </div>

        <div class="message">
            Websites are associated with this categories. Move or delete websites before deleting the category.
        </div>

        <?php  ?>

        <div class="button">
            <?php echo $this->Html->link('Add category', array('controller' => 'categories', 'action' => 'add')); ?>
        </div>

    </div><!-- /SETTINGS : ACCOUNTS -->
<?php $this->end();