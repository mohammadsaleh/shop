<?php
$this->viewVars['title_for_layout'] = __d('shop', 'Categories');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('shop', 'Categories'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Category']['title'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = __d('shop', 'Categories') . ': ' . $this->request->data['Category']['title'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

$this->append('form-start', $this->Form->create('Category'));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('shop', 'Category'), '#category');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

	echo $this->Html->tabStart('category');

		echo $this->Form->input('id');
        echo $this->Form->input('parent_id', array(
            'label' =>  __d('shop', 'Parent'),
            'options' => $parentCategories,
            'empty' => true,
        ));
		echo $this->Form->input('title', array(
			'label' =>  __d('shop', 'Title'),
            'class' => 'input-block-level'
		));
        echo $this->Form->input('slug', array(
            'label' =>  __d('shop', 'Slug'),
            'class' => array('slug', 'input-block-level')
        ));
		echo $this->Form->input('description', array(
			'label' =>  __d('shop', 'Description'),
		));

	echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();

$this->end();

$this->append('panels');
	echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
		$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
		$this->Form->button(__d('croogo', 'Save'), array('button' => 'primary')) .
		$this->Form->button(__d('croogo', 'Save & New'), array('button' => 'success', 'name' => 'save_and_new')) .
		$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('button' => 'danger'));
	echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
echo $this->element("Shop.jquery_slug_maker", array('origin' => 'CategoryTitle', 'target' => 'slug'));