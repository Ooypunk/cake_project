<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>

<?php $this->start('tb_sidebar'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav nav nav-sidebar">
		<li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
	</ul>
</nav>
<?php $this->end(); ?>

<div class="projects index large-9 medium-8 columns content">
	<div class="clearfix">
		<ul class="nav nav-tabs pull-right" role="tablist">
			<li role="presentation" class="active">
				<a href="#tab_projects_table" aria-controls="tab_projects_table" role="tab" data-toggle="tab">
					<span class="glyphicon glyphicon-menu-hamburger"></span>
				</a>
			</li>
			<li role="presentation">
				<a href="#tab_projects_tree" aria-controls="tab_projects_tree" role="tab" data-toggle="tab">
					<span class="glyphicon glyphicon-tree-conifer"></span>
				</a>
			</li>
		</ul>
	</div>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab_projects_table">
			<table class="table table-striped" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th scope="col" class="id"><?= $this->Paginator->sort('id') ?></th>
						<th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
						<th scope="col"><?= $this->Paginator->sort('title') ?></th>
						<th scope="col">#</th>
						<th scope="col">%</th>
						<th scope="col" class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($projects as $project): ?>
						<tr>
							<td><?= $this->Number->format($project->id) ?></td>
							<td><?= $project->has('parent_project') ? $this->Html->link($project->parent_project->title, ['controller' => 'Projects', 'action' => 'view', $project->parent_project->id]) : '[root]' ?></td>
							<td><?= h($project->title) ?></td>
							<td><?= $project->getTasksCount() ?></td>
							<td><?= $project->getPercentageCompleted() ?> %</td>
							<td class="actions">
								<?= $this->Html->link(__('View'), ['action' => 'view', $project->id], ['class' => 'btn btn-primary']) ?>
								<?= $this->Html->link(__('Edit'), ['action' => 'edit', $project->id], ['class' => 'btn btn-primary']) ?>
								<?= $this->Form->postLink(__('Archive'), ['controller' => 'Projects', 'action' => 'archive', $project->id], ['confirm' => __('Are you sure you want to archive # {0}?', $project->id), 'class' => 'btn btn-primary']) ?>
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
		<div role="tabpanel" class="tab-pane" id="tab_projects_tree">
			<button class="btn btn-danger cmd_contextmenu">klik mij</button>
			<div id="projects_tree"></div>
		</div>
	</div>
</div>
