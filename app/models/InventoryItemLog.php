<?php
/*
*	FulfillDirect Web Model File
*	File Name 			: 	InventoryItemLog.php
*	File Description	:	Model File to map InventoryItem_Log Table in DB
*	Created Date 		:	06 - March - 2015
*	Last Modified Date 	:	06 - March - 2015
*	Company				:	iExemplar
*	Created By			:	Manthiriyappan A
*	Contributors		:	Manthiriyappan A
**/
class InventoryItemLog extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	// Table Name to be used
	protected $table = 'InventoryItems_Log';
	
	// Overwriting Default Audits Fields with the Fields in Table
	const CREATED_AT = 'Create_ts';
	const UPDATED_AT  = 'Modify_ts';
	
	
}