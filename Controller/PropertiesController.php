<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Properties Controller
 *
 * @property Property $Property
 * @property PaginatorComponent $Paginator
 */
class PropertiesController extends ShopAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

    public function beforeFilter(){
        parent::beforeFilter();
        /*$this->Security->csrfCheck = false;*/
        $this->Components->disable('Security');
    }

    public function admin_toggle($id = null, $status = null, $field = null) {
        if (empty($id) || $status === null) {
            throw new CakeException(__d('croogo', 'Invalid content'));
        }
        $this->Property->id = $id;
        $status = (int)!$status;
        $this->layout = 'ajax';
        if ($this->Property->saveField($field, $status)) {
            $this->set(compact('id', 'status', 'field'));
            $this->render('admin_toggle');
        } else {
            throw new CakeException(__d('croogo', 'Failed toggling field %s to %s', $field, $status));
        }
    }
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Property->recursive = 0;
		$this->set('properties', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Property->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid %s', __d('shop', 'property')));
		}
		$options = array('conditions' => array('Property.' . $this->Property->primaryKey => $id));
		$this->set('property', $this->Property->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($categoryId = null) {
        if ($this->request->is('post')) {
            $this->Property->create();
            if ($this->Property->saveAssociated($this->request->data)) {
                $this->Session->setFlash(__d('croogo', '%s has been saved', __d('shop', 'property')), 'default', array('class' => 'success'));
				$redirectTo = array('action' => 'index');
				if (isset($this->request->data['apply'])) {
					$redirectTo = array('action' => 'edit', $this->Property->id);
				}
				if (isset($this->request->data['save_and_new'])) {
                    $redirectTo = array('action' => 'add', $this->request->data['Property']['category_id']);
				}
				return $this->redirect($redirectTo);
			} else {
				$this->Session->setFlash(__d('croogo', '%s could not be saved. Please, try again.', __d('shop', 'property')), 'default', array('class' => 'error'));
			}
		}else{
            $categories = $this->Property->Category->generateTreeList();
            $this->set(compact('categories', 'categoryId'));
        }
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Property->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid %s', __d('shop', 'property')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Property->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__d('croogo', '%s has been saved', __d('shop', 'property')), 'default', array('class' => 'success'));
				$redirectTo = array('action' => 'index');
				if (isset($this->request->data['apply'])) {
					$redirectTo = array('action' => 'edit', $id);
				}
				if (isset($this->request->data['save_and_new'])) {
                    $redirectTo = array('action' => 'add', $this->request->data['Property']['category_id']);
				}
				return $this->redirect($redirectTo);
			} else {
				$this->Session->setFlash(__d('croogo', '%s could not be saved. Please, try again.', __d('shop', 'property')), 'default', array('class' => 'error'));
			}
		} else {
			$options = array(
                'conditions' => array('Property.' . $this->Property->primaryKey => $id)
            );
			$this->request->data = $this->Property->find('first', $options);
            $categories = $this->Property->Category->generateTreeList();
            $this->set(compact('categories'));
        }
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Property->id = $id;
		if (!$this->Property->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid %s', __d('shop', 'property')));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Property->delete()) {
			$this->Session->setFlash(__d('croogo', '%s deleted', __d('shop', 'Property')), 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', '%s was not deleted', __d('shop', 'Property')), 'default', array('class' => 'error'));
		return $this->redirect(array('action' => 'index'));
	}
}
