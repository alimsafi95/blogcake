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
	</tr>

	<tr> 
			<td> <?php echo $post['Post']['id']; ?></td>
			<td> <?php echo $this->Html->link($post['Post']['title'],array('controller'=>'posts','action'=>'view',$post['Post']['id'])); ?></td>
			<td> <?php echo $post['Post']['created']; ?> </td>
	</tr>

</table>