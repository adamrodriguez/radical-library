<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Group $Group
 * @property Book $Book
 */
class User extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $name = 'User';
	
	public function beforeSave() {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password'], 'sha512', true);
		}
	
		return true;
	}
	
	public function bindNode($user) {
		return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}
	
	
	public $actsAs = array('Acl' => array('type' => 'requester'));
	
	public function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId) {
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}
	
	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Book' => array(
			'className' => 'Book',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	public $validate = array(
				
	
				
			'username' => array(
					'usernameRule-1' => array(
							'rule' => array('minLength', 5),
							'message' => 'Username must be longer than 5 characters'
	
					),
					'usernameRule-2' => array(
							'rule' => array('isUnique'),
							'message' => 'The username has been taken'
					),
			),
			'password' => array(
					'passwordRule-1' => array(
							'rule' => array('alphaNumeric'),
							'message' => 'A password is required'
					),
					'passwordRule-2' => array(
							'rule' => array('minLength', 8),
							'message' => array('The password must have at least 8 characters')
					),
					'passwordRule-3' => array(
							'rule' => 'alphaNumeric',
							'message' => array('The password must have letters and numbers')
					)
			),
	
				
			'firstname' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'Your first name is required'
					)
			),
			'lastname' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'Your last name is required'
					)
			),
				
		
				
	);

}
