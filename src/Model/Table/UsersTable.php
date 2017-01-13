<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 15/03/16
 * @desc Model for users
 */

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('username', 'A username is required')
            ->notEmpty('password', 'A password is required')
            ->notEmpty('mail', 'A mail is required');
    }
}