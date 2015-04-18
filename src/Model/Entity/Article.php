<?php
/**
 * Created by PhpStorm.
 * User: tanub
 * Date: 04/01/2015
 * Time: 10:03
 */

/**
 * http://book.cakephp.org/3.0/en/orm/entities.html
 * 1. Lazy Loading Associations
 *
 */

namespace App\Model\Entity;

use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;


class Article extends Entity{
    use TranslateTrait;

    public function display(){
        return $this->title . " - " . $this->body . "<br/>";
    }

    protected function _setTitle($title){
        var_dump($title);exit;
        return strtoupper($title);
    }

} 