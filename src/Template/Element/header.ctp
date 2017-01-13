<div class="sidebar_responsive">

    <!-- MENU -->
    <nav class="menu">
        <ul>
            <li>
                <a href="<?= $this->Url->build(['controller' => 'Posts','action' => 'index']); ?>">
                    <?= $this->Html->image("sidebare/home.png", ["alt" => "Home"]); ?>
                    Home
                </a>
            </li>
            <li>
                <a href="<?= $this->Url->build(['controller' => 'Posts','action' => 'favorites']); ?>">
                    <?= $this->Html->image("sidebare/favourites.png", ["alt" => "Favorite"]); ?>
                    Favourites
                </a>
            </li>
        </ul>
    </nav><!-- /MENU -->

    <!-- FOLLOWED -->
    <div class="followed">
        <div class="folder">
            <div class="title">
                <a href="<?= $this->Url->build(['controller' => 'Posts','action' => 'index']); ?>">
                    <?= $this->Html->image("sidebare/all.png", ["alt" => "All"]); ?>
                    All
                </a>
                <?php if($allcounter != null || $allcounter != 0): ?>
                    <span><?= $allcounter ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div><!-- /FOLLOWED -->

    <!-- FOLLOWED -->
    <div class="followed">
        <?php foreach ($categories as $cat): ?>
            <div class="folder">
                <div class="title">
                    <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'Category', $cat->id]); ?>">
                        <?= $this->Html->image("sidebare/bottom.png", ["alt" => "All"]); ?>
                        <?= $cat->name; ?>
                    </a>
                </div>

                <nav>
                    <ul>
                        <?php foreach ($cat->websites as $website): ?>
                            <li>
                                <a href="<?= $this->Url->build(['controller' => 'Posts','action' => 'websites', $website->id]); ?>">
                                    <?php
                                    if($website->favicon != null){
                                        echo $this->Html->image($website->favicon);
                                    }else{
                                        echo $this->Html->image('favicon.png', ["alt" => $website->title]);
                                    }
                                    ?>
                                    <?= $website->title ?>
                                    <?php
                                    if( $website->nb_unread != null || $website->nb_unread != 0):?>
                                        <span><?= $website->nb_unread ?></span>
                                    <?php endif ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="header">
    <div class="burgerresponsive">
        <p>
            <a id="show-menu">Menu</a>
        </p>
    </div>
    <ul>
        <li><a href="<?=  $this->Url->build(['controller' => 'Settings','action' => 'index']) ?>">Settings</a></li>
        <li><a href="<?=  $this->Url->build(['controller' => 'Users','action' => 'logout']) ?>">Logout</a></li>
    </ul>
</div><!-- /HEADER -->