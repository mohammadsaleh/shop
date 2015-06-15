<?php
App::uses('ShopAppController', 'Shop.Controller');
App::uses('classFacture', 'Payment.Lib');
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
        $this->set('products', $products);
    }
    public function view($id = null){
        if(isset($id)){
            $product = $this->Product->find('first', array(
                'conditions' => array('Product.id' => $id),
            ));
            $categoryPath = $this->Product->Category->getPath($product['Category']['id'], array(
                'id',
                'title'
            ), -1);
            $selectableProperties = $this->Product->Category->getCategoryProperties($product['Category']['id'], true);
            $product['SelectableProperties'] = $selectableProperties;
            $product['CategoryPath'] = Set::extract('{n}.Category', $categoryPath);
            $this->set('product', $product);
//            debug($product);die;
        }else{
            $this->redirect('/');
        }
    }
    /**
     * @param null $productId
     */
    public function add_to_cart($productId = null){
//        $this->Session->delete('pay');
//        $this->Session->write('pay.direct', 1);
//        $this->Session->write('pay.paymentPlugin', 'zarin_pal');
//        debug($this->Session->read('pay'));
//        die;
        $this->autoRender = false;
        $response = array('status' => 'error');
        if($this->request->is('ajax') && $productId){
            $productInfo = $this->Product->find('first', array(
                'conditions' => array('Product.id' => $productId),
            ));
            if(!empty($productInfo)){
                $this->__addToCard($productInfo);
                $response = array('status' => 'success');
            }
        }
        echo json_encode($response);
    }
    /**
     * @param null $productId
     */
    public function remove_from_cart($productId, $forceDelete = false){
        $productId = (int)$productId;
        $this->autoRender = false;
        $response = array('status' => 'error');
        $price = CakeSession::read('pay.facture.FactureItem.' . $productId . '.price');
        if(($this->request->is('ajax') && $productId)){
            if( ($removeStatus = classFacture::removeFactureItemsFromSession($productId, $forceDelete) ) !== false){
                $response = array(
                    'status' => 'success',
                    'product' => [
                        'price' => $price,
                        'itemTotalPrice' => $removeStatus
                    ],
                );
            }
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    /**
     * @param $item
     */
    private function __addToCard($item){
        //if there is not any facture create new
        //add to facture items
        //if item exist increase it's number
        $price = $item['Product']['price'];
        $off = $item['Product']['off'] ? $item['Product']['off'] : 0;
        $price = $price - (($price * $off) / 100);
        $this->request->data = array_merge(array(
            'description' => '',
            'metas' => array()
        ), $this->request->data);
        $factureItem = array(
            'number' => 1,
            'price' => $price,
            'base_price' => $item['Product']['price'],
            'off' => $item['Product']['off'],
            'type' => -1,
            'model' => 'Product',
            'image' => $item['Attachment']['path'],
            'title' => $item['Product']['title'],
            'foreign_key' => $item['Product']['id'],
            'description' => $this->request->data['description'],
        );
        //Process FactureItemMeta for this item.
        if(isset($this->request->data) && !empty($this->request->data)){
            $factureItem['FactureItemMeta'] = array();
            foreach($this->request->data['metas'] as $propertyId => $propertyValue){
                array_push($factureItem['FactureItemMeta'], array(
                    'FactureItemMeta' => array(
                        'property_id' => $propertyId,
                        'property_value' => $propertyValue
                    )
                ));
            }
        }
        if(!$this->Session->check('pay.facture')){
            $facture = array(
                'status' => 0,
                'FactureItem' => array()
            );
            $this->Session->write('pay.facture', $facture);
        }
        classFacture::addFactureItemsToSession($factureItem, $item['Product']['id']);
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

    public function admin_toggle_image_index($productId = null, $attachmentId = null){
        $this->autoRender = false;
        $response = array('status' => 'success');
        if($this->request->is('ajax')){
            if($productId && $attachmentId){
                $conditions = array('product_id' => $productId);
                $this->Product->update_attachment(array('is_index' => 0), $conditions);
                $conditions['attachment_id'] = $attachmentId;
                $this->Product->insert_attachmet($productId, $attachmentId);
                $this->Product->update_attachment(array('is_index' => 1), $conditions);
                echo json_encode($response);
                return;
            }
        }
        $response['status'] = 'error';
        echo json_encode($response);
        return;
    }
}
