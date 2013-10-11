<?php
if (!$this->request->is('ajax') && isset($this->request->params['admin'])):
    $this->Html->script('Route.admin', array('inline' => false));
endif;

$this->extend('/Common/admin_index');
$this->Html
    ->addCrumb('', '/admin', array('icon' => 'home'))
    ->addCrumb(__d('croogo', 'Extensions'), array('plugin' => 'extensions', 'controller' => 'extensions_plugins', 'action' => 'index'))
    ->addCrumb(__d('croogo', 'List Routes'),  array('plugin' => 'route', 'controller' => 'routes', 'action' => 'index'));
?>
<?php $this->start('actions'); ?>
    <li>
        <?php
            echo $this->Html->link(__d('croogo', 'New Route'),
                array('action' => 'add'),
                array('class' => 'btn')
            );
        ?>
    </li>
    <li>
        <?php
            echo $this->Html->link(__d('croogo', 'Enable all'),
                array('action' => 'admin_enable_all'),
                array('class' => 'btn'),
                __d('croogo', 'Enable all routes?')
            );
        ?>
    </li>
    <li>
        <?php
            echo $this->Html->link(__d('croogo', 'Disable all'),
                array('action' => 'admin_disable_all'),
                array('class' => 'btn'),
                __d('croogo', 'Disable all routes?')
            );
        ?>
    </li>
    <li>
        <?php
            echo $this->Html->link(__d('croogo', 'Delete all Routes'),
                array('action' => 'admin_delete_all'),
                array('class' => 'btn'),
                __d('croogo', 'Delete all routes? THIS CANNOT BE UNDONE!')
            );
        ?>
    </li>
    <li>
        <?php
            echo $this->Html->link(__d('croogo', 'Manually Regenerate Custom Routes File'),
                array('action' => 'regenerate_custom_routes_file'),
                array('class' => 'btn')
            );
        ?>
    </li>
<?php $this->end(); ?>

<?php echo $this->Form->create('Route', array('url' => array('controller' => 'routes', 'action' => 'process'))); ?>    
<table class="table table-striped"> 
    <?php
        $tableHeaders = $this->Html->tableHeaders(array(
            $this->Form->checkbox('checkAllAuto'),
            $this->Paginator->sort('id'),
            $this->Paginator->sort('alias'),
            __d('croogo', 'Body'),
            $this->Paginator->sort('status'),
            __d('croogo', 'Actions'),
        ));
    ?>   
    <thead>
	<?php echo $tableHeaders; ?>
    </thead>
    
    <?php
        $rows = array();
        foreach ($routes as $route) {
            $actions = array();
            $actions[] = $this->Croogo->adminRowActions($route['Route']['id']);
            $actions[] = $this->Croogo->adminRowAction('',
                array('action' => 'edit', $route['Route']['id']),
                array('icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit this Route'))
            );
            $actions[] = $this->Croogo->adminRowAction('',
                '#Route' . $route['Route']['id'] . 'Id',
                array('icon' => 'trash', 'tooltip' => __d('croogo', 'Delete this Route'), 'rowAction' => 'delete'),
                __d('croogo', 'Are you sure you want to delete # %s?', $route['Route']['id'])
            );

            $actions = $this->Html->div('item-actions', implode(' ', $actions));
            
            $rows[] = array(
                $this->Form->checkbox('Route.' . $route['Route']['id'] . '.id'),
                h($route['Route']['id']),
                h($route['Route']['alias']),
                h($route['Route']['body']),
                $this->Layout->status($route['Route']['status']),
                $actions,
            );
        }
        echo $this->Html->tableCells($rows);
    ?>
</table>
<div class="row-fluid">
    <div id="bulk-action" class="control-group">
        <?php
            echo $this->Form->input('Route.action', array(
                'label' => false,
                'div' => 'input inline',
                'options' => array(
                    'enable_routes' => __d('croogo', 'Enable Routes'),
                    'disable_routes' => __d('croogo', 'Disable Routes'),
                    'delete' => __d('croogo', 'Delete Routes'),
                ),
                'empty' => true,
            ));
        ?>
        <div class="controls">
            <?php echo $this->Form->end(__d('croogo', 'Submit')); ?>
        </div>
    </div>
</div>
