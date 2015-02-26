<?php
/**
 * Created by PhpStorm.
 * User: tanbt
 * Date: 30/12/2014
 * Time: 13:06
 */

namespace App\Controller\Component;

use \Cake\Controller\Component;
use \Cake\Network\Request;

/**
    Add this line if using Trusting Proxy in load balance (header HTTP-X-Forwarded-*)
    $this->request->trustProxy = true;
 */


class RestComponent extends  Component{
    private $api_prefix_url     = 'api/is/';
    private $is_ips             = array('127.0.0.1', '192.168.21.72');

    public function __construct($ComponentRegistry, $data = null){
        if($data){
            $this->api_prefix_url      = $data['api_prefix_url'];
        }
    }

    public function isRestRequest(Request $request){
        return (strpos($request->url, $this->api_prefix_url) !== FALSE);
    }

    public function isFromIS(Request $request){
        return in_array($request->clientIp(), $this->is_ips);
    }

    public function isRestIS(Request $request){
        return ($this->isRestRequest($request) && $this->isFromIS($request));
    }

}