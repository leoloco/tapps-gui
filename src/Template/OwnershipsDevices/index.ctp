<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="ownershipsDevices index large-12 medium-12 columns content">
    <h3><?= __('Ownerships Devices') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('device_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ownershipsDevices as $ownershipsDevice): ?>
            <tr>
                <td><?= $this->Number->format($ownershipsDevice->id) ?></td>
                <td><?= $ownershipsDevice->has('device') ? $this->Html->link($ownershipsDevice->device->name, ['controller' => 'Devices', 'action' => 'view', $ownershipsDevice->device->id]) : '' ?></td>
                <td><?= $ownershipsDevice->has('user') ? $this->Html->link($ownershipsDevice->user->name, ['controller' => 'Users', 'action' => 'view', $ownershipsDevice->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ownershipsDevice->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ownershipsDevice->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ownershipsDevice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ownershipsDevice->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
