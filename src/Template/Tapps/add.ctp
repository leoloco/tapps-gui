<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Tapps'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ownerships'), ['controller' => 'Ownerships', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ownership'), ['controller' => 'Ownerships', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tapps form large-9 medium-8 columns content">
    <?= $this->Form->create($tapp) ?>
    <fieldset>
        <legend><?= __('Add Tapp') ?></legend>
        <?php
            echo $this->Form->control('tp_id');
            echo $this->Form->control('name');
            echo $this->Form->control('version_latest');
            echo $this->Form->control('cdn_uri');
            echo $this->Form->control('cdn_login');
            echo $this->Form->control('cdn_password');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
