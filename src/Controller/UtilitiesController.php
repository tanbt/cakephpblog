<?php
/**
 * Created by PhpStorm.
 * User: tanbt
 * Date: 29/12/2014
 * Time: 08:12
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class UtilitiesController extends AppController{

    public function beforeFilter(Event $event)
    {
        $this->Auth->deny();
    }
    public function isAuthorized($user)
    {
        if($this->Auth->user('id') && $this->Auth->user('role') == 'admin'){
            return true;
        }
        return false;
    }

    private function toAscii($str) {
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        return $clean;
    }

    public function route(){



        echo $this->toAscii("một hai Ba bốn Nghiễn điền");
        exit;
    }

}