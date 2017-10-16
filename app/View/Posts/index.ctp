<h1> Blog Posts </h1>
<table>
<tr> 
<th> ID </th>
<th> Title </th>
<th> Created </th>
<th>  Action </th>
</tr>
<?php foreach($posts as $post){ ?> 
<tr> 
<td> <?php echo $post['Post']['id'];?></td>
<td> <?php echo $this->Html->link($post['Post']['title'],array('controller'=>'posts','action'=>'view',$post['Post']['id']));?></td>
<td> <?php echo $post['Post']['created'];?> </td>
<td>  <?php echo $this->Html->link('Edit Post',array('controller'=>'posts','action'=>'edit',$post['Post']['id']));?>
		<?php echo $this->Form->postLink('Delete',array('action'=>'delete',$post['Post']['id']),array('confirm'=>'are you sure')); ?>


</td>

</tr>
<?php } ?> 
<?php unset($post);?>
<?php echo $this->Html->link('Add New Post',array('controller'=>'posts','action'=>'add'));?>
 </table>
