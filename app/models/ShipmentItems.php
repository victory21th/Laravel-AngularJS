<?php
/*
*	CardShare Web Model File
*	File Name 			: 	ShipmentItems.php
*	File Description	:	Model File to map ShipmentItem Table in DB
*	Created Date 		:	23 - April - 2015
*	Last Modified Date 	:	23 - April- 2015
*	Company				:	iExemplar
*	Created By			:	Manthiriyappan A
*	Contributors		:	Manthiriyappan A
**/
class ShipmentItems extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	// Table Name to be used
	protected $table = 'ShipmentItems';
	
	// Overwriting Default Audits Fields with the Fields in Table
	const CREATED_AT = 'CREATE_TS';
	const UPDATED_AT  = 'MODIFY_TS';
	
	public function units(){
     return $this->hasMany('Unit');
   }
}