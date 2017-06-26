<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Tapp'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ownerships'), ['controller' => 'Ownerships', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ownership'), ['controller' => 'Ownerships', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tapps index large-9 medium-8 columns content">
    <h3><?= __('Tapps') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tp_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('version_latest') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cdn_uri') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cdn_login') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cdn_password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tapps as $tapp): ?>
            <tr>
                <td><?= $this->Number->format($tapp->id) ?></td>
                <td><?= h($tapp->tp_id) ?></td>
                <td><?= h($tapp->name) ?></td>
                <td><?= h($tapp->version_latest) ?></td>
                <td><?= h($tapp->cdn_uri) ?></td>
                <td><?= h($tapp->cdn_login) ?></td>
                <td><?= h($tapp->cdn_password) ?></td>
                <td><?= $tapp->has('user') ? $this->Html->link($tapp->user->name, ['controller' => 'Users', 'action' => 'view', $tapp->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $tapp->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tapp->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tapp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tapp->id)]) ?>
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
