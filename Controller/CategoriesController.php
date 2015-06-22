<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class CategoriesController extends ShopAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Components->disable('Security');
//        $this->Security->unlockedActions[] = 'index';
//        $this->Security->validatePost = false;
//        $this->Security->csrfCheck = false;
    }

    public function index($categoryId){
        $this->autoRender = false;
        // get all given categoryId children
        $categoriesTree = $this->__getSubCategories($categoryId);
        $categoriesId = $this->__getCategoriesId($categoriesTree);
        if(empty($categoriesTree['children'])){
            $conditions = array('Product.category_id' => $categoriesId);
            if(!empty($this->request->named)){
                if(isset($this->request->named['minPrice']) && is_numeric($this->request->named['minPrice'])){
                    $minPrice = $this->request->named['minPrice'];
                    $conditions['(Product.price * (1 - (Product.off/100)) ) >= '] = $minPrice;
                }
                if(isset($this->request->named['maxPrice']) && is_numeric($this->request->named['maxPrice'])){
                    $maxPrice = $this->request->named['maxPrice'];
                    $conditions['(Product.price * (1 - (Product.off/100)) ) <= '] = $maxPrice;
                }
                if( isset($this->request->named['sort']) && !($this->request->named['sort']) ) {
                    unset($this->request->named['sort']);
                    unset($this->request->named['direction']);
                }elseif( isset($this->request->named['direction']) && !($this->request->named['direction']) ) {
                    $this->request->named['direction'] = 'asc';
                }
                $this->request->named = array_merge(array(
                    'sort' => 'Product.id',
                    'direction' => 'asc',
                ), $this->request->named);
                $this->request->params['named'] = array_merge($this->request->params['named'], array(
                    'sort' => $this->request->named['sort'],
                    'direction' => $this->request->named['direction'],
                ));
            }
            $filter_conditions = ['or' => array(array())];
            $filters = isset($this->request->named['p'])?$this->request->named['p']:array();
            if(!is_array($filters)){
                $filters = array($filters);
            }
            foreach($filters as $property){
                $property = explode(':', $property);
                $filter_conditions['or'][] = [
                    'and' => [
                        'ProductMeta.property_id' => array_shift($property),
                        'ProductMeta.property_value' => array_shift($property),
                    ],
                ];
            }
            $conditions = array_merge($conditions, $filter_conditions);
            // paginate mahsoolate in category
            // get searchables properties for using in filter
            $this->paginate = array(
                'limit' => 2,
                'conditions' => $conditions,
                'fields' => 'DISTINCT *',
            );
            $this->paginate = array_merge($this->paginate, array(
                'joins' => array(
                    array(
                        'table' => 'shop_product_metas',
                        'alias' => 'ProductMeta',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Product.id = ProductMeta.product_id',
                        )
                    )
                ),
            ));
            $this->Paginator->settings = $this->paginate;
            $products = $this->Paginator->paginate($this->Category->Product);
            $this->set(compact('products'));
            if($this->request->is('ajax')){
                return $this->render('Shop.Categories/ajax/index');
            }
            else{
                $categoryProperties = $this->Category->getCategoryProperties($categoryId, $selectableProperties = false, $searchableProperties  = true);
                $this->set(compact('categoryProperties', 'minPrice', 'maxPrice'));
                return $this->render('Shop.view');
            }
        }else{
            // get jadidtarin kala ha dar zir majmooeye in category
            // get porforooshtarin kala ha dar zir majmooeye in category
            $latestProducts = $this->__getLatestProducts($categoriesId, 10);
            $bestsellingProducts = $this->__getBestsellingProducts($categoriesId, 10);
            $this->set(compact('latestProducts', 'bestsellingProducts'));
        }
    }

    private function __getBestsellingProducts($categoriesId = array(), $limit = 10){
        $this->Category->Product->virtualFields = array('count_sells' => 'COUNT(FactureItem.id)');
        $bestsellingProducts = $this->Category->Product->find('all', array(
            'fields' => array('Product.*', 'Attachment.path', 'count_sells'),
            'conditions' => array(
                'Product.category_id' => $categoriesId
            ),
            'joins' => array(
                array(
                    'table' => 'facture_items',
                    'alias' => 'FactureItem',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'FactureItem.model = "Product"',
                        'FactureItem.foreign_key = Product.id'
                    )
                ),
                array(
                    'table' => 'shop_products_attachments',
                    'alias' => 'ProductAttachment',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'ProductAttachment.product_id = Product.id',
                        'ProductAttachment.is_index = 1',
                    )
                ),
                array(
                    'table' => 'nodes',
                    'alias' => 'Attachment',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Attachment.id = ProductAttachment.attachment_id',
                    )
                )
            ),
            'group' => array('Product.id HAVING COUNT(FactureItem.id) > 0'),
            'order' => array('count_sells DESC'),
            'limit' => $limit
        ));
//        debug($bestsellingProducts);die;
        return $bestsellingProducts;
    }

    private function __getLatestProducts($categoriesId = array(), $limit = 10){
        $latestCategoryProducts = $this->Category->Product->find('all', array(
            'conditions' => array(
                'Product.category_id' => $categoriesId
            ),
            'order' => array('Product.id' => 'DESC'),
            'limit' => $limit
        ));
        return $latestCategoryProducts;
    }

    private function __getCategoriesId($categoriesTree, $depth = 0, &$ids = array()){
        if(!empty($categoriesTree)){
            array_push($ids, $categoriesTree['Category']['id']);
        }
        if(!empty($categoriesTree['children'])){
            foreach($categoriesTree['children'] as $child){
                $this->__getCategoriesId($child, $depth + 1, $ids);
            }
        }
        return $ids;
    }

    private function __getSubCategories($categoryId = null){
        if($categoryId){
            $categoriesTree = $this->Category->getAllChildren($categoryId);
            $categoriesTree = array_shift($categoriesTree);
            $this->set(compact('categoriesTree'));
            return $categoriesTree;
        }
    }
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
        $treeCategories = $this->Category->generateTreeList(null,null,null,'__');
		$this->set(compact('treeCategories'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid %s', __d('shop', 'category')));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__d('croogo', '%s has been saved', __d('shop', 'category')), 'default', array('class' => 'success'));
				$redirectTo = array('action' => 'index');
				if (isset($this->request->data['apply'])) {
					$redirectTo = array('action' => 'edit', $this->Category->id);
				}
				if (isset($this->request->data['save_and_new'])) {
					$redirectTo = array('action' => 'add');
				}
				return $this->redirect($redirectTo);
			} else {
				$this->Session->setFlash(__d('croogo', '%s could not be saved. Please, try again.', __d('shop', 'category')), 'default', array('class' => 'error'));
			}
		}
		$parentCategories = $this->Category->generateTreeList();
		$this->set(compact('parentCategories'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid %s', __d('shop', 'category')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', '%s has been saved', __d('shop', 'category')), 'default', array('class' => 'success'));
				$redirectTo = array('action' => 'index');
				if (isset($this->request->data['apply'])) {
					$redirectTo = array('action' => 'edit', $id);
				}
				if (isset($this->request->data['save_and_new'])) {
					$redirectTo = array('action' => 'add');
				}
				return $this->redirect($redirectTo);
			} else {
				$this->Session->setFlash(__d('croogo', '%s could not be saved. Please, try again.', __d('shop', 'category')), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
		}
		$parentCategories = $this->Category->generateTreeList();
		$this->set(compact('parentCategories'));
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
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid %s', __d('shop', 'category')));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Category->delete()) {
			$this->Session->setFlash(__d('croogo', '%s deleted', __d('shop', 'Category')), 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', '%s was not deleted', __d('shop', 'Category')), 'default', array('class' => 'error'));
		return $this->redirect(array('action' => 'index'));
	}
}
