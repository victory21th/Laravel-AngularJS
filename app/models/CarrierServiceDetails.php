<?php
/*
*	CardShare Web Model File
*	File Name 			: 	CarrierServiceDetails.php
*	File Description	:	Model File to map CarrierServiceDetails Table in DB
*	Created Date 		:	26 - March - 2015
*	Last Modified Date 	:	26 - March - 2015
*	Company				:	iExemplar
*	Created By			:	Manthiriyappan A
*	Contributors		:	Manthiriyappan A
**/
class CarrierServiceDetails extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	// Table Name to be used
	protected $table = 'CarrierServiceDetails';
	
	// Overwriting Default Audits Fields with the Fields in Table
	const CREATED_AT = 'CREATE_TS';
	const UPDATED_AT  = 'MODIFY_TS';
	
	public function units(){
     return $this->hasMany('Unit');
   }
}