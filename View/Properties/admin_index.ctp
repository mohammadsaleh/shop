<?php
$this->viewVars['title_for_layout'] = __d('shop', 'Properties');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('shop', 'Properties'), array('action' => 'index'));

$this->set('tableClass', 'table table-striped');

$this->append('table-heading');
	$tableHeaders = $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('name'),
		$this->Paginator->sort('type'),
		$this->Paginator->sort('title'),
		$this->Paginator->sort('searchable'),
		$this->Paginator->sort('hidden'),
		$this->Paginator->sort('selectable_on_order'),
		$this->Paginator->sort('Category.title'),
		$this->Paginator->sort('created'),
		array(__d('croogo', 'Actions') => array('class' => 'actions')),
	));
	echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
	$rows = array();
	foreach ($properties as $property):
		$row = array();
		$row[] = h($property['Property']['id']);
		$row[] = h($property['Property']['name']);
		$row[] = h($property['Property']['type']);
		$row[] = h($property['Property']['title']);
		$row[] = h($property['Property']['searchable']);
		$row[] = h($property['Property']['hidden']);
		$row[] = h($property['Property']['selectable_on_order']);
		$row[] = h($property['Category']['title']);
		$row[] = h($property['Property']['created']);
		$actions = array($this->Croogo->adminRowActions($property['Property']['id']));
		$actions[] = $this->Croogo->adminRowAction('', array(
			'action' => 'view', $property['Property']['id']
	), array(
			'icon' => 'eye-open',
		));
		$actions[] = $this->Croogo->adminRowAction('', array(
			'action' => 'edit',
			$property['Property']['id'],
		), array(
			'icon' => 'pencil',
		));
		$actions[] = $this->Croogo->adminRowAction('', array(
			'action' => 'delete',
			$property['Property']['id'],
		), array(
			'icon' => 'trash',
			'escape' => true,
		),
		__d('croogo', 'Are you sure you want to delete # %s?', $property['Property']['id'])
		);
		$row[] = $this->Html->div('item-actions', implode(' ', $actions));
		$rows[] = $this->Html->tableCells($row);
	endforeach;
	echo $this->Html->tag('tbody', implode('', $rows));
$this->end();
