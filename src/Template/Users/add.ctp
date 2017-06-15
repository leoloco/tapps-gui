<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ownerships'), ['controller' => 'Ownerships', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ownership'), ['controller' => 'Ownerships', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tapps'), ['controller' => 'Tapps', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tapp'), ['controller' => 'Tapps', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('username');
            echo $this->Form->control('name');
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('org');
            $options = ['appmanager' => 'appmanager','subscriber' => 'subscriber','vendor' => 'vendor'];
            echo "<div class='input text required'><label>Type</label></div>";
            echo $this->Form->select('type', $options, ['empty' => true]);
            
        ?>
    </fieldset>
    <?= $this->Form->button('Submit', array('formnovalidate' => true)); ?>
    <?= $this->Form->end() ?>
</div>
