<?php
$this->layout = 'home';

/* SETTINGS */
foreach($settings as $setting):
    $showpictures = $setting->showimg;
    $nbtext = $setting->nbtext;
endforeach;

/* COUNTER FOR QUEUE */
$this->start('queue'); ?>
    <p>
        <?= $this->Html->image("content/bloc/tools/queue/star.png", ["alt" => "Favorites"]); ?>
        Favorites
    </p>
<?php $this->end();


/* POSTS */
$this->start('posts');
if(iterator_count($posts)){

    foreach ($posts as $post): ?>
        <article class="post">
            <?php if($post->reading == 0){ ?>
                <div class="unread" onclick="javascript:read(null,null,<?= $post->id ?>,null)" id="read<?= $post->id ?>" title="Mark as read"></div>
            <?php } ?>

            <?php if($post->website->picture != null){ ?>
                <div class="left">
                    <div class="website">
                        <img src="<?= $post->website->picture ?>" alt=""/>
                    </div>
                </div>
            <?php } ?>

            <div class="right" <?php if($post->website->picture == null): ?>style="width: 100%; padding: 0 0 0 20px;"<?php endif ?>>
                <div class="title"><a href="<?= $post->url ?>" target="_blank" onclick="javascript:read(null,null,<?= $post->id ?>,null)"><?= $post->title ?></a></div>
                <div class="text">
                    <p>
                        <a href="<?= $post->url ?>" onclick="javascript:read(null,null,<?= $post->id ?>,null)" target="_blank">
                            <?= $this->Text->truncate(
                                $post->text,
                                $nbtext
                            ) ?> [...]
                        </a>
                    </p>
                </div>

                <div class="picture">
                    <?php if($post->picture != null && $showpictures == 1): ?>
                        <a href="<?= $post->url ?>" target="_blank" onclick="javascript:read(null,null,<?= $post->id ?>,null)">
                            <img src="<?= $post->picture ?>" alt="<?= $post->title ?>"/>
                        </a>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="dateandco">
                        <p>
                            <?php if($post->website->picture == null): ?>
                                <span>
                                <img src="<?= $post->website->favicon; ?>" alt=""/>
                            </span>
                            <?php endif; ?>
                            <?= $post->website->title; ?>, <?= $post->created ?>
                        </p>
                    </div>

                    <div class="socialtools">
                        <div class="fav">
                            <?php if($post->favorite == null){ ?>
                                <a style="cursor: pointer;" onclick="javascript:sendfav('<?= $post->id ?>')"><?= $this->Html->image("content/bloc/post/socialtools/fav_off.png", ["alt" => "Favorite", "id" => $post->id]); ?></a>
                            <?php }else{ ?>
                                <a style="cursor: pointer;" onclick="javascript:sendfav('<?= $post->id ?>')"><?= $this->Html->image("content/bloc/post/socialtools/fav_on.png", ["alt" => "Favorite", "id" => $post->id]); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach;
}else{ ?>
    <div class="first">
        <div class="text">
            <p>
                You can add favorite news to keep at hand.
            </p>
        </div>
    </div>
<?php } ?>

    <div class="paginate">
        <?= $this->Paginator->prev(('Previous')); ?>
        <?= $this->Paginator->next(('Next')); ?>
        <div class="info">
            <p>
                <?= $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total.');?>
            </p>
        </div>
    </div>
<?php $this->end();


/* HOOK RIGHT */
$this->start('hook'); ?>
<?php if(iterator_count($hooks)): ?>
    <div class="element" style="margin: 0 0 0 0;">
        <div class="title">
            <p>
                <?= $this->Html->image("content/hook/fire.png", ["alt" => "Fire"]); ?>
                Most active
            </p>
        </div>
    </div>

    <?php foreach($hooks as $hook): ?>
        <div class="element">
            <div class="text">
                <div class="website">
                    <?php if($hook->picture != null){ ?>
                        <img src="<?= $hook->picture ?>" alt=""/>
                    <?php }else{ ?>
                        <p>
                            <?= substr($hook->title, 0, 2); ?>
                        </p>
                    <?php } ?>
                </div>
                <div class="number">
                    <p>
                        <?= $this->Html->link($hook->title, ['controller' => 'Posts','action' => 'websites', $hook->id]); ?><br/>
                        <span><?= $hook->nb_unread; ?></span> unread posts
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?php $this->end();