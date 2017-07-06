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
            echo $this->Form->control('tp_id');
            echo $this->Form->control('name');
            echo $this->Form->control('creation_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
