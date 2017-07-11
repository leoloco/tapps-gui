<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="users form large-12 medium-12 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('username');
            echo $this->Form->control('name');
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('org');
            echo "<div class='input text required'><label>Type</label></div>";
            echo $this->Form->select(
                'type',
                ['vendor','appmanager'],
                ['empty' => '(choose one)']
            );
            echo $this->Form->control('type'); 
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
