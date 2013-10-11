<?php
$this->set('showActions', false);
$this->extend('/Common/admin_index');
$this->Html
    ->addCrumb('', '/admin', array('icon' => 'home'))
    ->addCrumb(__d('croogo', 'Extensions'), array('plugin' => 'extensions', 'controller' => 'extensions_plugins', 'action' => 'index'))
    ->addCrumb(__d('croogo', 'List Routes'),  array('plugin' => 'route', 'controller' => 'routes', 'action' => 'index'))
    ->addCrumb(__d('croogo', 'Regenerating Custom Routes File'), $this->here);;
?>

<?php echo $this->Form->create('Route', array('url' => array('plugin' => 'route', 'controller' => 'routes', 'action' => 'index'))); ?>
<div class="row-fluid">
    <div class="span8">
        <ul class="nav nav-tabs">
            <li><a href="#route-main" data-toggle="tab"><?php echo $title_for_layout; ?></a></li>
        </ul>
        <div class="tab-content">
            <div id="route-main" class="tab-pane">
                <textarea style="width: 98%; margin: 25px 0 25px 0; font-size: 14px;" readonly="readonly"><?php echo $code_for_layout; ?></textarea><br />
                <br />
                <?php echo $output_for_layout; ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <?php
            echo $this->Html->beginBox(__d('croogo', 'Actions'))
            . $this->Form->button(__d('croogo', 'Okay'), array('class' => 'btn btn-success'))
            . $this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('button' => 'danger'))
            . $this->Html->endBox();
        ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>