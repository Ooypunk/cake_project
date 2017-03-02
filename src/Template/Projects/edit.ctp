<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->Html->css('select2/select2', ['block' => true]);
$this->Html->script('select2/select2', ['block' => true]);
$this->Html->script('controllers/projects/select2', ['block' => true]);
?>

<?php $this->start('tb_sidebar'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav nav nav-sidebar"> 
		<li><?= $this->Form->postLink(__('Archive Project'), ['controller' => 'Projects', 'action' => 'archive', $project->id], ['confirm' => __('Are you sure you want to archive "{0}"?', $project->title)]) ?></li>
		<li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
	</ul>
</nav>
<?php $this->end(); ?>

<div class="projects form large-9 medium-8 columns content">
	<?= $this->Form->create($project) ?>
	<fieldset>
		<?php
		echo $this->Form->input('parent_id', ['options' => $parentProjects, 'empty' => ['[root]']]);
		echo $this->Form->input('title');
		echo $this->Form->input('tags._ids', ['options' => $tags]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
	<?= $this->Html->link(__('Cancel'), ['action' => 'view', $project->id], ['class' => 'btn btn-default']) ?>
	<?= $this->Form->end() ?>
</div>
