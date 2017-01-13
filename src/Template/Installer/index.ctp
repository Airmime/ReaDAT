<?php
$this->layout = 'installer';

/* LOGIN */
$this->start('bloc'); ?>
    <div class="bloc">
        <div class="logo">
            <?= $this->Html->image("logo.png", ["alt" => "ReadAT.io"]); ?>
        </div>

        <div class="instructions">
            <h1>Hi, welcome on Readat !</h1>
            <p>

                Readat is an open source RSS feed aggregator developing under CakePHP3, currently in beta.<br/><br/>

                In order to configure your database, please enter the username, password and online database of the following file (line 220) :<br/><br/>
                <span><?= CONFIG.'app.php' ?></span><br/>

                In this same file you can also modify the Salt key for more security (line 65).<br/><br/>

                Finally, think about adding your smtp server to receive the password recovery emails (line 170).<br/><br/>

                In case of problem you can consult this page : <a href="http://book.cakephp.org/3.0/fr/installation.html" target="_blank">CakePHP installation</a>
            </p>
        </div>

        <div class="btn">
            <?= $this->Html->link('Install', ['controller' => 'Installer', 'action' => 'database']); ?>
        </div>
    </div>
<?php $this->end();
