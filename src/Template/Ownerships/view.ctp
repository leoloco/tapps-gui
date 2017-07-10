<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ownership'), ['action' => 'edit', $ownership->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ownership'), ['action' => 'delete', $ownership->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ownership->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ownerships'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ownership'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Devices'), ['controller' => 'Devices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Device'), ['controller' => 'Devices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tapps'), ['controller' => 'Tapps', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tapp'), ['controller' => 'Tapps', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ownerships view large-9 medium-8 columns content">
    <h3><?= h($ownership->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Device') ?></th>
            <td><?= $ownership->has('device') ? $this->Html->link($ownership->device->name, ['controller' => 'Devices', 'action' => 'view', $ownership->device->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $ownership->has('user') ? $this->Html->link($ownership->user->name, ['controller' => 'Users', 'action' => 'view', $ownership->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tapp') ?></th>
            <td><?= $ownership->has('tapp') ? $this->Html->link($ownership->tapp->name, ['controller' => 'Tapps', 'action' => 'view', $ownership->tapp->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Href') ?></th>
            <td><?= h($ownership->href) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ownership->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($ownership->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Date') ?></th>
            <td><?= h($ownership->modified_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Activation') ?></th>
            <td><?= $ownership->activation ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
