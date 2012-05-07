<?php
class Book extends AppModel {
	
	public $name = 'Book';
	public $belongsTo = array('User');
	public $components = array('Session');
	public $helpers = array('Html', 'Form');
	
	
	
	public $validate = array(
		
			
			'title' => array(
					'allowEmpty' => false,
					'rule' => array('maxLength', 50),
					'message' => 'The Title field cannot be left blank.'
			),
			'isbn' => array(
					'isbnRule-1' => array(
						'rule' => array('numeric'),
						'allowEmpty' => false,
						'message' => 'the ISBN can only be numbers.'
					),
					'isbnRule-2' => array(
							'rule' => array('maxLength', 10),
							'allowEmpty' => false,
							'message' => 'the ISBN must be 10 digits.'
					),
					'isbnRule-3' => array(
							'rule' => array('minLength', 10),
							'allowEmpty' => false,
							'message' => 'the ISBN must be 10 digits.'
					),
			),
			
			'author' => array(
					'rule' => array('maxLength', 50),
					'allowEmpty' => false,
			),
			
	);
}
?>