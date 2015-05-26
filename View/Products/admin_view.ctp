<?php

$this->extend('/Common/admin_view');
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Products'), h($product['Product']['title']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Products'), array('action' => 'index'));

if (isset($product['Product']['title'])):
	$this->Html->addCrumb($product['Product']['title'], '/' . $this->request->url);
endif;

$this->set('title', __d('croogo', 'Product'));

$this->append('actions');
	echo $this->Croogo->adminAction(__d('croogo', 'Edit Product'), array(
		'action' => 'edit',
		$product['Product']['id'],
	), array(
		'button' => 'default',
	));
	echo $this->Croogo->adminAction(__d('croogo', 'Delete Product'), array(
		'action' => 'delete', $product['Product']['id'],
	), array(
		'method' => 'post',
		'button' => 'danger',
		'escapeTitle' => true,
		'escape' => false,
	),
	__d('croogo', 'Are you sure you want to delete # %s?', $product['Product']['id'])
	);
	echo $this->Croogo->adminAction(__d('croogo', 'List Products'), array('action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Product'), array('action' => 'add'), array('button' => 'success'));
	echo $this->Croogo->adminAction(__d('croogo', 'List Categories'), array('controller' => 'categories', 'action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Category'), array('controller' => 'categories', 'action' => 'add'));
	echo $this->Croogo->adminAction(__d('croogo', 'List Product Metas'), array('controller' => 'product_metas', 'action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Product Meta'), array('controller' => 'product_metas', 'action' => 'add'));
$this->end();

$this->append('main');
?>
<div class="products view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($product['Product']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Title'); ?></dt>
		<dd>
			<?php echo h($product['Product']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($product['Category']['title'], array('controller' => 'categories', 'action' => 'view', $product['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Description'); ?></dt>
		<dd>
			<?php echo h($product['Product']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Price'); ?></dt>
		<dd>
			<?php echo h($product['Product']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Off'); ?></dt>
		<dd>
			<?php echo h($product['Product']['off']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Count'); ?></dt>
		<dd>
			<?php echo h($product['Product']['count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($product['Product']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php $this->end(); ?>