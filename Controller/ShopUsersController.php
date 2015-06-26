<?php
App::uses('UsersController', 'Users.Controller');
class ShopUsersController extends UsersController{

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Components->disable('Security');
    }

    public function edit($username = null){
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
        $this->render('Users.edit');
    }
    
    public function add(){
        if(!empty($this->request->data)){
            $this->request->data['User']['name'] = strstr($this->request->data['User']['email'], '@', true);;
            $this->request->data['User']['username'] = strstr($this->request->data['User']['email'], '@', true);
            $this->request->data['User']['website'] = '';
            $this->request->data['User']['password'] = substr(md5(uniqid()), 0, 10);
        }
        parent::add();
        $this->render('Users.add');
    }

    public function login(){
        parent::login();
        $this->render('Users.login');
    }

    public function beforeRender(){
        parent::beforeRender();
        $this->viewPath = 'Users';
    }
    
}