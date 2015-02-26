<?php

$this->extend('/Common/Articles/view');
$this->assign('title', $article->title);        //example: block content by text
?>

<p><?= h($article->body) ?></p>

<?php $this->start('created');                  //example block content by HTML define?>
Created: <?= $article->created->format(DATE_RFC850) ?>
<?php $this->end(); ?>

<?php $this->Html->script('example_script', ['block' => 'scriptBottom']);?>