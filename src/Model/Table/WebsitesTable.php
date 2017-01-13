<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 05/02/16
 * @desc Model for websites
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class WebsitesTable extends Table
{
    public function initialize(array $config)
    {
        $this->hasMany('Posts',[
                'className' => 'posts',
                'foreignKey' => 'websites_id',
                'dependent' => true]
        );

        $this->belongsTo('Categories',[
                'className' => 'Categories',
                'foreignKey' => 'id']
        );
    }
}