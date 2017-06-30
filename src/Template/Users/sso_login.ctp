<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="users form large-12 medium-12 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Connect with your thingpark credentials') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
        ?>
    </fieldset>
    <?= $this->Form->button('Submit', array('formnovalidate' => true)); ?>
    <?= $this->Form->end() ?>
</div>
