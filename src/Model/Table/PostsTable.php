<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 30/01/16
 * @desc Model for posts
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class PostsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Websites',[
                'className' => 'websites',
                'foreignKey' => 'websites_id'
            ]
        );

        #CounteCache for count unread posts in Website.
        $this->addBehavior('CounterCache', [
            'Websites' => [
                'nb_unread' => [
                    'conditions' => ['reading' => 0]
                ]
            ]
        ]);
    }
}