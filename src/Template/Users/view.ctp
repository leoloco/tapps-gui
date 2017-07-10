<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="users view large-12 medium-12 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Tpid') ?></th>
            <td><?= h($user->tpid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Org') ?></th>
            <td><?= h($user->org) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($user->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ownerships') ?></h4>
        <?php if (!empty($user->ownerships)): ?>
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
            <?php foreach ($user->ownerships as $ownerships): ?>
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
    <div class="related">
        <h4><?= __('Related Tapps') ?></h4>
        <?php if (!empty($user->tapps)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Tpid') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Version Latest') ?></th>
                <th scope="col"><?= __('Cdn Uri') ?></th>
                <th scope="col"><?= __('Cdn Login') ?></th>
                <th scope="col"><?= __('Cdn Password') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->tapps as $tapps): ?>
            <tr>
                <td><?= h($tapps->id) ?></td>
                <td><?= h($tapps->tpid) ?></td>
                <td><?= h($tapps->name) ?></td>
                <td><?= h($tapps->version_latest) ?></td>
                <td><?= h($tapps->cdn_uri) ?></td>
                <td><?= h($tapps->cdn_login) ?></td>
                <td><?= h($tapps->cdn_password) ?></td>
                <td><?= h($tapps->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tapps', 'action' => 'view', $tapps->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tapps', 'action' => 'edit', $tapps->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tapps', 'action' => 'delete', $tapps->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tapps->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
