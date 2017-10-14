<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="ownerships form large-12 medium-12 columns content">
    <?= $this->Form->create($ownership) ?>
    <fieldset>
        <legend><?= __('Add Ownership') ?></legend>
        <?php
            echo $this->Form->control('device_id', ['options' => $devices]);
            if($user['type']==='vendor' || $user['type']==='admin'){
                echo $this->Form->control('user_id', ['options' => $users]);
            }
            echo $this->Form->control('tapp_id', ['options' => $tapps]);
            echo $this->Form->control('href');
            echo $this->Form->control('activation');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
