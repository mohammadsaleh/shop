<?php

$this->extend('/Common/admin_view');
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Categories'), h($category['Category']['title']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Categories'), array('action' => 'index'));

if (isset($category['Category']['title'])):
	$this->Html->addCrumb($category['Category']['title'], '/' . $this->request->url);
endif;

$this->set('title', __d('croogo', 'Category'));

$this->append('actions');
	echo $this->Croogo->adminAction(__d('croogo', 'Edit Category'), array(
		'action' => 'edit',
		$category['Category']['id'],
	), array(
		'button' => 'default',
	));
	echo $this->Croogo->adminAction(__d('croogo', 'Delete Category'), array(
		'action' => 'delete', $category['Category']['id'],
	), array(
		'method' => 'post',
		'button' => 'danger',
		'escapeTitle' => true,
		'escape' => false,
	),
	__d('croogo', 'Are you sure you want to delete # %s?', $category['Category']['id'])
	);
	echo $this->Croogo->adminAction(__d('croogo', 'List Categories'), array('action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Category'), array('action' => 'add'), array('button' => 'success'));
	echo $this->Croogo->adminAction(__d('croogo', 'List Categories'), array('controller' => 'categories', 'action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Parent Category'), array('controller' => 'categories', 'action' => 'add'));
	echo $this->Croogo->adminAction(__d('croogo', 'List Products'), array('controller' => 'products', 'action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Product'), array('controller' => 'products', 'action' => 'add'));
$this->end();

$this->append('main');
?>
<div class="categories view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Title'); ?></dt>
		<dd>
			<?php echo h($category['Category']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Description'); ?></dt>
		<dd>
			<?php echo h($category['Category']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Parent Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($category['ParentCategory']['title'], array('controller' => 'categories', 'action' => 'view', $category['ParentCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($category['Category']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php $this->end(); ?>