<?php
App::uses('AppController', 'Controller');
//public unable to add !! 
 class UsersController extends AppController{
	public $helpers=array('Html','Form');
	public $components=array('Flash');
	public function beforeFilter(){
 	parent::beforeFilter();
 	$this->Auth->allow('add','logout');              //why ????
	}
	 public function index() {
        $this->User->recursive = 0;
        /* Serach for paginate() functionality*/
        $this->set('users', $this->paginate());
         
      //  $this->set('users',$this->User->find('all'));    

    }
    public function add(){
    	if($this->request->is('post')){
    		$this->User->create();
    		if($this->User->save($this->request->data)){
    			$this->Flash->success("User Hs been addes successfully");
    			return $this->redirect('index');
    		}
    		$this->Flash->error("Can not add ");

    	}
    }
    public function view($id=null){
    	$this->User->id=$id;
    	if(!$this->User->exists()){
    		throw new NotFoundException("Error Invalid user id");
    	}
    	$user=$this->User->findById($id);
    	$this->set('user',$user);

    }
    public function edit($id=null){
    	$this->User->id=$id;
    	if(!$this->User->exists()){
    		throw new NotFoundException("Error Invalid user id");
    	}
    	if($this->request->is('post')||$this->request->is('put')){
    		if($this->User->save($this->request->data)){
    			$this->Flash->success("User with id: ".$id." has been edited successfully");
    			$this->redirect('index');

    		}else {

    	$this->Flash->error("Can't delete user with id: ".$id);

    		}

    	}else {
    		$this->request->data=$this->User->findById($id);
    		unset($this->request->data['User']['password']);
    	}
    }
    public function delete($id=null){
    	        $this->request->allowMethod('post');
    	$this->User->id=$id; 
    	if(!$this->User->exists()){
    		throw new NotFoundException("User does not exists ");
    	}
    	if($this->User->delete()){
    		$this->Flash->success("deleted successfully"); 
    		return $this->redirect('index');
    	}else {

    		 $this->Flash->success("can not delete this user"); 
    		  return $this->redirect(array('action' => 'index'));
    	}
    }
    public function login() {
    if ($this->request->is('post')) {
        if ($this->Auth->login()) {
            $this->Flash->success('logged in successfully');
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->Flash->error(__('Invalid username or password, try again'));
    }
}public function logout() {
    return $this->redirect($this->Auth->logout());
}

}
