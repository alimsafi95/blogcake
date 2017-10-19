<?php 
class PostsController extends AppController {
	public $helpers=array('Form','Html');
	public $components=array('Flash','Paginator');
	public $uses = array(
        'User',
        'Post',
    );
  //   public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {    
  //       $recursive = -1;
        
  //       // Mandatory to have
  //       $this->useTable = false;
  //       $sql = '';
        
  //       $sql .= "
  //       select posts.* , users.fullname 
		// from posts left join users on 
		// posts.user_id=users.id
		// where posts.visible <> 0

		// ";
        
  //       // Adding LIMIT Clause
  //      // $sql .= (($page - 15) * $limit) . ', ' . $limit;
        
  //       $results = $this->query($sql);
        
  //       return $results;
  //   }
  //   public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        
  //       $sql = '';
        
  //       $sql .= "select posts.* , users.fullname 
		// from posts left join users on 
		// posts.user_id=users.id
		// where posts.visible <> 0";
            
  //       $this->recursive = $recursive;
        
  //       $results = $this->query($sql);
        
  //       return count($results);
  //   }


	public function index(){
																																			
		$options=array('Post.visible <>'=>'0');

		if(isset($this->request->data['Post']['keyword']))
			$options["Post.title like"]="%".$this->request->data['Post']['keyword']."%";

		$this->paginate=array(
		 						'limit'=>15,
								'joins' => array(
				        							[
											            'table' => 'users',
											            'alias' => 'User',
											            'type' => 'left',
											            'conditions' => 'User.id = Post.user_id',

												    ],
							 					),
								'fields'=> array(
												    'User.fullname',
												    'Post.*'
											    ),
								'recursive' => -1
		 );
		$posts=$this->paginate('Post',$options);


			//pr($posts);die();
		$this->set('posts',$posts);

	}
// 	public function initialize(){
//     parent::initialize();
//     // Set the layout
//     $this->viewBuilder()->layout('headLayout');
// }
	public function bulkDelete(){
			$deletd[]="";
		//	print_r($this->request->data);die();
		foreach ($this->request->data as $key=>$value) {
			//print_r($value);die();
			foreach ($value as $v) {
				$this->Post->id=$v;
				$this->Post->set( array('visible' =>0  ));
				if($this->Post->save()){
				$deleted[]=$v;
				}
			}
			# code...
		}
		if(isset($deleted[1]))
			$deletedString=implode(",",$deleted);
		$this->Flash->success("Posts with ID's ".$deletedString." has been deleted successfully");
		$this->redirect('index');
		//die();
	}



	public function view($id=null){
		if(!$id){
			throw new NotFoundException("Invalid Post");
		}
		$post=$this->Post->findById($id);
		if(!$post){
			throw new NotFoundException("Invalid Post");
		}
		if(isset($post['Post']['user_id'])){
			$user=$this->User->findById($post['Post']['user_id']);
			$this->set('user',$user);
		}
		//$this->set('user',$user);
		$this->set('post',$post);
	}

	public function add(){
		if($this->request->is('post')){
	        $this->request->data['Post']['user_id'] = $this->Auth->user('id');
	        

			if($this->Post->save($this->request->data)){
					$this->Flash->success('Your Post Has been added successfully ');
				// $user=$this->User->findById($this->Auth->user('id'));
				// $user['User']['countpost']+=1;

				//die(print_r($user));
		        // $user['User']['countpost']++;
		        // $this->User->id=$this->Auth->user('id');
		        // $this->User->set(array(
	        	// 	'countpost'=> 2//$user['User']['countpost']
	        	// ));

		       	// /*if*/($this->User->save());
				//pr($this->User->validationErrors);
				// pr($this->User->getDataSource()->getLog(false,false)['log']);die;

		       	// die("dsm"); 
				return	$this->redirect(array('action'=>'index'));
			}
			$this->FLash->error('Unable to add the post');

		}

	}
	public function edit($id=null){
	
		if(!$id){
			throw new NotFoundException("Invalid Post");
		}
		$post=$this->Post->findById($id);
		if(!$post){
			throw new NotFoundException("Invalid Post");

		}
		if($this->request->is(array('post','put'))){
			$this->Post->id=$id;
			if($this->Post->save($this->request->data)){
				$this->Flash->success('Post has been edited successfully');
				return $this->redirect(array('action'=>'index'));
			}
			$this->Flash->error('Unable to Update Post');
		}
		if(!$this->request->data){
			$this->request->data=$post;
		}
	}
	public function delete($id=null){
		if(!$id){
			throw new NotFoundException("Invalid Post to be deleted");
		}
		$post=$this->Post->findById($id);
		if(!$post){
			throw new NotFoundException("Invalid Post");
		}
		$this->Post->id=$id;
		$this->Post->set( array('visible' =>0  ));
		if($this->Post->save()){
			$this->Flash->success('Post with id: '.$id.' has been deleted successfully');
		}else {
			$this->Flash->error('Can not delete Post with id: '.$id);
		}
		return $this->redirect(array('action'=>'index'));
	}

	
	public function isAuthorized($user) {
	    // All registered users can add posts
	    if ($this->action === 'add') {
	        return true;
	    }

	    // The owner of a post can edit and delete it
	    if (in_array($this->action, array('edit', 'delete'))) {
	        $postId = (int) $this->request->params['pass'][0];
	        if ($this->Post->isOwnedBy($postId, $user['id'])) {
	            return true;
	        }else {
	        	if($this->action=='edit')
	        		$this->Flash->error('You are not authorized to edit this post ');
	        else if($this->action=='delete')
	        	$this->Flash->error('You are not authorized to delete this post ');
	        }
	    }

	    return parent::isAuthorized($user);
	}

	public function trial1(){

	}

}
