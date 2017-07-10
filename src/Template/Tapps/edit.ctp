<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="tapps form large-12 medium-12 columns content">
    <?= $this->Form->create($tapp) ?>
    <fieldset>
        <legend><?= __('Edit Tapp') ?></legend>
        <?php
            echo $this->Form->control('tpid',['legend'=>'Thingpark ID must be identical as in the thingpark environment']);
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
