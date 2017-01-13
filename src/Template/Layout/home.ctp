<!doctype html>
<!--
    "Don't try to be original, just try to be good..."
    Paul RAND
-->
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>ReadAT.io</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <?= $this->Html->css('style.css') ?>
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

            <div class="reload">
                <button onclick="javascript:reload()">
                    Refresh
                    <?= $this->Html->image("content/bloc/tools/reload/reload.gif", ["alt" => "Reload", "id" => "reload_img"]); ?>
                </button>

                <p class="refresh">
                    <a onclick="javascript:window.location.reload();">Refresh page.</a>
                </p>
            </div>
        </div><!-- /TOOLS -->

        <!-- TIMELINE -->
        <div class="timeline">
            <?= $this->fetch('posts');?>
        </div><!-- /TIMELINE -->

        <div class="hooks">
            <div class="hook">
                <?= $this->fetch('hook');?>
            </div>
        </div>

    </div><!-- /BLOC -->
</div><!-- /CONTENT -->

</body>
<script type="text/javascript">
    var myUrlRead = '<?php echo $this->Url->build([
    'controller' => 'Posts',
    'action' => 'read'
]); ?>';
</script>
<script type="text/javascript">
    var myUrlFavorite = '<?php echo $this->Url->build([
    'controller' => 'Posts',
    'action' => 'favorite'
]); ?>';
</script>
<script type="text/javascript">
    var myUrlReload = '<?php echo $this->Url->build([
    'controller' => 'Websites',
    'action' => 'reload'
]); ?>';
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<?= $this->Html->script('jquery.sticky.js'); ?>
<?= $this->Html->script('favoris.js'); ?>
<?= $this->Html->script('read.js'); ?>
<?= $this->Html->script('reload.js'); ?>
<?= $this->Html->script('menu.js'); ?>
<script>
    $(window).load(function(){
        $(".hook").sticky({ topSpacing: 0 });
    });
</script>
</html>