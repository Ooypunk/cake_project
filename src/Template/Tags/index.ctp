<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>

<?php $this->start('tb_sidebar'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav nav nav-sidebar">
        <li><?= $this->Html->link(__('New Tag'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<?php $this->end(); ?>

<div class="tags index large-9 medium-8 columns content">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
			<?php foreach ($tags as $tag): ?>
	            <tr>
	                <td><?= $this->Number->format($tag->id) ?></td>
	                <td><?= h($tag->title) ?></td>
	                <td class="actions">
						<?= $this->Html->link(__('View'), ['action' => 'view', $tag->id], ['class' => 'btn btn-primary']) ?>
						<?= $this->Html->link(__('Edit'), ['action' => 'edit', $tag->id], ['class' => 'btn btn-primary']) ?>
						<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id), 'class' => 'btn btn-primary']) ?>
	                </td>
	            </tr>
			<?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
		<?= $this->Paginator->numbers() ?>
		<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
	</div>
</div>
