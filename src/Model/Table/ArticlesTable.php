<?php

/**
 * http://book.cakephp.org/3.0/en/orm/table-objects.html
 *
 * 1. Table convention
 *  class BlogPosts => blog_spots table
 *  1.1. specify table
      public function initialize(array $config)
        {
            $this->table('my_table');
        }
 *
 * 2. entity convention
 * ArticlesTable        => Article entity
 * PurchaseOrdersTable  => PurchaseOrder
 * 2.1. specify entity
 *     public function initialize(array $config)
        {
        $this->entityClass('App\Model\PO');
        }
 *
 * 3. Cake\ORM\TableRegistry::clear
 */

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class ArticlesTable extends Table {
    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        $this->addBehavior('Translate', ['fields' => ['title', 'body']]);       //hook to i18n table
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title')
            ->notEmpty('body')
            ->add('title', [
                'length' => [
                    'rule' => ['minLength', 10],
                    'message' => 'Titles need to be at least 10 characters long',
                ]
            ]);

        return $validator;
    }

    public function isOwnedBy($articleId, $userId)
    {
        return $this->exists(['id' => $articleId, 'user_id' => $userId]);   //check on DB
    }
} 