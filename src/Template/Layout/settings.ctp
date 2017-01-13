<!doctype html>
<!--
    "Don't try to be original, just try to be good..."
    Paul RAND
-->
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>Settings - ReadAT.io</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('settings.css') ?>
    <?= $this->Html->css('responsive.css') ?>

    <!-- FONT -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,700' rel='stylesheet' type='text/css'>
</head>
<body>

<?=  $this->element('menu', array('categories' => $categories, 'allcounter' => $allcounter)); //INCLUDE MENU ?>

<!-- CONTENT -->
<div class="content">

    <!-- HEADER -->
    <?=  $this->element('header'); //INCLUDE MENU HEADER ?>

    <!-- BLOC CONTENT -->
    <div class="bloc">

        <!-- TOOLS -->
        <div class="tools">
            <div class="queue">
                <?= $this->fetch('queue');?>
            </div>

            <div class="actions_buttons">
                <?= $this->fetch('actions_buttons');?>
            </div>
        </div><!-- /TOOLS -->

        <!-- SETTINGS MENU -->
        <div class="settings_menu">
            <?= $this->fetch('settings_menu');?>
        </div><!-- /SETTINGS MENU -->

        <!-- CONTENT SETTINGS -->
        <div class="settings_content">
            <?= $this->fetch('settings_account');?>
        </div><!-- /CONTENT SETTINGS -->

    </div><!-- /BLOC -->
</div><!-- /CONTENT -->

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<?= $this->Html->script('menu.js'); ?>
</html>