<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="transactions form large-12 medium-12 columns content">
    <?= $this->Form->create($transaction) ?>
    <fieldset>
        <legend><?= __('Add Transaction') ?></legend>
        <?php
            echo $this->Form->control('operation');
            echo $this->Form->control('type');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
