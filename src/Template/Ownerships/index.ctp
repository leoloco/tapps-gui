<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="ownerships index large-12 medium-12 columns content">
    <h3><?= __('Ownerships') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('device_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tapp_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('href') ?></th>
                <th scope="col"><?= $this->Paginator->sort('activation') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ownerships as $ownership): ?>
            <tr>
                <td><?= $this->Number->format($ownership->id) ?></td>
                <td><?= $ownership->has('device') ? $this->Html->link($ownership->device->name, ['controller' => 'Devices', 'action' => 'view', $ownership->device->id]) : '' ?></td>
                <td><?= $ownership->has('user') ? $this->Html->link($ownership->user->name, ['controller' => 'Users', 'action' => 'view', $ownership->user->id]) : '' ?></td>
                <td><?= $ownership->has('tapp') ? $this->Html->link($ownership->tapp->name, ['controller' => 'Tapps', 'action' => 'view', $ownership->tapp->id]) : '' ?></td>
                <td><?= h($ownership->creation_date) ?></td>
                <td><?= h($ownership->modified_date) ?></td>
                <td><?= h($ownership->href) ?></td>
                <td><?= h($ownership->activation) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ownership->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ownership->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ownership->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ownership->id)]) ?>
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
