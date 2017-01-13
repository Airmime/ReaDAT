<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 05/02/16
 * @desc Model for categories
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class CategoriesTable extends Table
{
    public function initialize(array $config)
    {
        $this->hasMany('Websites',[
                'className' => 'websites',
                'foreignKey' => 'categories_id']
        );
    }
}