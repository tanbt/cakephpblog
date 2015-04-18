<?php
/**
 * Created by PhpStorm.
 * User: tanbt
 * Date: 30/12/2014
 * Time: 08:31
 */

namespace App\Controller;

use Cake\Event\Event;

/**
Read naming convention: http://book.cakephp.org/3.0/en/intro/conventions.html
 * Multiple word controllers can be any ‘inflected’ form which equals the controller name so:
/redApples
/RedApples
/Red_apples
/red_apples
But REST url is case-insensitive, so redApples and RedApples don't work in REST request
 */
class RestArticlesController extends AppController {


    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');         //require for XML & JSON View

        //http://book.cakephp.org/3.0/en/controllers.html
        //load additional model, can load inside one action
        $this->loadModel('Articles');

        //$this->loadComponent('Rest');
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow();
        $this->loadComponent('Rest');                   //load component on the fly
        if(!$this->Rest->isRestIS($this->request)){
            $this->setAction('not_authorized');
        }
    }

    /**
    GET /api/is/rest_articles.xml HTTP/1.1
    Host: cakephpblog.com
    Cache-Control: no-cache
     */
    public function index()
    {
        $articles = $this->Articles->find('all');
        $this->set([
            'articles' => $articles,
            '_serialize' => ['articles']          //manually render View in XML
        ]);
        //$this->render('/Articles/xml/index');     //specify the XML template
    }
    /**
    http://cakephpblog.com/api/is/rest_articles/1.xml
     */
    public function view($id)
    {
        $article = $this->Articles->get($id);
        $this->set([
            'article' => $article,
            '_serialize' => ['article']
        ]);
    }
    /**
    POST /api/is/rest_articles.xml HTTP/1.1
    Host: cakephpblog.com
    Cache-Control: no-cache

    ----WebKitFormBoundaryE19zNvXGzXaLvS5C
    Content-Disposition: form-data; name="title"
    Blog articles
    new title
    ----WebKitFormBoundaryE19zNvXGzXaLvS5C
    Content-Disposition: form-data; name="body"

    new body
    ----WebKitFormBoundaryE19zNvXGzXaLvS5C
    Content-Disposition: form-data; name="user_id"

    2
    ----WebKitFormBoundaryE19zNvXGzXaLvS5C
     */
    public function add()
    {
        $article = $this->Articles->newEntity($this->request->data);
        if(isset($this->request->data['user_id']) && is_integer($this->request->data['user_id'])){
            $article->user_id = $this->Auth->user($this->request->data['user_id']);
        }

        $result = $this->Articles->save($article);
        if ($result) {
            $message = 'Added Id: ' . $result->id;
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'article' => $article,
            '_serialize' => ['message', 'article']
        ]);
    }
    /**
    PATCH /api/is/rest_articles/10.xml HTTP/1.1
    Host: cakephpblog.com
    Cache-Control: no-cache
    Content-Type: application/x-www-form-urlencoded             //MUST USE THIS CONTENT TYPE
    title=update+using+Patch&body=body+update+using+patch
     **************************************************************************
    PUT /api/is/rest_articles/10.xml HTTP/1.1
    Host: cakephpblog.com
    Cache-Control: no-cache
    Content-Type: application/x-www-form-urlencoded
    title=update++using+PUT&body=A+body+once+again+REST
     **************************************************************************
    PATCH /api/is/rest_articles/10.xml HTTP/1.1
    Host: cakephpblog.com
    Cache-Control: no-cache
    Content-Type: application/x-www-form-urlencoded
    title=update+using+partial+PATCH
     */
    public function edit($id)
    {
        $article = $this->Articles->get($id);
        if ($this->request->is(['patch', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $message = 'Edited Id: ' . $id;
            } else {
                $message = 'Error';
            }
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
    /**
    DELETE /api/is/rest_articles/10.xml HTTP/1.1
    Host: cakephpblog.com
    Cache-Control: no-cache
     */
    public function delete($id)
    {
        $article = $this->Articles->get($id);
        $message = 'Deleted Id: ' . $id;
        if (!$this->Articles->delete($article)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }

    public function select(){
        $articles = $this->Articles->find('all');
        $this->set([
            'articles' => $articles,
            '_serialize' => ['articles']          //manually render View in XML
        ]);
    }

    public function not_authorized(){
        $this->set([
            'message' => 'Not Authorized!',
            '_serialize' => ['message']
        ]);
    }
}