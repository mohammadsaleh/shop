<?php
//aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 */
class ProductsController extends ShopAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Components->disable('Security');
//        $this->Security->unlockedActions[] = 'admin_get_category_properties';
//        $this->Security->validatePost = false;
//        $this->Security->csrfCheck = false;
    }
    public function index(){
        $products = $this->Product->find('all');
        debug($products);die;
    }
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Product->recursive = 0;
		$this->set('products', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid %s', __d('shop', 'product')));
		}
		$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
		$this->set('product', $this->Product->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Product->create();
			if ($this->Product->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__d('croogo', '%s has been saved', __d('shop', 'product')), 'default', array('class' => 'success'));
				$redirectTo = array('action' => 'index');
				if (isset($this->request->data['apply'])) {
					$redirectTo = array('action' => 'edit', $this->Product->id);
				}
				if (isset($this->request->data['save_and_new'])) {
					$redirectTo = array('action' => 'add');
				}
				return $this->redirect($redirectTo);
			} else {
				$this->Session->setFlash(__d('croogo', '%s could not be saved. Please, try again.', __d('shop', 'product')), 'default', array('class' => 'error'));
			}
		}
		$categories = $this->Product->Category->generateTreeList();
        $firstKey = @array_shift(array_keys($categories));
        $categoryProperties = $this->Product->Category->getCategoryProperties($firstKey);
        $this->set(compact('categories', 'categoryProperties'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid %s', __d('shop', 'product')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
//            debug($this->request->data);die;
			if ($this->Product->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__d('croogo', '%s has been saved', __d('shop', 'product')), 'default', array('class' => 'success'));
				$redirectTo = array('action' => 'index');
				if (isset($this->request->data['apply'])) {
					$redirectTo = array('action' => 'edit', $id);
				}
				if (isset($this->request->data['save_and_new'])) {
                    $redirectTo = array('action' => 'add');
				}
				return $this->redirect($redirectTo);
			} else {
				$this->Session->setFlash(__d('croogo', '%s could not be saved. Please, try again.', __d('shop', 'product')), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
			$this->request->data = $this->Product->find('first', $options);
            $categories = $this->Product->Category->generateTreeList();
            $categoryProperties = $this->Product->Category->getCategoryProperties($this->request->data['Category']['id']);
            $this->set(compact('categories', 'categoryProperties'));
        }
	}

    /**
     * Get all properties of given category_id
     */
    public function admin_get_category_properties(){
        if($this->request->is('ajax') && !empty($this->request->data['category_id'])){
            $categoryProperties = $this->Product->Category->getCategoryProperties($this->request->data['category_id']);
            $this->set(compact('categoryProperties'));
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
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid %s', __d('shop', 'product')));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Product->delete()) {
			$this->Session->setFlash(__d('croogo', '%s deleted', __d('shop', 'Product')), 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', '%s was not deleted', __d('shop', 'Product')), 'default', array('class' => 'error'));
		return $this->redirect(array('action' => 'index'));
	}
}
