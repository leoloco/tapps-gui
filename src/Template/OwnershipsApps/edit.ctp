<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="ownershipsApps form large-12 medium-12 columns content">
    <?= $this->Form->create($ownershipsApp) ?>
    <fieldset>
        <legend><?= __('Edit Ownerships App') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('tapp_id', ['options' => $tapps]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
