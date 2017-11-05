<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="ownershipsApps view large-12 medium-12 columns content">
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
