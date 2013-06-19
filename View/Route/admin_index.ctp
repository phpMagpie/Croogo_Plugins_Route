<?php
$this->extend('/Common/admin_index');
$this->Html->script(array('Nodes.nodes'), false);

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Routes'), $this->here);

echo $this->Html->css('/route/css/route', 'stylesheet', array("media"=>"all" ), false);

?>
<?php $this->start('actions'); ?>
<?php
	echo $this->Croogo->adminAction(
		__d('croogo', 'Create route'),
		array('action' => 'add'),
		array('button' => 'success')
	);
	echo $this->Croogo->adminAction(
		__d('croogo', 'Enable all'),
		array('action' => 'enable_all'),
		array('button' => 'success')
	);
	echo $this->Croogo->adminAction(
		__d('croogo', 'Disable all'),
		array('action' => 'disable_all'),
		array('button' => 'success')
	);
	echo $this->Croogo->adminAction(
		__d('croogo', 'Delete all routes'),
		array('action' => 'delete_all'),
		array('button' => 'success')
	);
	echo $this->Croogo->adminAction(
		__d('croogo', 'Regenerate'),
		array('action' => 'regenerate_custom_routes_file'),
		array('button' => 'success')
	);
?>
<?php $this->end(); ?>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped">
		<?php
			$tableHeaders =  $this->Html->tableHeaders(array(
				$this->Paginator->sort('id'),
				$this->Paginator->sort('alias'),
				$this->Paginator->sort('body'),
				$this->Paginator->sort('status'),
				''
			));
		?>
			<thead>
				<?php echo $tableHeaders; ?>
			</thead>
			
			<tbody>
			<?php foreach ($routes as $route): ?>
				<tr>
					<td><?php echo $route['Route']['id']; ?></td>
					<td><?php echo $route['Route']['alias']; ?></td>
					<td><?php echo substr(trim(strip_tags($route['Route']['body'])), 0, 150); ?></td>
					<td><?php
						echo $this->element('admin/toggle', array(
							'id' => $route['Route']['id'],
							'status' => $route['Route']['status'],
						));
					?></td>
					<td>
						<div class="item-actions">
						<?php
							echo $this->Croogo->adminRowActions($route['Route']['id']);
							echo ' ' . $this->Croogo->adminRowAction('',
								array('action' => 'edit', $route['Route']['id']),
								array('icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit this item'))
							);
							echo ' ' . $this->Croogo->adminRowAction('',
								'#Node' . $route['Route']['id'] . 'Id',
								array('icon' => 'trash', 'tooltip' => __d('croogo', 'Remove this item'), 'rowAction' => 'delete'),
								__d('croogo', 'Are you sure?')
							);
						?>
						</div>
					</td>
				</tr>
			<?php endforeach ?>
		  </tbody>
    </table>
</div>