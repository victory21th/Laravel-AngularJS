<?php
/*
*	CardShare Web Model File
*	File Name 			: 	Enterprise.php
*	File Description	:	Model File to map Inventory Controller to the InventoryItem Table in DB
*	Created Date 		:	05 - Dec - 2014
*	Company				:	iExemplar
*	Created By			:	Allen Emanuel Raj D
*	Contributors		:	Allen Emanuel Raj D
**/
class Inventory extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	// Table Name to be used
	protected $table = 'inventoryitems';
	
	// Overwriting Default Audits Fields with the Fields in Table
	const CREATED_AT = 'Create_ts';
	const UPDATED_AT  = 'Modify_ts';

	protected $primaryKey = 'InventoryItem_Id';
}