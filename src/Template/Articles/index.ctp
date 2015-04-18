<h1>Blog articles</h1>

<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Created</th>
        <th>Action</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= $article->id ?></td>
            <td>
                <?= $this->Html->link($article->title, [
                    '_name' => 'friendly_url_job',
                    'id' => $article->id,
                    'title_url' => $article->title_url
                ]);
                ?>

            </td>
            <td>
                <?= $article->created->format(DATE_RFC850) ?>
            </td>
            <td>
                <?php if ($this->Session->read('Auth.User')
                    && ($this->Session->read('Auth.User.role') == 'admin'
                    || $this->Session->read('Auth.User.id') == $article->user_id)){
                    echo $this->Form->postLink(
                            'Delete',
                            ['action' => 'delete', $article->id],
                            ['confirm' => 'Are you sure?']) .
                        " | " . $this->Html->link('Edit', ['action' => 'edit', $article->id]);
                } else {
                    echo 'Delete | Edit';
                } ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
