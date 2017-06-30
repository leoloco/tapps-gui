<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="ownerships view large-12 medium-12 columns content">
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
