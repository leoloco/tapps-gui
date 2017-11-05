<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="ownershipsDevices view large-12 medium-12 columns content">
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
