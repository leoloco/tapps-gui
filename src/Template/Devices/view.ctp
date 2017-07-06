<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="devices view large-12 medium-12 columns content">
    <h3><?= h($device->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Tp Id') ?></th>
            <td><?= h($device->tp_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($device->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($device->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($device->creation_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ownerships') ?></h4>
        <?php if (!empty($device->ownerships)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Device Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Tapp Id') ?></th>
                <th scope="col"><?= __('Creation Date') ?></th>
                <th scope="col"><?= __('Modified Date') ?></th>
                <th scope="col"><?= __('Href') ?></th>
                <th scope="col"><?= __('Activation') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($device->ownerships as $ownerships): ?>
            <tr>
                <td><?= h($ownerships->id) ?></td>
                <td><?= h($ownerships->device_id) ?></td>
                <td><?= h($ownerships->user_id) ?></td>
                <td><?= h($ownerships->tapp_id) ?></td>
                <td><?= h($ownerships->creation_date) ?></td>
                <td><?= h($ownerships->modified_date) ?></td>
                <td><?= h($ownerships->href) ?></td>
                <td><?= h($ownerships->activation) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Ownerships', 'action' => 'view', $ownerships->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Ownerships', 'action' => 'edit', $ownerships->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ownerships', 'action' => 'delete', $ownerships->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ownerships->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
