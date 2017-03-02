<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>

<?php $this->start('tb_sidebar'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav nav nav-sidebar">
		<li><?= $this->Html->link(__('Edit Project'), ['action' => 'edit', $project->id]) ?> </li>
	</ul>
</nav>
<?php $this->end(); ?>

<div class="projects view large-9 medium-8 columns content">
	<table class="vertical-table table">
		<tr>
			<th scope="row"><?= __('Tags') ?></th>
			<td class="space_tags"><?= $this->element('Tags/list_buttons', ['tags' => $project->tags]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Percentage completed') ?></th>
			<td><?= $project->getPercentageCompleted() ?> %</td>
		</tr>
	</table>

	<div class="related tasks">
		<ul class="nav nav-tabs pull-right" role="tablist">
			<li role="presentation" class="active">
				<a href="#tab_tasks_table" aria-controls="tab_tasks_table" role="tab" data-toggle="tab">
					<span class="glyphicon glyphicon-menu-hamburger"></span>
				</a>
			</li>
			<li role="presentation">
				<a href="#tab_tasks_tree" aria-controls="tab_tasks_tree" role="tab" data-toggle="tab">
					<span class="glyphicon glyphicon-tree-conifer"></span>
				</a>
			</li>
		</ul>
		<h4>
			<?= __('Related Tasks') ?>
			<?= $this->Html->link('+', ['controller' => 'tasks', 'action' => 'add', $project->id], ['class' => 'btn btn-primary btn-xs']) ?>
		</h4>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="tab_tasks_table">
				<?php if (!empty($project->unarchived_tasks)): ?>
					<?= $this->element('Tasks/table', ['tasks' => $project->unarchived_tasks]) ?>
				<?php endif; ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="tab_tasks_tree">
				<div id="tasks_tree"></div>
			</div>
		</div>
	</div>
	<div class="related">
		<h4><?= __('Related Projects') ?></h4>
		<?php if (!empty($project->child_projects)): ?>
			<table class="table">
				<tr>
					<th scope="col" class="id"><?= __('Id') ?></th>
					<th scope="col"><?= __('Title') ?></th>
					<th scope="col" class="actions"><?= __('Actions') ?></th>
				</tr>
				<?php foreach ($project->child_projects as $childProjects): ?>
					<tr>
						<td><?= h($childProjects->id) ?></td>
						<td><?= h($childProjects->title) ?></td>
						<td class="actions">
							<?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $childProjects->id], ['class' => 'btn btn-primary']) ?>
							<?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $childProjects->id], ['class' => 'btn btn-primary']) ?>
							<?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $childProjects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childProjects->id), 'class' => 'btn btn-primary']) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
	<input type="hidden" name="project_id" value="<?= $project->id ?>" />
</div>
