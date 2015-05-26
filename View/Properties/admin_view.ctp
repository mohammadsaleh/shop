<?php

$this->extend('/Common/admin_view');
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Properties'), h($property['Property']['title']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Properties'), array('action' => 'index'));

if (isset($property['Property']['title'])):
	$this->Html->addCrumb($property['Property']['title'], '/' . $this->request->url);
endif;

$this->set('title', __d('croogo', 'Property'));

$this->append('actions');
	echo $this->Croogo->adminAction(__d('croogo', 'Edit Property'), array(
		'action' => 'edit',
		$property['Property']['id'],
	), array(
		'button' => 'default',
	));
	echo $this->Croogo->adminAction(__d('croogo', 'Delete Property'), array(
		'action' => 'delete', $property['Property']['id'],
	), array(
		'method' => 'post',
		'button' => 'danger',
		'escapeTitle' => true,
		'escape' => false,
	),
	__d('croogo', 'Are you sure you want to delete # %s?', $property['Property']['id'])
	);
	echo $this->Croogo->adminAction(__d('croogo', 'List Properties'), array('action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Property'), array('action' => 'add'), array('button' => 'success'));
	echo $this->Croogo->adminAction(__d('croogo', 'List Product Metas'), array('controller' => 'product_metas', 'action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Product Meta'), array('controller' => 'product_metas', 'action' => 'add'));
	echo $this->Croogo->adminAction(__d('croogo', 'List Property Values'), array('controller' => 'property_values', 'action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Property Value'), array('controller' => 'property_values', 'action' => 'add'));
$this->end();

$this->append('main');
?>
<div class="properties view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($property['Property']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($property['Property']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Type'); ?></dt>
		<dd>
			<?php echo h($property['Property']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Title'); ?></dt>
		<dd>
			<?php echo h($property['Property']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Searchable'); ?></dt>
		<dd>
			<?php echo h($property['Property']['searchable']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Hidden'); ?></dt>
		<dd>
			<?php echo h($property['Property']['hidden']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Selectable On Order'); ?></dt>
		<dd>
			<?php echo h($property['Property']['selectable_on_order']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($property['Property']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php $this->end(); ?>