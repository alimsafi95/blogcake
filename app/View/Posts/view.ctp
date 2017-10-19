<table> 
	<tr> 
			<th> 
			ID
			</th>
			<th> 
			Title
			</th>
			<th> 
			Created 
			</th>
			<th> 
			Full Name</th>
			<th> 
			email </th>

	</tr>

	<tr> 
			<td> <?php echo $post['Post']['id']; ?></td>
			<td> <?php echo $this->Html->link($post['Post']['title'],array('controller'=>'posts','action'=>'view',$post['Post']['id'])); ?></td>
			<td> <?php echo $this->Time->format(
 												 'F jS, Y h:i A',
  												$post['Post']['created'],
												  null
												); ?>
			 </td>
			
			<?php 
				if(isset($user)){
					echo "<td>". $user['User']['fullname']."</td>";
					echo "<td>". $user['User']['email']."</td>";

				}
			?>

			
	</tr>

</table>

<center>
<h1><?php echo h($post['Post']['title']); ?></h1>

<p><small><?php echo $this->Time->format(
 												 'F jS, Y h:i A',
  												$post['Post']['created'],
												  null
												); ?></small></p>

<p><?php echo h($post['Post']['body']); ?></p>
</center>