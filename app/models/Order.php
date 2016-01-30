<?php
/*
*	CardShare Web Model File
*	File Name 			: 	Order.php
*	File Description	:	Model File to map Country Table in DB
*	Created Date 		:	05 - Dec - 2014
*	Last Modified Date 	:	05 - Dec - 2014
*	Company				:	iExemplar
*	Created By			:	Manthiriyappan A
*	Contributors		:	Manthiriyappan A
**/
class Order extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	// Table Name to be used
	protected $table = 'orders';
	
	// Overwriting Default Audits Fields with the Fields in Table
	const CREATED_AT = 'CREATE_TS';
	const UPDATED_AT  = 'MODIFY_TS';
	protected $primaryKey = 'Order_Id';
	
	public function units(){
     return $this->hasMany('Unit');

   }
}