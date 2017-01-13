<?php
$this->layout = 'installer';

/* LOGIN */
$this->start('bloc'); ?>
    <div class="bloc">
        <div class="logo">
            <?= $this->Html->image("logo.png", ["alt" => "ReadAT.io"]); ?>
        </div>

        <div class="instructions">
            <h1>Well, let's go !</h1>
            <p>

                Your web app is ready !<br/>
                The default password is admin/admin, think to change it !<br/><br/>

                Enjoy!
            </p>
        </div>

        <div class="btn">
            <?= $this->Html->link('Login', ['controller' => 'Posts', 'action' => 'index']); ?>
        </div>
    </div>
<?php $this->end();
