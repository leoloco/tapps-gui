<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="tapps form large-9 medium-8 columns content">
    <?= $this->Form->create($tapp) ?>
    <fieldset>
        <legend><?= __('Edit Tapp') ?></legend>
        <?php
            echo $this->Form->control('tp_id');
            echo $this->Form->control('name');
            echo $this->Form->control('version_latest');
            echo $this->Form->control('cdn_uri');
            echo $this->Form->control('cdn_login');
            echo $this->Form->control('cdn_password');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
