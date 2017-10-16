<?php 
class PostsController extends AppController {
	public $helpers=array('Form','Html');
	public $components=array('Flash');
	public function index(){
		$this->set('posts',$this->Post->find('all'));
	}
	public function view($id=null){
		if(!$id){
			throw new NotFoundException("Invalid Post");
			
		}
		$post=$this->Post->findById($id);
		if(!$post){
			throw new NotFoundException("Invalid Post");
			
		}

		$this->set('post',$post);
	}
	public function add(){
		if($this->request->is('post')){
        $this->request->data['Post']['user_id'] = $this->Auth->user('id');

        			if($this->Post->save($this->request->data)){
				$this->Flash->success('Your Post Has been added successfully ');
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
			throw new NotFoundException("Invali Post to be deleted");
		}
		if($this->Post->delete($id)){
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
        }
    }

    return parent::isAuthorized($user);
}

 }
