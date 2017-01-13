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
    <div class="account">
        <div class="title">
            <h1>Website</h1>
            <p>
                Edit website.
            </p>
        </div>

        <div class="infos">
            <?= $this->Form->create(false, array(
                'url' => array('controller' => 'websites', 'action' => 'editwebsites')
            )); ?>

            <?php
            foreach($mywebsite as $myweb):
                $id = $myweb->id;
                $title = $myweb->title;
                $url = $myweb->url;
                $rss = $myweb->rssfeed;
                $active = $myweb->active;
                $favicon = $myweb->favicon;
                $picture = $myweb->picture;
                $categories_id = $myweb->categories_id;
            endforeach;
            ?>

            <div class="seizure">
                <?= $this->Form->input('title',array(
                    'value' => $title,
                    'label' => 'Title :',
                    'class' => 'textform'
                )); ?>
            </div>

            <div class="seizure">
                <?= $this->Form->input('url',array(
                    'value' => $url,
                    'label' => 'URL :',
                    'class' => 'textform'
                )); ?>
            </div>

            <div class="seizure">
                <?= $this->Form->input('rssfeed',array(
                    'value' => $rss,
                    'label' => 'Rss Feed :',
                    'class' => 'textform'
                )); ?>
            </div>

            <div class="seizure">
                <?= $this->Form->input('favicon',array(
                    'value' => $favicon,
                    'label' => 'Favicon :',
                    'class' => 'textform'
                )); ?>
            </div>

            <div class="seizure">
                <?= $this->Form->input('picture',array(
                    'value' => $picture,
                    'label' => 'Picture :',
                    'class' => 'textform'
                )); ?>
            </div>

            <div class="seizure">
                <?= $this->Form->label('Category :'); ?>
                <?= '<br/>' ?>
                <div class="seizure">
                    <select name="category">
                        <?php foreach($categories as $cat): ?>
                            <?php if($categories_id == $cat->id){ ?>
                                <option value="<?= $cat->id ?>"selected><?= $cat->name ?></option>
                            <?php }else{ ?>
                                <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                            <?php } ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="seizure">
                <?= $this->Form->label('Status :'); ?>
                <?= '<br/>' ?>
                <div class="seizure">
                    <select name="active">
                        <?php if($active == 1){ ?>
                            <option value="1"selected>Enable</option>
                            <option value="0">Disable</option>
                        <?php }elseif($active == 0){ ?>
                            <option value="0" selected>Disable</option>
                            <option value="1">Enable</option>
                        <?php } ?>
                    </select>
                </div>
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