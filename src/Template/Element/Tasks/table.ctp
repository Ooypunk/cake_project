<table class="table">
	<tr>
		<th scope="col"><?= __('Id') ?></th>
		<th scope="col"><?= __('Title') ?></th>
		<th scope="col"><?= __('Completed') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	<?php foreach ($tasks as $task): ?>
		<tr>
			<td><?= h($task->id) ?></td>
			<td><?= h($task->title) ?></td>
			<td><?= $task->getPctCompleted() ?>%</td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'Tasks', 'action' => 'view', $task->id], ['class' => 'btn btn-primary']) ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'Tasks', 'action' => 'edit', $task->id], ['class' => 'btn btn-primary']) ?>
				<?= $this->Form->postLink(__('Archive'), ['controller' => 'Tasks', 'action' => 'archive', $task->id], ['confirm' => __('Are you sure you want to archive # {0}?', $task->id), 'class' => 'btn btn-primary']) ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
