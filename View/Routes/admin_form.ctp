<?php

$this->extend('/Common/admin_edit');

$action = $this->request->params['action'];
if ($action == 'admin_edit') {
    $this->viewVars['title_for_layout'] = __d('croogo', 'Edit Route');
} else {
    $this->viewVars['title_for_layout'] = __d('croogo', 'Add Route');
}

$crumb = $action == 'admin_add' ? __d('croogo', 'Add') : $this->data['Route']['alias'];
$this->Html
    ->addCrumb('', '/admin', array('icon' => 'home'))
    ->addCrumb(__d('croogo', 'List Routes'),
        array(
            'plugin' => 'route',
            'controller' => 'routes',
            'action' => 'index'
        )
    )
    ->addCrumb($crumb, $this->here);
?>

<?php echo $this->Form->create('Route');?>
<div class="row-fluid">
    <div class="span8">
        <ul class="nav nav-tabs">
            <li><a href="#route-main" data-toggle="tab"><?php echo __d('croogo', 'Route'); ?></a></li>
        </ul>
        <div class="tab-content">
            <div id="route-main" class="tab-pane">
                <?php 
                    echo $this->Form->input('id');
                    
                    $this->Form->inputDefaults(array(
                        'label' => false,
                        'class' => 'span10',
                    ));
                    
                    echo $this->Form->input('alias', array(
                        'label' => __d('croogo', 'Alias')
                    ))
                    . $this->Form->input('body', array(
                        'label' => __d('croogo', 'Body')
                    ));
                ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <?php
            echo $this->Html->beginBox(__d('croogo', 'Actions'))
            . $this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-success'))
            . $this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('button' => 'danger'))
            . $this->Form->input('status', array('label' => __d('croogo', 'Status'), 'class' => false))
            . $this->Html->endBox();
        ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
