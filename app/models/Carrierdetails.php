<?php
/*
*	CardShare Web Model File
*	File Name 			: 	Carrierdetails.php
*	File Description	:	Model File to map Shipment Table in DB
*	Created Date 		:	10 - Dec - 2014
*	Last Modified Date 	:	10 - Dec - 2014
*	Company				:	iExemplar
*	Created By			:	Manthiriyappan A
*	Contributors		:	Manthiriyappan A
**/
class Carrierdetails extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	// Table Name to be used
	protected $table = 'CarrierDetails';
	
	// Overwriting Default Audits Fields with the Fields in Table
	const CREATED_AT = 'CREATE_TS';
	const UPDATED_AT  = 'MODIFY_TS';
	
	public function units(){
     return $this->hasMany('Unit');
   }
}