<?php
$this->viewVars['title_for_layout'] = __d('shop', 'Products');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('shop', 'Products'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Product']['title'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = __d('shop', 'Products') . ': ' . $this->request->data['Product']['title'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

$this->append('form-start', $this->Form->create('Product'));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('shop', 'Product'), '#product');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

	echo $this->Html->tabStart('product');

		echo $this->Form->input('id');

        echo $this->Form->input('category_id', array(
            'label' =>  __d('shop', 'Category'),
            'div' => array(
                'style' => 'width:50%'
            )
        ));

		echo $this->Form->input('title', array(
			'label' =>  __d('shop', 'Title'),
            'div' => array(
                'style' => 'width:50%'
            )
		));
        echo $this->Form->input('slug', array(
            'label' =>  __d('shop', 'Slug'),
            'div' => array(
                'style' => 'width:50%'
            ),
            'class' => 'slug input-block-level'
        ));

		echo $this->Form->input('description', array(
			'label' =>  __d('shop', 'Description'),
		));
		echo $this->Form->input('price', array(
			'label' =>  __d('shop', 'Price (Rials)'),
            'div' => array(
                'style' => 'width:30%;display:inline-block',
            )
		));
		echo $this->Form->input('off', array(
			'label' =>  __d('shop', 'Off (%)'),
            'div' => array(
                'style' => 'width:30%;display:inline-block',
            )
		));
		echo $this->Form->input('count', array(
			'label' =>  __d('shop', 'Count'),
            'div' => array(
                'style' => 'width:30%;display:inline-block',
            )
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
echo $this->element("Shop.jquery_slug_maker", array('origin' => 'ProductTitle', 'target' => 'slug'));