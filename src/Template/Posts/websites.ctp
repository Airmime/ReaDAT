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
        <?php foreach ($websites as $web):
            if($web->favicon != null){
                echo $this->Html->image($web->favicon, ["alt" => $web->title, "class" => "website"]);
            }else{
                echo $this->Html->image("favicon.png", ["alt" => "Website", "class" => "website"]);
            }
            echo $web->title;
        endforeach ?>
        <?php if($counter != 0){ ?>
            <span id="counterread"><?= $counter; ?></span>
        <?php } ?>
    </p>
<?php $this->end();


/* ACTIONS BUTTONS */
$this->start('actions_buttons');
foreach ($websites as $web):?>

    <?php if($counter != 0){ ?>
        <button onclick="javascript:read(null,<?= $web->id ?>,null,null)" id="buttonallread">I read every posts</button>
    <?php }

endforeach ?>
<?php $this->end();


/* POSTS */
$this->start('posts');
if(iterator_count($posts)){

    $today = new DateTime();
    $today = $today->format('Y-m-d');
    $latest_date = null;
    $i = 0;

    foreach ($posts as $post):

        $date = $post->created;
        $date = $date->format('Y-m-d');

        if($i == 0){
            $latest_date = $date;
        }

        if($today > $date && $i == 0){?>
            <div class="time">
                <div class="date"><p><?= $date; ?></p></div>
                <div class="line"></div>
            </div>
        <?php }elseif($today == $date && $i == 0){ ?>
            <div class="time">
                <div class="date"><p>Today</p></div>
                <div class="line"></div>
            </div>
        <?php }

        if($date == $latest_date){
            $i = 1;
        }else{
            $i = 0;
        } ?>

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
                There is no news for the moment. You can refresh.
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