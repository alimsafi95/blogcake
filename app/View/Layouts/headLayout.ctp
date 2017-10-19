<?php
	
 ?> 
 <table> 
 <tr> 
 <th> <?php if($this->Session->read('Auth.User.id')){
				echo "Welcome Back ".$this->Session->read('Auth.User.username');

			}else {

				echo $this->Html->link('Please Login',array('controller'=>'users','action'=>'login'));

			}	?>
				

</th>
<th> 
	<?php if($this->Session->read('Auth.User.id')){
				echo "Mr. ".$this->Session->read('Auth.User.fullname');

			}else {

				

			}	?>
				


</th>
<th> 
<?php 
		if($this->Session->read('Auth.User.id'))
			echo $this->Html->link('Logot',array('controller'=>'users','action'=>'logout'));
?>


 </th>
 </tr>

 </table>