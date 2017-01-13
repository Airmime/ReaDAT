<?php
$this->layout = 'installer';

/* LOGIN */
$this->start('bloc'); ?>
    <div class="bloc">
        <div class="logo">
            <?= $this->Html->image("logo.png", ["alt" => "ReadAT.io"]); ?>
        </div>

        <div class="instructions">
            <h1>Nice ! Database intalled !</h1>
            <p>
                Go to the next step to finalize the installation.
            </p>
        </div>

        <div class="btn">
            <?= $this->Html->link('Next', ['controller' => 'Installer', 'action' => 'user']); ?>
        </div>
    </div>
<?php $this->end();
