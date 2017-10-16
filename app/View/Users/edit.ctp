<h1> Edit User </h1>
<?php 
	echo $this->Form->create('User');
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->end('Edit User');

?>