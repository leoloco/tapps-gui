<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ownerships App'), ['action' => 'edit', $ownershipsApp->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ownerships App'), ['action' => 'delete', $ownershipsApp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ownershipsApp->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ownerships Apps'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ownerships App'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tapps'), ['controller' => 'Tapps', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tapp'), ['controller' => 'Tapps', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ownershipsApps view large-9 medium-8 columns content">
    <h3><?= h($ownershipsApp->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $ownershipsApp->has('user') ? $this->Html->link($ownershipsApp->user->name, ['controller' => 'Users', 'action' => 'view', $ownershipsApp->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tapp') ?></th>
            <td><?= $ownershipsApp->has('tapp') ? $this->Html->link($ownershipsApp->tapp->name, ['controller' => 'Tapps', 'action' => 'view', $ownershipsApp->tapp->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ownershipsApp->id) ?></td>
        </tr>
    </table>
</div>
