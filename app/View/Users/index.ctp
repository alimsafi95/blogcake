<h1> Index Page </h1>
<table> 
<tr> 
<th> ID</th>
<th> User Name </th>
<th> Role </th>
<th> Created </th> 
<th> Modified </th>
<th> Action </th>
</tr>




<?php foreach($users as $user) { ?>
	<tr> 
	<td> <?php echo $user['User']['id']; ?></td>
	<td> <?php echo $this->Html->link($user['User']['username'],array('action'=>'view',$user['User']['id'])); ?></td>
	<td> <?php echo $user['User']['role']; ?></td>
	<td> <?php echo $user['User']['created']; ?></td>
	<td> <?php echo $user['User']['modified']; ?></td>
	<td>  <?php echo $this->Html->link('edit',array('controller'=>'users','action'=>'edit',$user['User']['id']));?>
			<?php echo $this->Form->postLink('delete',array('action'=>'delete',$user['User']['id']),array('confirm'=>'Are you sure you want to delete the record with id: '.$user['User']['id'].'?'));?>	
	 </td>


	</tr>

<?php }?>
<?php echo $this->Html->link('add',array('action'=>'add'));?>
<?php echo $this->Html->link('Logout',array('action'=>'logout'));?>

</table>