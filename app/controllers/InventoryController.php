<?php
/*
*	CardShare Web Controller Side
*	File Name 			: 	InventoryController.php
*	File Description	:	Inventory Controller to Manage Add, Edit and Search on Inventory for FulFillDirect
*	Created Date 		:	05 - Dec - 2014
*	Company				:	iExemplar
*	Created By			:	Allen Emanuel Raj D
*	Contributors		:	Allen Emanuel Raj D, Manthiriyappan A.
**/


class InventoryController extends \BaseController {
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){	
		$inventory_list =  DB::select(DB::raw("SELECT * FROM `InventoryItems` WHERE Channel_Id=".Input::json('channel')." AND Warehouse_Id=".Input::json('warehouse')." AND Product_Id=".Input::json('product')));
		if(empty($inventory_list)){	
			$inv_dtl = new Inventory;
			$inv_dtl->Product_Id =  Input::json('product');
			$inv_dtl->Warehouse_Id = Input::json('warehouse');
			$inv_dtl->Channel_Id =  Input::json('channel');
			$inv_dtl->Stock_Count =  ((Input::json('stock_count')) + (Input::json('add_qty')));
			$inv_dtl->Re_Order_Level = ( Input::json('re_order_level') ?  Input::json('re_order_level') : null);
			$inv_dtl->Notes = Input::json('notes');
			$inv_dtl->Reason = Input::json('reason');
			$inv_dtl->LastCycleCount = ( Input::json('lastcyclecount') ?  Input::json('lastcyclecount') : null);
			$inv_dtl->LastAdjustmentCount =	( Input::json('lastadjustmentcount') ?  Input::json('lastadjustmentcount') : null);
			$inv_dtl->Active = 1;
			$inv_dtl->Create_ts = date("Y-m-d H:i:s");
			$inv_dtl->Modify_ts = date("Y-m-d H:i:s");
			$inv_dtl->save();
			
			//History Maintain for Log table
			$inv_log_dtl = new InventoryItemLog;
			$inv_log_dtl->InventoryItem_Id = $inv_dtl->InventoryItem_Id;
			$inv_log_dtl->Product_Id =  Input::json('product');
			$inv_log_dtl->Warehouse_Id =  Input::json('warehouse');
			$inv_log_dtl->Channel_Id = Input::json('channel');
			$inv_log_dtl->Stock_Count = Input::json('add_qty');
			$inv_log_dtl->Re_Order_Level = Input::json('re_order_level');
			$inv_log_dtl->Notes = Input::json('notes');
			$inv_log_dtl->Reason = Input::json('re_order_level');
			$inv_log_dtl->LastCycleCount = Input::json('lastcyclecount');
			$inv_log_dtl->LastAdjustmentCount = Input::json('lastadjustmentcount');	
			$inv_log_dtl->Active = 1;
			$inv_log_dtl->Create_ts = date("Y-m-d H:i:s");
			$inv_log_dtl->Modify_ts = date("Y-m-d H:i:s");		
			$inv_log_dtl->save();
		}else{	
			$inventory_list =  DB::select(DB::raw("SELECT * FROM `InventoryItems` WHERE Channel_Id=".Input::json('channel')." AND Warehouse_Id=".Input::json('warehouse')." AND Product_Id=".Input::json('product')));
			$update_inventory_details = DB::select(DB::raw('update inventoryitems set 
				Stock_Count ='. Input::json('add_qty').' + '.$inventory_list[0]->Stock_Count.', 
				Re_Order_Level ='. Input::json('re_order_level').',
				LastCycleCount ='. Input::json('lastcyclecount').',
				LastAdjustmentCount ='. Input::json('lastadjustmentcount').',
				Notes = '."'". Input::json('notes')."'".',				
				Reason = '."'". Input::json('reason')."'".' 
				where InventoryItem_Id = '.$inventory_list[0]->InventoryItem_Id));				
						
			//History Maintain for Log table
			$inv_log_dtl = new InventoryItemLog;
			$inv_log_dtl->InventoryItem_Id = $inventory_list[0]->InventoryItem_Id;
			$inv_log_dtl->Product_Id =  Input::json('product');
			$inv_log_dtl->Warehouse_Id =  Input::json('warehouse');
			$inv_log_dtl->Channel_Id = Input::json('channel');
			$inv_log_dtl->Stock_Count = Input::json('add_qty')+ $inventory_list[0]->Stock_Count;;
			$inv_log_dtl->Re_Order_Level = ( Input::json('re_order_level') ?  Input::json('re_order_level') : null);
			$inv_log_dtl->Notes = Input::json('notes');
			$inv_log_dtl->Reason = Input::json('re_order_level');
			$inv_log_dtl->LastCycleCount = ( Input::json('lastcyclecount') ?  Input::json('lastcyclecount') : null);
			$inv_log_dtl->LastAdjustmentCount = 	( Input::json('lastadjustmentcount') ?  Input::json('lastadjustmentcount') : null);
			$inv_log_dtl->Active = 1;
			$inv_log_dtl->Create_ts = date("Y-m-d H:i:s");
			$inv_log_dtl->Modify_ts = date("Y-m-d H:i:s");		
			$inv_log_dtl->save();			
		}
	}

	public function inventoryList(){
		$requested_wh_right ="AllowInvView";
		$usergroup = User::find(Auth::id())->usergroup()->first();
		$inventory_list = DB::select(DB::raw("SELECT INV.InventoryItem_Id, INV.Product_Id,
			INV.Warehouse_Id, INV.Channel_Id, INV.Stock_Count, INV.Re_Order_Level,INV.Notes,
			INV.Reason,INV.LastCycleCount,INV.LastAdjustmentCount,PRD.Product_Name,
			WH.Warehouse_Name, CH.Channel_Name , PRD.SKU FROM inventoryitems AS INV 
			INNER JOIN products AS PRD ON PRD.Product_Id= INV.Product_Id 
			INNER JOIN warehouses AS WH ON WH.Warehouse_Id=INV.Warehouse_Id 
			INNER JOIN channels AS CH ON CH.Channel_Id=INV.Channel_Id"));
		return Response::json(array('response' => $inventory_list));
	}	
	
	public function productList(){
		$product_list = DB::select(DB::raw("SELECT Product_Id, CONCAT(Product_Name,' - SKU:' ,SKU) as Product_Name  FROM Products WHERE Channel_id=".Input::json('Channel_Id')));
		return Response::json(array('response' => $product_list));
	}
	
	public function stockCount(){
		$stock_list = DB::select(DB::raw("SELECT Stock_Count,Re_Order_Level,Notes,Reason,LastCycleCount,LastAdjustmentCount	FROM InventoryItems WHERE Channel_Id='".Input::json('Channel_Id')."' AND Warehouse_Id='".Input::json('Warehouse_Id')."' AND Product_Id=".Input::json('Product_Id')));   
		return Response::json(array('response' => $stock_list));		
	}
	

	

	
	public function getEditInventoryDetails(){
		$inventory_list = DB::select(DB::raw("SELECT INV.InventoryItem_Id, INV.Product_Id, 
			INV.Warehouse_Id, INV.Channel_Id, INV.Stock_Count, 
			INV.Re_Order_Level,INV.LastCycleCount,INV.LastAdjustmentCount,INV.Notes,
			INV.Reason,INV.Modify_ts,PRD.Product_Name,
			PRD.Product_Description,PRD.SKU,PRD.UnitWeight,
			PRD.RefItemId,WH.Warehouse_Name, CH.Channel_Name FROM inventoryitems AS INV 
			INNER JOIN products AS PRD ON PRD.Product_Id= INV.Product_Id 
			INNER JOIN warehouses AS WH ON WH.Warehouse_Id=INV.Warehouse_Id 
			INNER JOIN channels AS CH ON CH.Channel_Id=INV.Channel_Id 
		WHERE INV.InventoryItem_Id = ". Input::json('id') )); 
		$product_list = DB::table('products')->get();
		$warehouse_list = DB::table('warehouses')->get();
		$channel_list = DB::table('channels')->get();
		return Response::json(array('response' => $inventory_list, 'product' => $product_list, 'warehouse' => $warehouse_list, 'channel' => $channel_list));
	}
	
	public function editInventoryDetail(){
		$Re_Order_Level = ( Input::json('re_order_level') ?  Input::json('re_order_level') : 'NULL');
		$LastCycleCount = ( Input::json('lastcyclecount') ?  Input::json('lastcyclecount') :'NULL' );
		$LastAdjustmentCount = ( Input::json('lastadjustmentcount') ?  Input::json('lastadjustmentcount') : 'NULL');
		$inventory_list =  DB::select(DB::raw("SELECT * FROM `InventoryItems` WHERE Channel_Id=".Input::json('channel')." AND Warehouse_Id=".Input::json('warehouse')." AND Product_Id=".Input::json('product')));
		$update_inventory_details = DB::select(DB::raw('UPDATE inventoryitems SET 
			Stock_Count ='. Input::json('add_quantity').' + '.$inventory_list[0]->Stock_Count.', 
			Re_Order_Level ='. $Re_Order_Level.', Notes = '."'". Input::json('notes')."'".',
			LastCycleCount = '.$LastCycleCount.',LastAdjustmentCount = '.$LastAdjustmentCount.',
			Reason = '."'". Input::json('reason')."'".' where InventoryItem_Id = ' . Input::json('inventoryid'))); 
						
			$inv_log_dtl = new InventoryItemLog;
			$inv_log_dtl->InventoryItem_Id = Input::json('inventoryid');
			$inv_log_dtl->Product_Id =  Input::json('product');
			$inv_log_dtl->Warehouse_Id =  Input::json('warehouse');
			$inv_log_dtl->Channel_Id = Input::json('channel');
			$inv_log_dtl->Stock_Count = Input::json('add_quantity')+ $inventory_list[0]->Stock_Count;
			$inv_log_dtl->Re_Order_Level = ( Input::json('re_order_level') ?  Input::json('re_order_level') : null);
			$inv_log_dtl->Notes = Input::json('notes');
			$inv_log_dtl->Reason = Input::json('reason');
			$inv_log_dtl->LastCycleCount = ( Input::json('lastcyclecount') ?  Input::json('lastcyclecount') : null);
			$inv_log_dtl->LastAdjustmentCount = ( Input::json('lastadjustmentcount') ?  Input::json('lastadjustmentcount') : null);
			$inv_log_dtl->Active = 1;
			$inv_log_dtl->Create_ts = date("Y-m-d H:i:s");
			$inv_log_dtl->Modify_ts = date("Y-m-d H:i:s");		
			$inv_log_dtl->save();
		
		return Response::json(array('response' => "Succesfully Updated!!!"));
	}
	
	public function deleteInventoryDetail(){
		$update_company_card_details = DB::select(DB::raw('UPDATE inventoryitems SET `ACTIVE` = "0" where InventoryItem_Id = ' . Input::json('inventoryid'))); 
		$inventory_list = DB::select(DB::raw("SELECT INV.InventoryItem_Id, INV.Product_Id, 
			INV.Warehouse_Id, INV.Channel_Id, INV.Stock_Count, INV.Re_Order_Level, PRD.Product_Name,
			WH.Warehouse_Name, CH.Channel_Name FROM inventoryitems AS INV 
			INNER JOIN products AS PRD ON PRD.Product_Id= INV.Product_Id 
			INNER JOIN warehouses AS WH ON WH.Warehouse_Id=INV.Warehouse_Id 
			INNER JOIN channels AS CH ON CH.Channel_Id=INV.Channel_Id WHERE INV.ACTIVE ='1'")); 
		return Response::json(array('response' => $inventory_list));
	}
	
	public function getInventoryListCount(){
		$requested_wh_right ="AllowInvView";
		$usergroup = User::find(Auth::id())->usergroup()->first();
		$inventory_list = DB::select(DB::raw("SELECT INV.InventoryItem_Id, INV.Product_Id, 
			INV.Warehouse_Id, INV.Channel_Id, INV.Stock_Count, INV.Re_Order_Level, PRD.Product_Name,PRD.SKU,PRD.RefItemId,
			WH.Warehouse_Name, CH.Channel_Name ,  prd.SKU  FROM inventoryitems AS INV 
			INNER JOIN products AS PRD ON PRD.Product_Id= INV.Product_Id 
			INNER JOIN warehouses AS WH ON WH.Warehouse_Id=INV.Warehouse_Id 
			INNER JOIN channels AS CH ON CH.Channel_Id=INV.Channel_Id WHERE INV.ACTIVE ='1'
				and WH.Warehouse_id in(select ugwhr.Warehouse_Id
										from UsergroupsWHRights ugwhr, warehouserights whr
										  where ugwhr.UserGroup_Id = ".$usergroup->UserGroup_Id."
				 								and whr.Warehouse_Right_Name = '".$requested_wh_right."')"));
		return Response::json(array('all_inventory_count' =>$inventory_list));
	}

	public function allowInvEditDelete()
	{
		$inventory_id = Input::json('id');
		$requested_wh_right ="AllowInvEditDelete";
		$usergroup = User::find(Auth::id())->usergroup()->first();
		$warehouse_id =Inventory::find($inventory_id)->Warehouse_Id;

		//select form usergroup channel rights where the channel_id and usergroup_id and ch_right
		$Right_list = DB::select(DB::raw(
			"SELECT ugwhr.* FROM usergroupswhrights ugwhr, warehouserights whr
				WHERE ugwhr.Warehouse_Id = ".$warehouse_id." and ugwhr.UserGroup_Id = ".$usergroup->UserGroup_Id."
					and ugwhr.Warehouse_Right_Id =  whr.WarehouseRight_Id
					and whr.Warehouse_Right_Name = '".$requested_wh_right."'"));

		return Response::json(count($Right_list) >0);
	}
	public function warehouseLisxt(){
		$warehouse_list = DB::table('warehouses')->get();
		return Response::json(array('response' => $warehouse_list));
	}

	public function warehouseList()
	{
		$requested_wh_right ="AllowInvAdd";
		$usergroup = User::find(Auth::id())->usergroup()->first();

		//select form usergroup channel rights where the channel_id and usergroup_id and ch_right
		$warehouse_list = DB::select(DB::raw(
			"SELECT wh.* FROM usergroupswhrights ugwhr, warehouserights whr, warehouses wh
				WHERE ugwhr.UserGroup_Id = ".$usergroup->UserGroup_Id."
					and wh.Warehouse_Id = ugwhr.Warehouse_Id
					and ugwhr.Warehouse_Right_Id =  whr.WarehouseRight_Id
					and whr.Warehouse_Right_Name = '".$requested_wh_right."'"));

		return Response::json(array('response' => $warehouse_list));
	}

	public function allowInvAdd()
	{
		$requested_wh_right ="AllowInvAdd";
		$usergroup = User::find(Auth::id())->usergroup()->first();


		//select form usergroup channel rights where the channel_id and usergroup_id and ch_right
		$Right_list = DB::select(DB::raw(
			"SELECT ugwhr.* FROM usergroupswhrights ugwhr, warehouserights whr
				WHERE ugwhr.UserGroup_Id = ".$usergroup->UserGroup_Id."
					and ugwhr.Warehouse_Right_Id =  whr.WarehouseRight_Id
					and whr.Warehouse_Right_Name = '".$requested_wh_right."'"));

		return Response::json(count($Right_list) >0);
	}

	public function channelListx(){
		$channel_list = DB::table('channels')->get();
		return Response::json(array('response' => $channel_list));
	}

	public function channelList()
	{

		$requested_ch_right = "AllowChannelView";
		$usergroup = User::find(Auth::id())->usergroup()->first();

		//select form usergroup channel rights where the channel_id and usergroup_id and ch_right
		$channel_list = DB::select(DB::raw(
			"SELECT ch.* FROM usergroupchannelrights ugchr, channelsrights chr, channels ch
				WHERE ugchr.UserGroup_Id = ".$usergroup->UserGroup_Id."
					and ch.Channel_Id = ugchr.Channel_id
					and ugchr.Channel_Right_Id =  chr.ChannelRight_Id
					and chr.Channel_Right_Name = '".$requested_ch_right."'"));

		return Response::json(array('response' => $channel_list));
	}

}
