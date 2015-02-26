<?php
/**
 * Created by PhpStorm.
 * User: tanbt
 * Date: 29/12/2014
 * Time: 08:20
 */

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity
{

    // Make all fields mass assignable for now.
    protected $_accessible = ['*' => true];

    /**
     *Rewrite setter (mutator) by adding hashing password
     * @param $password
     * @return string
     */
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

}