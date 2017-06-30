<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="transactions view large-12 medium-12 columns content">
    <h3><?= h($transaction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Operation') ?></th>
            <td><?= h($transaction->operation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($transaction->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($transaction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $transaction->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
