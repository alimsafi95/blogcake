<?php
// app/Model/User.php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'A username is required'
            ), 
            // by adding the line after we modified another rule for the field 
            'rule2'=>array(
                'rule'=>array('maxLength',50),
                'message'=> 'The number of charachters in username must be 50 at most'
                )
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'A password is required'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'author')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        ),
        'fullname'=>array(
            'rule1'=>array(
                'required'=>true,
                'rule'=>'notBlank',
                'message'=>'Please enter your full name'
                ),
            
            ),
        'email'=>array(
            'rule'=>'email',
            'required'=>true,
            'message'=>'Please enter your email address'
            )
    );
        public $actsAs = array('Containable');
    public $hasMany = array('Post');
    public function beforeSave($options = array()) {
    if (isset($this->data[$this->alias]['password'])) {
        $passwordHasher = new BlowfishPasswordHasher();
        $this->data[$this->alias]['password'] = $passwordHasher->hash(
            $this->data[$this->alias]['password']
        );
    }
    return true;
}
}
