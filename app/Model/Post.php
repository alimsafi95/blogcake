<?php 
class Post extends AppModel {
	public $validate=array(
			'title'=>array(
				'rule'=>'notBlank'
				),
			'body'=>array(
				'rule'=>'notBLank'
				)
		);
	 public $actsAs = array('Containable');
    public $belongsTo = array('User');

	
	public function isOwnedBy($post, $user) {
	    return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
	}
	// public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {    
 //        $recursive = -1;
        
 //        // Mandatory to have
 //        $this->useTable = false;
 //        $sql = '';
        
 //        $sql .= "select posts.* , users.fullname 
	// 			from posts left join users on 
	// 			posts.user_id=users.id
	// 			";
        
 //        // Adding LIMIT Clause
 //       // $sql .= (($page - 1) * $limit) . ', ' . $limit;
        
 //        $results = $this->query($sql);
        
 //        return $results;
 //    }
 //    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        
 //        $sql = '';
        
 //        $sql .= "select posts.* , users.fullname 
	// 			from posts left join users on 
	// 			posts.user_id=users.id
	// 			where posts.visible <> 0
	// 			";
            
 //        $this->recursive = $recursive;
        
 //        $results = $this->query($sql);
        
 //        return count($results);
 //    }


}