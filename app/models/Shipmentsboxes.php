<?php
/*
*	CardShare Web Model File
*	File Name 			: 	Shipmentsboxes.php
*	File Description	:	Model File to map Shipmentboxes Table in DB
*	Created Date 		:	12 - Dec - 2014
*	Last Modified Date 	:	12 - Dec - 2014
*	Company				:	iExemplar
*	Created By			:	Manthiriyappan A
*	Contributors		:	Manthiriyappan A
**/
class Shipmentsboxes extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	// Table Name to be used
	protected $table = 'shipmentsboxes';
	
	// Overwriting Default Audits Fields with the Fields in Table
	const CREATED_AT = 'CREATE_TS';
	const UPDATED_AT  = 'MODIFY_TS';
	
	public function units(){
     return $this->hasMany('Unit');
   }
}