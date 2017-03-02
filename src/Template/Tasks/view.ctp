<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>

<?php $this->start('tb_sidebar'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav nav nav-sidebar">
		<li><?= $this->Html->link(__('Edit Task'), ['action' => 'edit', $task->id]) ?> </li>
		<?php if (!$task->hasChildTasks() && !$task->is_completed) { ?>
			<li><?= $this->Form->postLink(__('Complete Task'), ['controller' => 'Tasks', 'action' => 'complete', $task->id], ['confirm' => __('Are you sure you want to mark "{0}" completed?', $task->title)]) ?></li>
		<?php } ?>
		<li><?= $this->Form->postLink(__('Archive Task'), ['controller' => 'Tasks', 'action' => 'archive', $task->id], ['confirm' => __('Are you sure you want to archive # {0}?', $task->id)]) ?></li>
	</ul>
</nav>
<?php $this->end(); ?>

<div class="tasks view large-9 medium-8 columns content">
	<table class="vertical-table table">
		<tr>
			<th scope="row"><?= __('Parent Task') ?></th>
			<td><?= $task->has('parent_task') ? $this->Html->link($task->parent_task->title, ['controller' => 'Tasks', 'action' => 'view', $task->parent_task->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Project') ?></th>
			<td><?= $task->has('project') ? $this->Html->link($task->project->title, ['controller' => 'Projects', 'action' => 'view', $task->project->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($task->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Title') ?></th>
			<td><?= h($task->title) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Description') ?></th>
			<td><?= $this->Text->autoParagraph(h($task->description)); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Completed') ?></th>
			<td>
				<?php
				if ($task->is_completed) {
					print '<span class="glyphicon glyphicon-check font_large"></span>';
				} else {
					print '<span class="glyphicon glyphicon-unchecked font_large"></span>';
				}
				?>
			</td>
		</tr>
	</table>
	<div class="related">
		<h4><?= __('Related Tasks') ?></h4>
		<?php if (!empty($task->child_tasks)): ?>
			<?= $this->element('Tasks/table', ['tasks' => $task->child_tasks]) ?>
		<?php endif; ?>
	</div>
</div>
