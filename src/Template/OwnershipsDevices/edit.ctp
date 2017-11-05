<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="ownershipsDevices form large-12 medium-12 columns content">
    <?= $this->Form->create($ownershipsDevice) ?>
    <fieldset>
        <legend><?= __('Edit Ownerships Device') ?></legend>
        <?php
            echo $this->Form->control('device_id', ['options' => $devices]);
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
