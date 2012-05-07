<?php
class Post extends AppModel {
	
	public $name = 'Post';
	
	
	public $validate = array(
			'title' => array(
					'rule' => array('maxLength', 10),
					'allowEmpty' => false,
					'message' => 'Title must be less than 10 characters.'
			),
			'body' => array(
					'rule' => array('maxLength', 200),
					'allowEmpty' => false
			)
			
	);
}
?>