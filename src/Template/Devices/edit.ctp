<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="devices form large-12 medium-12 columns content">
    <?= $this->Form->create($device) ?>
    <fieldset>
        <legend><?= __('Edit Device') ?></legend>
        <?php
            echo $this->Form->control('tpid',['legend'=>'Thingpark ID must be identical as in the thingpark environment']);
            echo $this->Form->control('name');
            echo $this->Form->control('creation_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
