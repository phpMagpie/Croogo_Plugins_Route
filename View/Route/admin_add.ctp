<?php

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Routes'), array('controller' => 'route', 'action' => 'index'));

if ($this->request->params['action'] == 'admin_add') {
	$formUrl = array('action' => 'add');
	$this->Html
		->addCrumb('Create', $this->here);
}

if ($this->request->params['action'] == 'admin_edit') {
	$formUrl = array('action' => 'edit');
	$this->Html
	  ->addCrumb('Edit', $this->here)
	  ->addCrumb($this->request->data['Route']['alias'], $this->here);
}

echo $this->Form->create('Route', array('url' => $formUrl));

?>
<div class="row-fluid">
	<div class="span12">

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
		  	echo $this->Form->input('alias', array('label' => __('Alias', true)));
		  	echo $this->Form->input('body', array('label' => __('Body', true), 'class' => 'content'));
		  	echo $this->Form->input('status', array('label' => __('Status', true)));
			?>
			</div>

			<?php echo $this->Croogo->adminTabs(); ?>
		</div>

	</div>
</div>
<?php echo $this->Form->end(); ?>