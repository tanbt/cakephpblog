<?php
/**
 * Created by PhpStorm.
 * User: tanub
 * Date: 16/12/2014
 * Time: 21:54
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;


class ArticlesController extends AppController {

    public function isAuthorized($user)
    {
        // All registered users can add articles
        if ($this->request->action === 'add') {
            return true;
        }
        // The owner of an article can edit and delete it
        if (in_array($this->request->action, ['edit', 'delete'])) {
            $articleId = (int)$this->request->params['pass'][0];
            if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    public function index() {
//        $articles = TableRegistry::get('Articles');
//        $query = $articles->find();

//        foreach ($query as $row) {
//            // Each row is now an instance of our Article class.
//            $row->set('title', 'set by entity');
//            echo $row->display();
//        }
//        exit;
        $articles = $this->Articles->find('all');
        $this->set(compact('articles'));
    }

    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid article'));
        }
//        \Cake\I18n\I18n::locale('vi');
//        $articles = TableRegistry::get('Articles');
//        $article = $articles->get($id);
//        $article->title = 'Tiêu đề';
//        $article->body = 'Đây là nội dung của bài báo số một.';
//        $articles->save($article);

        $article = $this->Articles->get($id);
        $this->set(compact('article'));
    }
    public function add()
    {
        $article = $this->Articles->newEntity($this->request->data);
        if ($this->request->is('post')) {
            $article->user_id = $this->Auth->user('id');
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);
    }
    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid article'));
        }
        $article = $this->Articles->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }
        $this->set('article', $article);
    }
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }
}