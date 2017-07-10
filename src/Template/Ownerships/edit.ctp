<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ownership->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ownership->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ownerships'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Devices'), ['controller' => 'Devices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Device'), ['controller' => 'Devices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tapps'), ['controller' => 'Tapps', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tapp'), ['controller' => 'Tapps', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ownerships form large-9 medium-8 columns content">
    <?= $this->Form->create($ownership) ?>
    <fieldset>
        <legend><?= __('Edit Ownership') ?></legend>
        <?php
            echo $this->Form->control('device_id', ['options' => $devices]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('tapp_id', ['options' => $tapps]);
            echo $this->Form->control('creation_date', ['empty' => true]);
            echo $this->Form->control('modified_date', ['empty' => true]);
            echo $this->Form->control('href');
            echo $this->Form->control('activation');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
