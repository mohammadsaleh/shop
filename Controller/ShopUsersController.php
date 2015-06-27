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
        $this->set('title_for_layout', __d('croogo', 'Register'));
        if (!empty($this->request->data)) {
            $this->User->create();

            $this->request->data['User']['role_id'] = 2; // Registered
            $this->request->data['User']['activation_key'] = md5(uniqid());
            $this->request->data['User']['status'] = 0;
            $this->request->data['User']['name'] = preg_replace('/[\.-_]*/', '', strstr($this->request->data['User']['email'], '@', true));
            $this->request->data['User']['username'] = preg_replace('/[\W]*/', '', strstr($this->request->data['User']['email'], '@', true));
            $this->request->data['User']['website'] = '';
            $this->request->data['User']['password'] = substr(md5(uniqid()), 0, 10);
            $this->request->data['User']['registration_password'] = $this->request->data['User']['password'];

            if ($this->User->save($this->request->data)) {
                Croogo::dispatchEvent('Controller.Users.registrationSuccessful', $this);
                $this->request->data['User']['password'] = null;
                try{
                    $email = new CakeEmail();
                    $email->from($this->_getSenderEmail(), Configure::read('Site.title'));
                    $email->to($this->request->data['User']['email']);
                    $email->subject(__d('croogo', '[%s] Please activate your account', Configure::read('Site.title')));
                    $email->template('Users.register');
                    $email->viewVars(array('user' => $this->request->data));
                    $email->emailFormat('html');
                    $email->theme($this->theme);
                    $success = $email->send();
                } catch (SocketException $e) {
                    $this->log(sprintf('Error sending %s notification : %s', 'user activation', $e->getMessage()));
                }

                $this->Session->setFlash(__d('croogo', 'You have successfully registered an account. An email has been sent with further instructions.'), 'flash', array('class' => 'success'));
                return $this->redirect(array('action' => 'login'));
            } else {
                Croogo::dispatchEvent('Controller.Users.registrationFailure', $this);
                $this->Session->setFlash(__d('croogo', 'The User could not be saved. Please, try again.'), 'flash', array('class' => 'error'));
            }
        }
        $this->render('Users.add');
    }

    public function beforeRender(){
        parent::beforeRender();
        $this->viewPath = 'Users';
    }

    public function login() {
        $this->set('title_for_layout', __d('croogo', 'Log in'));
        if($this->request->is('post')){
            parent::login();
        }
        $this->render('Users.add');
    }

}