<?php
$this->viewVars['title_for_layout'] = __d('shop', 'Properties');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('shop', 'Properties'), array('action' => 'index'));

$this->set('tableClass', 'table table-striped');

$this->append('table-heading');
	$tableHeaders = $this->Html->tableHeaders(array(
		$this->Paginator->sort('id', __d('shop', 'id')),
		$this->Paginator->sort('name', __d('shop', 'name')),
		$this->Paginator->sort('type', __d('shop', 'type')),
		$this->Paginator->sort('title', __d('shop', 'title')),
		$this->Paginator->sort('searchable', __d('shop', 'searchable')),
		$this->Paginator->sort('hidden', __d('shop', 'hidden')),
		$this->Paginator->sort('selectable_on_order', __d('shop', 'selectable_on_order')),
		$this->Paginator->sort('Category.title', __d('shop', 'Category title')),
		$this->Paginator->sort('created', __d('shop', 'created')),
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
        $row[] = $this->element('Shop.admin/toggle', array(
            'id' => $property['Property']['id'],
            'status' => (int)$property['Property']['searchable'],
            'field' => 'searchable'
        ));
		$row[] = $this->element('Shop.admin/toggle', array(
            'id' => $property['Property']['id'],
            'status' => (int)$property['Property']['hidden'],
            'field' => 'hidden'
        ));
        $row[] = $this->element('Shop.admin/toggle', array(
            'id' => $property['Property']['id'],
            'status' => (int)$property['Property']['selectable_on_order'],
            'field' => 'selectable_on_order'
        ));
		$row[] = h($property['Category']['title']);
		$row[] = jdate('Y-m-d H:i:s', h($property['Property']['created']), null, Configure::read('Site.timezone'), 'en');
		$actions = array($this->Croogo->adminRowActions($property['Property']['id']));
//		$actions[] = $this->Croogo->adminRowAction('', array(
//			'action' => 'view', $property['Property']['id']
//	), array(
//			'icon' => 'eye-open',
//		));
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
