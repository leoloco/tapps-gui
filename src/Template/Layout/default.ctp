<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <?php
                        if(isset($loggedIn)){
                            echo '<h1><a href="#"> Logged in as ' . $loggedIn['username'].'</a></h1>';
                        }
                    ?> 
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <li>
                    <?php
                        echo $this->Html->link('logout', ['controller' => 'users', 'action' => 'logout']);
                    ?>  
                </li>
                <li>
                    <?php
                        echo $this->Html->link('login', ['controller' => 'users', 'action' => 'login']);
                    ?>  
                </li>
            </ul>
        </div>
    </nav>
     <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php
            if(isset($loggedIn)){
                switch ($loggedIn['type']){
                    case 'subscriber':
                        echo "<li>";
                        echo $this->Html->link(__('List Ownerships'), ['controller' => 'Ownerships', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('Add Ownership'), ['controller' => 'Ownerships', 'action' => 'add']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Tapps'), ['controller' => 'Tapps', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Ownerships Apps'), ['controller'=>'OwnershipsApps', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Ownerships Devices'), ['controller'=>'OwnershipsDevices', 'action' => 'index']);
                        echo "</li>";
                        break;
                    case 'appmanager':
                        echo "<li>";
                        echo $this->Html->link(__('List Tapps'), ['controller' => 'Tapps', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('New Tapp'), ['controller' => 'Tapps', 'action' => 'add']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Devices'), ['controller' => 'Devices', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('New Device'), ['controller' => 'Devices', 'action' => 'add']);
                        echo "</li>";
                        break;
                    case 'vendor':
                        echo "<li>";
                        echo $this->Html->link(__('List Devices'), ['controller' => 'Devices', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Ownerships'), ['controller' => 'Ownerships', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('New Ownership'), ['controller' => 'Ownerships', 'action' => 'add']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Ownerships Apps'), ['controller'=>'OwnershipsApps', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Ownerships Devices'), ['controller'=>'OwnershipsDevices', 'action' => 'index']);
                        echo "</li>";
                        break;
                    case 'admin':
                        echo "<li>";
                        echo $this->Html->link(__('List Tapps'), ['controller' => 'Tapps', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('Add Tapps'), ['controller' => 'Tapps', 'action' => 'add']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Ownerships'), ['controller' => 'Ownerships', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('Add Ownerships'), ['controller' => 'Ownerships', 'action' => 'add']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Devices'), ['controller' => 'Devices', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('Add Devices'), ['controller' => 'Devices', 'action' => 'add']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Users'), ['controller'=>'Users', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('Add Users'), ['controller'=>'Users', 'action' => 'add']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Ownerships Apps'), ['controller'=>'OwnershipsApps', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('Add Ownerships Apps'), ['controller'=>'OwnershipsApps', 'action' => 'add']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('List Ownerships Devices'), ['controller'=>'OwnershipsDevices', 'action' => 'index']);
                        echo "</li>";
                        echo "<li>";
                        echo $this->Html->link(__('Add Ownerships Devices'), ['controller'=>'OwnershipsDevices', 'action' => 'add']);
                        echo "</li>";
                        
                        break;
                    default:
                        echo "<li>";
                        echo $this->Html->link(__('Signup'), ['action' => 'add']);
                        echo "</li>";
                        break;
                }
            } else {
                echo "<li>";
                echo $this->Html->link(__('Add user'), ['action' => 'add']);
                echo "</li>";
                echo "<li>";
                echo $this->Html->link(__('Login'), ['action' => 'login']);
                echo "</li>";
            }
        ?> 
    </ul>
</nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
