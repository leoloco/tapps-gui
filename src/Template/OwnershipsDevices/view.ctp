<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ownerships Device'), ['action' => 'edit', $ownershipsDevice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ownerships Device'), ['action' => 'delete', $ownershipsDevice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ownershipsDevice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ownerships Devices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ownerships Device'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Devices'), ['controller' => 'Devices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Device'), ['controller' => 'Devices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ownershipsDevices view large-9 medium-8 columns content">
    <h3><?= h($ownershipsDevice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Device') ?></th>
            <td><?= $ownershipsDevice->has('device') ? $this->Html->link($ownershipsDevice->device->name, ['controller' => 'Devices', 'action' => 'view', $ownershipsDevice->device->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $ownershipsDevice->has('user') ? $this->Html->link($ownershipsDevice->user->name, ['controller' => 'Users', 'action' => 'view', $ownershipsDevice->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ownershipsDevice->id) ?></td>
        </tr>
    </table>
</div>
