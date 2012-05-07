 <div id="search">
  <?php echo $this->Form->create('Book',array('action'=>'search'));?>
   <fieldset>
    <legend><?php __('Book Search');?></legend>
    <?php
    echo $this->Form->input('searchtitle', array('label' => __('Search by Title:', true)));
    echo $this->Form->input('searchauthor', array('label' => __('Search by Author:', true)));
    echo $this->Form->input('searchisbn', array('label' => __('Search by ISBN:', true)));

    $options = array(
                     'label' => 'Search',
                     'value' => 'Search',
                     'class' => 'searchbutton'
                            );
    echo $this->Form->end($options);


?>
</fieldset>



    </div>
    <div id="contentbox">
<table>
	
		
	<?php if(!empty($books)) : ?>
   <?php foreach ($books as $book): ?>
	<tr>
		
		
		<td><?php echo h($book['Book']['title']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['author']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['isbn']); ?>&nbsp;</td>
		
		
			
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Checkout'), array('action' => 'checkout', $book['Book']['id'])); ?>
			<?php echo $this->Html->link(__('Checkin'), array('action' => 'checkin', $book['Book']['id'])); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $book['Book']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $book['Book']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $book['Book']['id']), null, __('Are you sure you want to delete # %s?', $book['Book']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
 <?php else : ?>

 <div>
   No search matches found
   </div>

     <?php endif; ?>

</table>
    </div>
