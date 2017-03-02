<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>

<?php $this->start('tb_sidebar'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav nav nav-sidebar">
        <li><?= $this->Html->link(__('List Tags'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<?php $this->end(); ?>

<div class="tags form large-9 medium-8 columns content">
	<?= $this->Form->create($tag) ?>
    <fieldset>
		<?= $this->Form->input('title'); ?>
    </fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
