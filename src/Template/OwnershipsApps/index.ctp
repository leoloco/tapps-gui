<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="ownershipsApps index large-12 medium-12 columns content">
    <h3><?= __('Ownerships Apps') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tapp_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ownershipsApps as $ownershipsApp): ?>
            <tr>
                <td><?= $this->Number->format($ownershipsApp->id) ?></td>
                <td><?= $ownershipsApp->has('user') ? $this->Html->link($ownershipsApp->user->name, ['controller' => 'Users', 'action' => 'view', $ownershipsApp->user->id]) : '' ?></td>
                <td><?= $ownershipsApp->has('tapp') ? $this->Html->link($ownershipsApp->tapp->name, ['controller' => 'Tapps', 'action' => 'view', $ownershipsApp->tapp->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ownershipsApp->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ownershipsApp->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ownershipsApp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ownershipsApp->id)]) ?>
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
