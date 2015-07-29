<?php
$this->viewVars['title_for_layout'] = __d('shop', 'Properties');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('shop', 'Properties'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Property']['title'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = __d('shop', 'Properties') . ': ' . $this->request->data['Property']['title'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

$this->append('form-start', $this->Form->create('Property'));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('shop', 'Property'), '#property');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

	echo $this->Html->tabStart('property');

		echo $this->Form->input('id');
        echo $this->Form->input('category_id', array(
            'label' =>  __d('shop', 'Product Category'),
            'options' => $categories,
            'default' => (isset($categoryId)) ? $categoryId : false
        ));
		echo $this->Form->input('name', array(
			'label' =>  __d('shop', 'Name'),
		));
		echo $this->Form->input('title', array(
			'label' =>  __d('shop', 'Title'),
		));
        $searchable = $this->Form->checkbox('searchable') . $this->Form->label("searchable", __d('shop', 'Is searchable?'));
        echo $this->Html->tag("div", $searchable, array(
            'class' => 'input checkbox'
        ));
        $hidden = $this->Form->checkbox('hidden') . $this->Form->label("hidden", __d('shop', 'Is hidden?'));
        echo $this->Html->tag("div", $hidden, array(
            'class' => 'input checkbox'
        ));
        $selectableOnOrder = $this->Form->checkbox('selectable_on_order') . $this->Form->label("selectable_on_order", __d('shop', 'Is selectable on order?'));
        echo $this->Html->tag("div", $selectableOnOrder, array(
            'class' => 'input checkbox'
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
