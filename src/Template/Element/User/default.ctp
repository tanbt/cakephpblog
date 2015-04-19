<?php
if ($user_session){ ?>
    Hi <?= $user_session['username'] ?>, |
    <?= $this->Html->link('Log out', ['prefix' => false, 'controller' => 'users', 'action' => 'logout']); ?>
<?php } else {
    echo $this->Html->link('Log in', ['prefix' => false, 'controller' => 'users', 'action' => 'login']);
}

$this->Html->script('example_user', ['block' => 'script']);