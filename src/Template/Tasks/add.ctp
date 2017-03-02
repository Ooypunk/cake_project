<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
?>

<?php $this->start('tb_sidebar'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
</nav>
<?php $this->end(); ?>

<div class="tasks form large-9 medium-8 columns content">
    <?= $this->Form->create($task) ?>
    <fieldset>
        <?php
            echo $this->Form->input('parent_id', ['options' => $parentTasks, 'empty' => ['[root]']]);
            echo $this->Form->input('project_id', ['options' => $projects]);
            echo $this->Form->input('title');
            echo $this->Form->input('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
