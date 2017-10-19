<!-- <form action="/posts/bulkDelete" method="post"/>
 -->
<?php 
    echo $this->Form->create('Post');
        echo $this->Form->input('keyword',array(
            'type'=>'search'
        ));
    echo $this->Form->end('Search');    

	echo $this->Form->create('Post',array(

		'url'=>array('action'=>'bulkDelete')));
?>
<?php $paginator=$this->Paginator;?>
 <h1> Blog Posts </h1>
 
<table>
<?php 
    echo $this->Html->link('Go to Users',array('controller'=>'users','action'=>'index'));
?>
<tr> 
<th> 

<?php if($this->Session->read('Auth.User.id')){  
     echo   "delete";
    }else {
        echo "<strike> delete </strike>";
    }
?>

 </th>
<th> <?php echo $paginator->sort('id', 'ID'); ?> </th>
<th> <?php echo $paginator->sort('title', 'Title');?> </th>
<th>  <?php echo $paginator->sort('created', 'Created');?> </th>
<th> Author Name </th>
<th>  Action </th>
</tr>

<?php foreach($posts as $post){ ?> 
<tr> 
<td> 

 <?php
if($this->Session->read('Auth.User.id')!=NULL)
 echo $this->Form->checkbox('Post.id', array(
 	'name'=> 'checkbox[]',
  'value' => $post['posts']['id'],
  'hiddenField' => false
));?>

</td>
<td> <?php echo $post['Post']['id'];?></td>
<td> <?php echo $this->Html->link($post['Post']['title'],array('controller'=>'posts','action'=>'view',$post['Post']['id']));?></td>
<td> <?php echo $post['Post']['created'];?> </td>
<td> <?php if(isset($post['User']['fullname'])){ echo $post['User']['fullname'];} ?></td>
<td>  <?php if($post['Post']['user_id']==$this->Session->read('Auth.User.id')||($this->Session->read('Auth.User.role')=='admin')){
            if($this->Session->read('Auth.User.id'))
    echo $this->Html->link('Edit Post',array('controller'=>'posts','action'=>'edit',$post['Post']['id']));}?>
		<?php if($post['Post']['user_id']==$this->Session->read('Auth.User.id')||($this->Session->read('Auth.User.role')=='admin')){
         if($this->Session->read('Auth.User.id'))

         echo $this->Form->postLink('Delete',array('action'=>'delete',$post['Post']['id']),array('confirm'=>'are you sure'));} ?>


</td>

</tr>
<?php } ?> 
<?php unset($post);?>
<?php  
if($this->Session->read('Auth.User.id'))
echo $this->Html->link('Add New Post',array('controller'=>'posts','action'=>'add'));?>

 </table>
<?php  if($this->Session->read('Auth.User.id')) echo $this->Form->end('Delete selected'); ?><!-- <input type="submit" value="Delete" /> 
</form> -->
<?php 
    echo "<div class='paging'>";
 
        // the 'first' page button
        echo $paginator->first("First");
         
        // 'prev' page button, 
        // we can check using the paginator hasPrev() method if there's a previous page
        // save with the 'next' page button
        if($paginator->hasPrev()){
            echo $paginator->prev("Prev");
        }
         
        // the 'number' page buttons
        echo $paginator->numbers(array('modulus' => 2));
         
        // for the 'next' button
        if($paginator->hasNext()){
            echo $paginator->next("Next");
        }
         
        // the 'last' page button
        echo $paginator->last("Last");
     
    echo "</div>";
?>