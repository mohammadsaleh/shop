<?php
class ShopUsersController extends ShopAppController{

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Components->disable('Security');
    }
    public function edit($username = null){
        $this->loadModel('Users.User');
        if(!empty($this->request->data)){
            $this->User->id = $this->Auth->user('id');
            unset($this->request->data['User']['username']);
            $this->User->save($this->request->data);
        }
        if ($username == null) {
            $username = $this->Auth->user('username');
        }
        $user = $this->User->findByUsername($username);
        if (!isset($user['User']['id'])) {
            $this->Session->setFlash(__d('croogo', 'Invalid User.'), 'flash', array('class' => 'error'));
            return $this->redirect('/');
        }

        $this->set('title_for_layout', $user['User']['name']);
        $this->set(compact('user'));
        $this->viewPath = 'Users';
        $this->render('Users.view');
    }

}