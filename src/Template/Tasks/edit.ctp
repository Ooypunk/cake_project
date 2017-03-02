<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>

<?php $this->start('tb_sidebar'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav nav nav-sidebar">
        <li><?= $this->Html->link(__('Project'), ['controller' => 'Projects', 'action' => 'view', $task->project_id]) ?></li>
    </ul>
</nav>
<?php $this->end(); ?>

<div class="tasks form large-9 medium-8 columns content">
	<?= $this->Form->create($task) ?>
    <fieldset>
		<?php
		echo $this->Form->input('parent_id', ['options' => $parentTasks]);
		echo $this->Form->input('project_id', ['options' => $projects]);
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->control('is_completed', ['type' => 'checkbox']);
		?>
    </fieldset>
	<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
	<?= $this->Html->link(__('Cancel'), ['action' => 'view', $task->id], ['class' => 'btn btn-default']) ?>
	<?= $this->Form->end() ?>
</div>
