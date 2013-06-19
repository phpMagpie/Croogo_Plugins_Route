<?php

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Routes'), array('controller' => 'route', 'action' => 'index'));

if ($this->request->params['action'] == 'admin_add') {
	$formUrl = array('controller' => 'route', 'action' => 'add');
	$this->Html
		->addCrumb('Create', $this->here);
}

if ($this->request->params['action'] == 'admin_edit') {
	$formUrl = array('controller' => 'route', 'action' => 'edit');
	$this->Html
	  ->addCrumb('Edit', $this->here)
	  ->addCrumb($this->request->data['Route']['alias'], $this->here);
}

echo $this->Form->create('Route', array('url' => $formUrl));

?>
<div class="row-fluid">
	<div class="span8">

		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Route'), '#route-main');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">

			<div id="route-main" class="tab-pane">
			<?php
			  echo $this->Form->input('id');
			  $this->Form->inputDefaults(array(
			  	'class' => 'span10',
			  ));
		  	echo $this->Form->input('alias', array('label' => __d('croogo', 'Alias')));
		  	echo $this->Form->input('body', array('label' => __d('croogo', 'Body')));
			?>
			</div>

			<?php echo $this->Croogo->adminTabs(); ?>
		</div>

	</div>
	<div class="span4">
		<?php
			echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
				$this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-primary')) .
				$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'cancel btn btn-danger')) .
				$this->Form->input('status', array(
					'label' => __d('croogo', 'Status'),
					'class' => false,
				));
	
			echo $this->Html->endBox();
	
			echo $this->Croogo->adminBoxes();
		?>
		</div>
</div>
<?php echo $this->Form->end(); ?>