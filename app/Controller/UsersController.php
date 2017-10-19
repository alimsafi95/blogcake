<?php
App::uses('AppController', 'Controller');
//public unable to add !! 
 class UsersController extends AppController{
	public $helpers=array('Html','Form');
	public $components=array('Flash');
	public function beforeFilter(){
 	parent::beforeFilter();
 	$this->Auth->allow('login','logout');              //why ????
	   //     $this->set('auth',$this->Auth);

    }
	 public function index() {
        $this->User->recursive = 0;
        /* Serach for paginate() functionality*/
        $this->set('users', $this->paginate());
         
      //  $this->set('users',$this->User->find('all'));    

    }
    public function add(){
       // if($this->Auth->user('role')!='admin'){
       //     $this->Flash->error('You are not authorized to add users');
       //  return   $this->redirect('index');
       // }
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
        $userpost=$this->User->query("SELECT users.*, count( posts.user_id ) 
FROM posts LEFT JOIN users ON users.id=posts.user_id 
where users.id=$id
GROUP BY posts.user_id");
        //pr($userpost);die();

    	$this->set('user',$user);
        $this->set('userpost',$userpost);
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
        if($this->Auth->user('id')==$id){
            $this->Flash->error('Admin can not delete his user '); 
            return $this->redirect('index');
        }else {
    	if($this->User->delete()){
    		$this->Flash->success("deleted successfully"); 
    		return $this->redirect('index');
    	}else {

    		 $this->Flash->success("can not delete this user"); 
    		  return $this->redirect(array('action' => 'index'));
    	}}
    }
    public function login() {

        if($this->Auth->user('id')){
            $this->Flash->error('User Already Logged in'); 
            $this->redirect('index');
       }
    if ($this->request->is('post')) {
        if ($this->Auth->login()) {
            $this->Flash->success('logged in successfully');
           // $this->set('auth',$this->Auth);
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->Flash->error(__('Invalid username or password, try again'));
    }
}public function logout() {
       return $this->redirect($this->Auth->logout());
}
public function isAuthorized($user){
if($this->action=='logout'&&isset($user['id'])){
    return true;
}else{
   // $this->Flash->error('you are not signed in');
}

    return parent::isAuthorized($user);
}



}


