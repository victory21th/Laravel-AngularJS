<?php
/**	
*	File Name 			: 	orderList.php
*	File Description	:	To List Order Details in a Grid
*	Created Date 		:	05- DEC - 2014
*	Modified Date 		:	09- DEC - 2014
*	Company				:	iExemplar
*	Created By			:	Manthiriyappan A
*	Contributors		:	Manthiriyappan A
**/
class OrderController extends BaseController {	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function orderList(){
		$requested_ch_right ="AllowOrderView";
		$usergroup = User::find(Auth::id())->usergroup()->first();
		$order_list = DB::select(DB::raw("SELECT ORE.Requested_Ship_Date,ORE.ORDER_ID,job.Job_Id,job.Channel_id,
			JTS.JobTypeStatus_Id,JTS.Status_Name,ORE.Order_Date,ORE.ChannelName,ORE.ShipName,
			ORE.ShipAddress1,ORE.ShipAddress2,ORE.ShipCompany,ORE.ShipCity,ORE.ShipZip,ORE.ShipState,
			ORE.ShipCountry,ORE.ShipEmail,ORE.BillName,ORE.BillAddress1,ORE.BillAddress2,
			ORE.BillCompany,ORE.BillCity,ORE.BillZip,ORE.BillState,ORE.BillCountry,ORE.BillEmail,
			ORE.BillPhone,ORE.RefOrderId,ORE.OrderTotal,ORE.TotalShipmentPrice,ORE.CarrierName,
			ORE.CarrierServiceName,ORE.Comments,OREI.Order_Qty,OREI.Active,ORE.Create_ts,ORE.Modify_ts,
			OREI.Order_Item,PRO.Product_Name,pro.Price,OREI.ItemDescription,OREI.SKU,OREI.UnitWeight,
			OREI.ItemPrice,OREI.ItemRefId FROM `orders` AS ORE
			LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id
			LEFT JOIN Jobs AS job ON job.Job_Id=ORE.Job_Id
			LEFT JOIN jobtypestatus AS JTS ON JTS.JobTypeStatus_Id=JOB.Job_Status_Id  
			LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item			
			WHERE ORE.Active = ".'"1"'." AND OREI.Active = ".'"1"'." GROUP BY ORE.ORDER_ID
			HAVING job.Channel_id in(select ugchr.Channel_id
										from Usergroupchannelrights ugchr, channelsrights chr
										  where ugchr.UserGroup_Id = ".$usergroup->UserGroup_Id."
				 								and chr.Channel_Right_Name = '".$requested_ch_right."')"));
		return Response::json(array('response' => $order_list));
	}
	
	
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function orderListShipment(){		
	$order_list = DB::select(DB::raw("SELECT ORE.ORDER_ID, ORE.Order_Date,ORE.ChannelName,
		ORE.ShipName,ORE.ShipAddress1,ORE.ShipAddress2,ORE.ShipCompany,ORE.ShipCity,ORE.ShipZip,
		ORE.ShipState,ORE.ShipCountry,ORE.ShipEmail,ORE.BillName,ORE.BillAddress1,ORE.BillAddress2,
		ORE.BillCompany,BillCity,ORE.BillZip,ORE.BillState,ORE.BillCountry,ORE.BillEmail,
		ORE.BillPhone,ORE.RefOrderId,ORE.OrderTotal,ORE.TotalShipmentPrice,ORE.CarrierName,
		ORE.CarrierServiceName,ORE.Comments ,ORE.Job_Id, OREI.Order_Qty, OREI.Balance_Qty, 
		OREI.Order_Item, PRO.Product_Name, JOB.Channel_Id from orders AS ORE 
		LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item 
		LEFT JOIN jobs AS JOB ON JOB.Job_Id = ORE.Job_Id where OREI.Balance_Qty != ".'"0"'." Group By ORE.ORDER_ID")); 		
	return Response::json(array('response' => $order_list));
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getChannelProductDetails(){
	$channel_wise_warehouse_product = DB::select(DB::raw("SELECT pro.Product_Id,CONCAT(pro.RefItemId,'-',pro.Product_Name,'-',pro.SKU) as Product_Name,
pro.Channel_Id,cha.Channel_Name FROM PRODUCTS AS pro
		LEFT JOIN channels AS cha ON cha.Channel_Id = pro.Channel_Id 
		WHERE PRO.Active=".'"1"'." AND cha.Active=".'"1"'." AND cha.Channel_Id=". Input::json('channel_id'))); 
	return Response::json(array('response' => $channel_wise_warehouse_product));	
	}	
	
	// Get Stock Count	
	public function getAvilableQtyDetails(){
	$avilable_qty = DB::select(DB::raw("SELECT CH.Channel_Name,PRO.Product_Id, INVENT.Stock_Count,
		WARE.Warehouse_Name,PRO.Product_Name from InventoryItems AS INVENT
		LEFT JOIN Channels AS CH ON CH.Channel_Id = INVENT.Channel_Id
		LEFT JOIN Warehouses AS WARE ON WARE.Warehouse_Id = INVENT.Warehouse_Id 
		LEFT JOIN Products AS PRO ON PRO.Product_Id = INVENT.Product_Id
		WHERE INVENT.ACTIVE=".'"1"'." AND CH.ACTIVE=".'"1"'." AND WARE.ACTIVE=".'"1"'." AND PRO.ACTIVE=".'"1"'." AND INVENT.Channel_Id=". Input::json('channel_id')." AND INVENT.Warehouse_Id=". Input::json('warehouse_id')." AND INVENT.Product_Id=". Input::json('product_id'))); 
	return Response::json(array('avilable_qty' => $avilable_qty));
	}			
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */	 
	 
	public function getChannelWarehouseDetails(){				
	$channel_wise_warehouse = DB::select(DB::raw("SELECT INVENT.Warehouse_Id, WARE.Warehouse_Name,
			INVENT.Channel_Id,CHA.Channel_Name from inventoryitems AS INVENT
			INNER JOIN Warehouses AS WARE ON WARE.Warehouse_Id=INVENT.Warehouse_Id 
			INNER JOIN channels AS CHA ON CHA.Channel_Id=INVENT.Channel_Id 
			WHERE WARE.Active=".'"1"'." 
			AND INVENT.Active=".'"1"'." 
			AND INVENT.Channel_Id=". Input::json('channel_id')." 
			GROUP BY INVENT.Warehouse_Id")); 		 
	return Response::json(array('response' => $channel_wise_warehouse));
	} 
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function packingOrderDetails(){	
	$order_list = DB::select(DB::raw("select ore.ORDER_ID,CHE.Channel_Name,job.Channel_Id,job.Job_Id,
		ori.ItemName,ori.Order_Qty,ori.Balance_Qty,ori.Order_Item,inv.Product_Id,ore.* FROM Orders AS ore 
		LEFT JOIN OrderItems AS ori ON ori.Order_Id = ore.Order_Id 
		LEFT JOIN Jobs AS job ON job.Job_Id=ore.Job_Id 
		LEFT JOIN InventoryItems AS inv ON inv.Product_Id = ori.Order_Item OR ori.Order_Item=".'"0"'."
		LEFT JOIN channels AS CHE ON CHE.Channel_Id=JOB.Channel_Id 
	WHERE ori.Order_Id=". Input::json('id')));
	
	$channel_list = DB::table('channels')->get();
	$product_list = DB::table('products')->get();
	return Response::json(array('response' => $order_list,'channel' => $channel_list, 'product' => $product_list));
	}
	
	public function itemOrderDetails(){	
	$order_list_item = DB::select(DB::raw("select ore.ORDER_ID,ori.Order_Item_Id,inv.Stock_Count,CHE.Channel_Id,
		job.Job_Id,ori.ItemName,ori.Order_Qty,ori.Balance_Qty,ori.Order_Item,inv.Product_Id,ore.* FROM Orders AS ore 
		INNER JOIN OrderItems AS ori ON ori.Order_Id = ore.Order_Id 
		INNER JOIN Jobs AS job ON job.Job_Id=ore.Job_Id 
		INNER JOIN InventoryItems AS inv ON inv.Product_Id = ori.Order_Item or ori.Order_Item=".'"0"'."
		INNER JOIN channels AS CHE ON CHE.Channel_Id=JOB.Channel_Id 
	WHERE inv.Warehouse_Id=". Input::json('warehouse_id')." AND inv.Channel_Id=". Input::json('channel_id')." AND ori.Order_Id=". Input::json('id')." GROUP BY ori.`Order_Item_Id`")); 
	
	$channel_list = DB::table('channels')->get();
	$product_list = DB::table('products')->get();
	return Response::json(array('itemresponse' => $order_list_item,'channel' => $channel_list, 'product' => $product_list));
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function newOrderList(){		
	$new_order_list = DB::select(DB::raw("SELECT ORE.Requested_Ship_Date,ORE.ORDER_ID,job.Job_Id,
		JTS.JobTypeStatus_Id,JTS.Status_Name,ORE.Order_Date,ORE.ChannelName,ORE.ShipName,
		ORE.ShipAddress1,ORE.ShipAddress2,ORE.ShipCompany,ORE.ShipCity,ORE.ShipZip,ORE.ShipState,
		ORE.ShipCountry,ORE.ShipEmail,ORE.BillName,ORE.BillAddress1,ORE.BillAddress2,ORE.BillCompany,
		ORE.BillCity,ORE.BillZip,ORE.BillState,ORE.BillCountry,ORE.BillEmail,ORE.BillPhone,
		ORE.RefOrderId,ORE.OrderTotal,ORE.TotalShipmentPrice,ORE.CarrierName,ORE.CarrierServiceName,
		ORE.Comments,OREI.Order_Qty,OREI.Active,ORE.Create_ts,ORE.Modify_ts,OREI.Order_Item,
		PRO.Product_Name,pro.Price FROM `orders` AS ORE
		LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id
		LEFT JOIN Jobs AS job ON job.Job_Id=ORE.Job_Id
		LEFT JOIN jobtypestatus AS JTS ON JTS.JobTypeStatus_Id=JOB.Job_Status_Id 
		LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item 
	WHERE ORE.Active = ".'"1"'." AND JOB.Job_Status_Id = ".'"1"'." AND OREI.Active = ".'"1"'." group by ORE.ORDER_ID")); 
	return Response::json(array('response' => $new_order_list));
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function inprogressOrderList(){
	$inprogress_order_list = DB::select(DB::raw("SELECT ORE.Requested_Ship_Date,ORE.ORDER_ID,job.Job_Id,
		JTS.JobTypeStatus_Id,JTS.Status_Name,ORE.Order_Date,ORE.ChannelName,ORE.ShipName,
		ORE.ShipAddress1,ORE.ShipAddress2,ORE.ShipCompany,ORE.ShipCity,ORE.ShipZip,ORE.ShipState,
		ORE.ShipCountry,ORE.ShipEmail,ORE.BillName,ORE.BillAddress1,ORE.BillAddress2,ORE.BillCompany,
		ORE.BillCity,ORE.BillZip,ORE.BillState,ORE.BillCountry,ORE.BillEmail,ORE.BillPhone,
		ORE.RefOrderId,ORE.OrderTotal,ORE.TotalShipmentPrice,ORE.CarrierName,ORE.CarrierServiceName,
		ORE.Comments,OREI.Order_Qty,OREI.Active,ORE.Create_ts,ORE.Modify_ts,OREI.Order_Item,
		PRO.Product_Name,pro.Price FROM `orders` AS ORE
		LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id
		LEFT JOIN Jobs AS job ON job.Job_Id=ORE.Job_Id
		LEFT JOIN jobtypestatus AS JTS ON JTS.JobTypeStatus_Id=JOB.Job_Status_Id 
		LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item 
	WHERE ORE.Active = ".'"1"'." AND JOB.Job_Status_Id = ".'"2"'." AND OREI.Active = ".'"1"'." group by ORE.ORDER_ID")); 
	return Response::json(array('response' => $inprogress_order_list));
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function closedOrderList(){
	$closed_order_list = DB::select(DB::raw("SELECT ORE.Requested_Ship_Date	,ORE.ORDER_ID,job.Job_Id,
		JTS.JobTypeStatus_Id,JTS.Status_Name,ORE.Order_Date,ORE.ChannelName,ORE.ShipName,
		ORE.ShipAddress1,ORE.ShipAddress2,ORE.ShipCompany,ORE.ShipCity,ORE.ShipZip,ORE.ShipState,
		ORE.ShipCountry,ORE.ShipEmail,ORE.BillName,ORE.BillAddress1,ORE.BillAddress2,ORE.BillCompany,
		ORE.BillCity,ORE.BillZip,ORE.BillState,ORE.BillCountry,ORE.BillEmail,ORE.BillPhone,
		ORE.RefOrderId,ORE.OrderTotal,ORE.TotalShipmentPrice,ORE.CarrierName,ORE.CarrierServiceName,
		ORE.Comments,OREI.Order_Qty,OREI.Active,ORE.Create_ts,ORE.Modify_ts,OREI.Order_Item,
		PRO.Product_Name,pro.Price FROM `orders` AS ORE
		LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id
		LEFT JOIN Jobs AS job ON job.Job_Id=ORE.Job_Id
		LEFT JOIN jobtypestatus AS JTS ON JTS.JobTypeStatus_Id=JOB.Job_Status_Id  
		LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item 		
	WHERE ORE.Active = ".'"1"'." AND JOB.Job_Status_Id = ".'"3"'." AND OREI.Active = ".'"1"'." group by ORE.ORDER_ID"));
	return Response::json(array('response' => $closed_order_list));
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function storeOrder(){
		//Insert New Jobs Details in Jobs Table
		$id = Input::json('channel_name');
		$channel_name_tbl = $this->getChannelName($id);
		$jobs_dtl = new Jobs;
		$jobs_dtl->Channel_Id = Input::json('channel_name');
		$jobs_dtl->Job_Type_Id = "1";
		$jobs_dtl->Job_Status_Id = "1";
		$jobs_dtl->ACTIVE = 1;
		$jobs_dtl->CREATE_TS = date("Y-m-d H:i:s");
		$jobs_dtl->MODIFY_TS = date("Y-m-d H:i:s");
		$jobs_dtl->save();
		
		// Insert New order Details in Order Table		
		$order_dtl = new Order;
		$order_dtl->Job_Id = $jobs_dtl->Job_Id;
		$order_dtl->ORDER_DATE =  Input::json('orderdate');
		$order_dtl->ChannelName = $channel_name_tbl;
		$order_dtl->Requested_Ship_Date = Input::json('shipmentdate');
		$order_dtl->ShipName =  Input::json('shipname');
		$order_dtl->ShipAddress1 =  Input::json('shippingaddress');
		$order_dtl->ShipAddress2 =  Input::json('shippingaddress2');
		$order_dtl->ShipCompany =  Input::json('shipcompany');
		$order_dtl->ShipCity =  Input::json('shipcity');
		$order_dtl->ShipZip =  Input::json('shipzip');
		$order_dtl->ShipState =  Input::json('shipstate');
		$order_dtl->ShipCountry =  Input::json('shipcountry');
		$order_dtl->ShipEmail =  Input::json('shipemail');
		$order_dtl->BillName =  Input::json('billname');
		$order_dtl->BillAddress1 =  Input::json('billaddress');
		$order_dtl->BillAddress2 =  Input::json('billaddress2');
		$order_dtl->BillCompany =  Input::json('billcompany');
		$order_dtl->BillCity =  Input::json('billcity');
		$order_dtl->BillZip =  Input::json('billzip');
		$order_dtl->BillState =  Input::json('billstate');
		$order_dtl->BillCountry =  Input::json('billcountry');
		$order_dtl->BillEmail =  Input::json('billemail');
		$order_dtl->BillPhone =  Input::json('billphone');
		$order_dtl->RefOrderId =  Input::json('ref_order_id');
		$order_dtl->OrderTotal =  Input::json('ordertotal');
		$order_dtl->TotalShipmentPrice =  Input::json('total_shipment_price');
		$order_dtl->ShipmentsTotalCost =  "1";
		$order_dtl->CarrierName = Input::json('carrier_name');
		$order_dtl->CarrierServiceName = Input::json('carrier_service_name');
		$order_dtl->Comments =  Input::json('comments');
		$order_dtl->ACTIVE = 1;
		$order_dtl->CREATE_TS = date("Y-m-d H:i:s");
		$order_dtl->MODIFY_TS = date("Y-m-d H:i:s");
		$order_dtl->save();
		
		$order_item_count =Input::json('item_count');	
		$deleted_item_array = array();
		$deleted_item_array = Input::json('deleted_item_list');		
		for($i=1; $i<=$order_item_count; $i++){
			if (!(in_array($i, $deleted_item_array))) {	
				if(isset(Input::json('order_item')['order_item'.$i])){
					$prod_list = $this->getProductDetailsByProductId(Input::json('order_item')['order_item'.$i]);
					if(count($prod_list)>0){
						$order_item_dtl = new Orderitems;
						$order_item_dtl->Order_Id = $order_dtl->Order_Id;
						$order_item_dtl->Order_Item = Input::json('order_item')['order_item'.$i];
						$order_item_dtl->ItemName = $prod_list[0]->Product_Name;
						$order_item_dtl->ItemDescription = $prod_list[0]->Product_Description;
						$order_item_dtl->SKU = $prod_list[0]->SKU;
						$order_item_dtl->UnitWeight = $prod_list[0]->UnitWeight;
						$order_item_dtl->ItemPrice = $prod_list[0]->Price;
						$order_item_dtl->ItemRefId = $prod_list[0]->RefItemId;
						$order_item_dtl->Order_Qty = Input::json('order_qty')['order_qty'.$i];
						$order_item_dtl->Balance_Qty = Input::json('order_qty')['order_qty'.$i];
						$order_item_dtl->ACTIVE = 1;
						$order_item_dtl->CREATE_TS = date("Y-m-d H:i:s");
						$order_item_dtl->MODIFY_TS = date("Y-m-d H:i:s");				
						$order_item_dtl->save();					
					}
				}else{ 
				$order_item_dtl = new Orderitems;
				$order_item_dtl->Order_Id = $order_dtl->Order_Id;
				$order_item_dtl->Order_Item = "0";
				$order_item_dtl->ItemName = Input::json('new_order_item')['new_order_item'.$i];
				$order_item_dtl->ItemDescription = Input::json('item_des')['item_des'.$i];
				$order_item_dtl->SKU = Input::json('sku')['sku'.$i];
				$order_item_dtl->UnitWeight = Input::json('u_weight')['u_weight'.$i];
				$order_item_dtl->ItemPrice = Input::json('price')['price'.$i];
				$order_item_dtl->ItemRefId = Input::json('item_ref_no')['item_ref_no'.$i];
				$order_item_dtl->Order_Qty = Input::json('order_qty')['order_qty'.$i];
				$order_item_dtl->Balance_Qty = Input::json('order_qty')['order_qty'.$i];
				$order_item_dtl->ACTIVE = 1;
				$order_item_dtl->CREATE_TS = date("Y-m-d H:i:s");
				$order_item_dtl->MODIFY_TS = date("Y-m-d H:i:s");				
				$order_item_dtl->save();					
				}			
			}			
		}	
		return Response::json(array('flash' => 'Save Successfully!!!'));
	}
		
	public function updateStockCountInventoryItems($balance_qty, $inv_id){
		$update_order_item_details = DB::select(DB::raw('UPDATE InventoryItems SET Stock_Count="'.$balance_qty.'" WHERE InventoryItem_Id = '.$inv_id )); 			
	}
	
	/************************************************************************
	 * 		Function  		: bulkImportOrder								*
	 * 		Use				: Store a Bulk Import Orders					*
	 * 		Author 			: Mohanraj.S									*	
	 * 		Created Date 	: 12-JUN-2015									*
	 ************************************************************************/
	 
	public function bulkImportOrder(){


		DB::transaction(function()
		{
		$orderdetails_count = count(Input::json('orderdetails'));
		$orderDetails = Input::json('orderdetails');
		$skip_count = 0;
		for($i = 0; $i < $orderdetails_count; $i++) {
			if (Order::where('RefOrderId', '=', $orderDetails[$i]['Order_ID'])->count() > 0) {
				$skip_count++;
			} else {
				//Insert New Jobs Details in Jobs Table
				$jobs_dtl = new Jobs;
				$jobs_dtl->Channel_Id = $orderDetails[$i]['Channel_Id'];
				$jobs_dtl->Job_Type_Id = "1";
				$jobs_dtl->Job_Status_Id = "1";
				$jobs_dtl->ACTIVE = 1;
				$jobs_dtl->CREATE_TS = date("Y-m-d H:i:s");
				$jobs_dtl->MODIFY_TS = date("Y-m-d H:i:s");
				$jobs_dtl->save();

				//return Response::json($jobs_dtl);

				// Insert New order Details in Order Table
				$order_dtl = new Order;
				$order_dtl->Job_Id = $jobs_dtl->id;
				$order_dtl->Order_Date = date("Y-m-d", strtotime($orderDetails[$i]['Order_Date']));   //$orderDetails[$i]['Order_Date'];
				$order_dtl->ChannelName = $orderDetails[$i]['Channel_Name'];
				$order_dtl->OrderStatus = $orderDetails[$i]['Order_Status'];
				$order_dtl->SubTotal = $orderDetails[$i]['SubTotal'];
				$order_dtl->Tax = $orderDetails[$i]['Tax'];
				$order_dtl->TaxRate = $orderDetails[$i]['Tax_Rate'];
				$order_dtl->ShipRate = $orderDetails[$i]['Ship_Rate'];
				$order_dtl->FinalTotal = $orderDetails[$i]['Final_Total'];
				$order_dtl->ShipMethod = $orderDetails[$i]['Ship_Method'];
				//$order_dtl->Requested_Ship_Date =  "";
				$order_dtl->ShipName = $orderDetails[$i]['Ship_FirstName'] . ' ' . $orderDetails[$i]['Ship_LastName'];
				$order_dtl->ShipAddress1 = $orderDetails[$i]['Ship_Address1'];
				$order_dtl->ShipAddress2 = $orderDetails[$i]['Ship_Address2'];
				$order_dtl->ShipCompany = $orderDetails[$i]['Ship_Company'];
				$order_dtl->ShipCity = $orderDetails[$i]['Ship_City'];
				$order_dtl->ShipZip = $orderDetails[$i]['Ship_PostalCode'];
				$order_dtl->ShipState = $orderDetails[$i]['Ship_StateProvince'];
				$order_dtl->ShipCountry = $orderDetails[$i]['Ship_Country'];
				$order_dtl->ShipEmail = $orderDetails[$i]['Bill_Email'];
				$order_dtl->BillName = $orderDetails[$i]['Bill_FirstName'] . ' ' . $orderDetails[$i]['Bill_LastName'];
				$order_dtl->BillAddress1 = $orderDetails[$i]['Bill_Address1'];
				$order_dtl->BillAddress2 = $orderDetails[$i]['Bill_Address2'];
				$order_dtl->BillCompany = $orderDetails[$i]['Bill_Company'];
				$order_dtl->BillCity = $orderDetails[$i]['Bill_City'];
				$order_dtl->BillZip = $orderDetails[$i]['Bill_PostalCode'];
				$order_dtl->BillState = $orderDetails[$i]['Bill_StateProvince'];
				$order_dtl->BillCountry = $orderDetails[$i]['Bill_Country'];
				$order_dtl->BillEmail = $orderDetails[$i]['Bill_Email'];
				$order_dtl->BillPhone = $orderDetails[$i]['Bill_Phone_Number'];
				$order_dtl->RefOrderId = $orderDetails[$i]['Order_ID'];
				//$order_dtl->OrderTotal 			=  "";
				$order_dtl->TotalShipmentPrice = $orderDetails[$i]['Ship_Rate'];
				//$order_dtl->ShipmentsTotalCost 	=  "";
				//$order_dtl->CarrierName 		=  "";
				//$order_dtl->CarrierServiceName 	=  "";
				//$order_dtl->Comments 			=  "";
				$order_dtl->ACTIVE = 1;
				$order_dtl->CREATE_TS = date("Y-m-d H:i:s");
				$order_dtl->MODIFY_TS = date("Y-m-d H:i:s");
				$order_dtl->save();

				//return Response::json($order_dtl);

				// Order Item Table
				$order_item_dtl = new Orderitems;
				$order_item_dtl->Order_Id = $order_dtl->id;
				$order_item_dtl->Order_Item = 0;
				$order_item_dtl->ItemName = $orderDetails[$i]['Product_Name'];
				$order_item_dtl->ItemDescription = $orderDetails[$i]['Product_Customizations_Description'];
				//$order_item_dtl->SKU 				= "";
				//$order_item_dtl->UnitWeight 		= "";
				$order_item_dtl->ItemPrice = $orderDetails[$i]['Product_Paid'];
				$order_item_dtl->ItemRefId = $orderDetails[$i]['Order_ID'];
				$order_item_dtl->Order_Qty = $orderDetails[$i]['Product_Quantity'];
				$order_item_dtl->Balance_Qty = $orderDetails[$i]['Product_Quantity'];
				$order_item_dtl->ProductName = $orderDetails[$i]['Product_Name'];
				$order_item_dtl->ProductPartNumber = $orderDetails[$i]['Product_Part_Number'];
				$order_item_dtl->ProductPaid = $orderDetails[$i]['Product_Paid'];
				$order_item_dtl->ProductQuantity = $orderDetails[$i]['Product_Quantity'];
				$order_item_dtl->ProductCustomizationDescription = $orderDetails[$i]['Product_Customizations_Description'];
				$order_item_dtl->ACTIVE = 1;
				$order_item_dtl->CREATE_TS = date("Y-m-d H:i:s");
				$order_item_dtl->MODIFY_TS = date("Y-m-d H:i:s");
				$order_item_dtl->save();

				$orderItems_count = count(Input::json('orderdetails')[$i]['Items']);
				$itemDetails = Input::json('orderdetails')[$i]['Items'];

				if ($orderItems_count > 0) {
					for ($j = 0; $j < $orderItems_count; $j++) {
						// Order Item Table
						$order_item_dtl = new Orderitems;
						$order_item_dtl->Order_Id = $order_dtl->id;
						$order_item_dtl->Order_Item = 0;
						$order_item_dtl->ItemName = $itemDetails[$j]['Product_Name'];
						$order_item_dtl->ItemDescription = $itemDetails[$j]['Product_Customizations_Description'];
						//$order_item_dtl->SKU 				= "";
						//$order_item_dtl->UnitWeight 		= "";
						$order_item_dtl->ItemPrice = $itemDetails[$j]['Product_Paid'];
						$order_item_dtl->ItemRefId = $itemDetails[$j]['Order_ID'];
						$order_item_dtl->Order_Qty = $itemDetails[$j]['Product_Quantity'];
						$order_item_dtl->Balance_Qty = $itemDetails[$j]['Product_Quantity'];
						$order_item_dtl->ProductName = $itemDetails[$j]['Product_Name'];
						$order_item_dtl->ProductPartNumber = $itemDetails[$j]['Product_Part_Number'];
						$order_item_dtl->ProductPaid = $itemDetails[$j]['Product_Paid'];
						$order_item_dtl->ProductQuantity = $itemDetails[$j]['Product_Quantity'];
						$order_item_dtl->ProductCustomizationDescription = $itemDetails[$j]['Product_Customizations_Description'];
						$order_item_dtl->ACTIVE = 1;
						$order_item_dtl->CREATE_TS = date("Y-m-d H:i:s");
						$order_item_dtl->MODIFY_TS = date("Y-m-d H:i:s");
						$order_item_dtl->save();
					}
				}
				//return Response::json($order_item_dtl);
			}
		}

		return Response::json(array('flash' => $orderdetails_count .' Bulk Orders Processed Successfully, '.$skip_count.' Orders already in system'))->setCallback(Input::get('callback'));
		});
	}

	/*
	*	Get Channel and Id form Channel Table
	*
	**/
	public function getChannelx(){
		$channel_list = DB::table('channels')->get();
		return Response::json(array('response' => $channel_list));
	}

	public function getChannel()
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

	/*
	*	Get Product details form Product Table
	*
	**/
	
	public function getProductDetailsByProductId($id){
		$product_id = $id; 
		if (is_numeric($product_id)){
		$product_id_list = DB::select(DB::raw("SELECT Product_Name,Product_Description,Price,RefItemId,SKU,UnitWeight
                                                 		FROM products WHERE Product_Id =".$product_id));
		return $product_id_list;
		}
		else{
		return null;
		}		
	}	
	
	/*
	*	Get Channel Name form Channel Table
	*
	**/	
	public function getChannelName($id){
		$channel_id = $id; 
		$channel__name_dat = DB::select(DB::raw("SELECT Channel_Name FROM channels WHERE Channel_Id =".$channel_id));
		$ch_name =  $channel__name_dat[0]->Channel_Name;
		return $ch_name;
	}	
	/*
	*	Get Product and Id form Product Table
	*
	**/
	public function getProduct(){
		$product_list = DB::select(DB::raw("SELECT `products`.`Product_Id`,
						CONCAT( `products`.`RefItemId`,' - ',`products`.`Product_Name`,' - ',`products`.`SKU`) as Product_Name,
						`products`.`Product_Description`,
						`products`.`Price`,
						`products`.`Image_URL`,
						`products`.`Catelog_Id`,
						`products`.`Channel_Id`,
						`products`.`RefItemId`,
						`products`.`SKU`,
						`products`.`UnitWeight`,
						`products`.`Active`,
						`products`.`Create_ts`,
						`products`.`Modify_ts` FROM Products WHERE Channel_Id =".$Channel_Id AND "Warehouse_Id =".$Warehouse_Id));
		return Response::json(array('response' => $product_list));
	}
  
    public function getWarehouseName($id){
		// Query To Fetch Ware Details
		$Warehouse_Id = $id; 
		$warehouse__name_dat = DB::select(DB::raw("SELECT Warehouse_Name FROM Warehouses WHERE Warehouse_Id =".$Warehouse_Id));
		$warehouse_name =  $warehouse__name_dat[0]->Warehouse_Name	;
		return $warehouse_name;
	}	
		
	public function getEditOrderDetails(){
		$order_list = DB::select(DB::raw("SELECT ORE.Requested_Ship_Date,ORE.ORDER_ID,
			ORE.CarrierName,ORE.CarrierServiceName,OREI.Order_Item_Id, OREI.Active, ORE.Job_Id, 
			ORE.Order_Date,ORE.ShipName,ORE.ShipAddress1,ORE.ShipAddress2,
			ORE.ShipCompany,ORE.ShipCity,ORE.ShipZip,ORE.ShipState,ORE.ShipCountry,
			ORE.ShipEmail,ORE.BillName,ORE.BillAddress1,ORE.BillAddress2,ORE.BillCompany,ORE.BillCity,
			ORE.BillZip,ORE.BillState,ORE.BillCountry,ORE.BillEmail, ORE.BillPhone,ORE.RefOrderId,
			ORE.OrderTotal,ORE.TotalShipmentPrice,ORE.CarrierName,ORE.CarrierServiceName,
			ORE.Comments,ORE.ShipmentsTotalCost,ORE.Create_ts,ORE.MODIFY_TS,
			OREI.Order_Qty, OREI.Balance_Qty,OREI.Order_Item,OREI.ItemName,
			PRO.Product_Name,job.Channel_Id,
			OREI.ItemDescription,OREI.SKU,OREI.UnitWeight,OREI.ItemPrice,OREI.ItemRefId, 
			JOB.Job_Status_Id, JTS.Status_Name,
			CHE.Channel_Name FROM orders AS ORE 
			LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id 
			LEFT JOIN Jobs AS job ON job.Job_Id=ORE.Job_Id 
			LEFT JOIN jobtypestatus AS JTS ON JTS.JobTypeStatus_Id=JOB.Job_Status_Id 
			LEFT JOIN products AS PRO ON PRO.Product_Id=OREI.Order_Item 
			LEFT JOIN channels AS CHE ON CHE.Channel_Id=JOB.Channel_Id 
		WHERE OREI.Active = ".'"1"'." AND ORE.Order_Id = ". Input::json('id'))); 
			
		$tot_shipment_list = DB::select(DB::raw("SELECT ore.Order_Id,ore.Order_Date,jstatus.Status_Name, 
			ore.Order_Id,ship.Shipment_Id, job.Job_Type_Id, job.Job_Status_Id,SUM(ShipmentCost) AS shipmentTotalCost FROM `Shipments` as ship 
				LEFT JOIN Jobs AS job ON job.Job_Id=ship.Job_Id
				LEFT JOIN Orders AS ore ON ore.Job_Id = job.Parent_Job_Id 
				INNER JOIN JobTypeStatus AS jstatus ON jstatus.JobTypeStatus_Id=job.Job_Status_Id 				
				WHERE job. Job_Type_Id=".'"4"'." AND job.Job_Status_Id=".'"4"'." AND job.Active=".'"1"'." AND ore.Order_Id=".Input::json('id'))); 
		
		$channel_list = DB::table('channels')->get();
		$product_list = DB::table('products')->get(); 
		$carrier_list = DB::table('Carrier')->get();
		$carrier_service_list = DB::table('CarrierServices')->get();
		$order_product = DB::select(DB::raw("SELECT pro.Product_Id,pro.Product_Name FROM Products as pro
			LEFT JOIN InventoryItems AS it ON it.Product_Id = pro.Product_Id 
			LEFT JOIN Jobs AS j ON j.Channel_Id = it.Channel_Id 
			LEFT JOIN Orders AS ord ON ord.Job_Id = j.Job_Id
			WHERE ord.Order_Id=".Input::json('id')));
		return Response::json(array('order_product'=>$order_product,'response' => $order_list,'totalShipmentCost'=>$tot_shipment_list, 'channel' => $channel_list, 'product' => $product_list,'carriername' =>$carrier_list,'carrierservice'=>$carrier_service_list));
	}

	public function editOrderDetails(){						
		$MODIFY_TS = date("Y-m-d H:i:s");		
		$update_job_details = DB::select(DB::raw('update jobs set `Channel_Id` ='. Input::json('channel_name'). ',`Job_Status_Id` = '. Input::json('status_id'). '  where Job_Id = ' . Input::json('jobid'))); 
		$update_order_details = DB::select(DB::raw('update orders set `Order_Date` = ' . "'". Input::json('orderdate'). "'".',
			`Requested_Ship_Date` = ' . "'". Input::json('shipment_date'). "'".',
			`ShipAddress1` ='. "'" . Input::json('shippingaddress')."'" .',
			`ShipAddress2` ='. "'" . Input::json('shippingaddress2')."'" .', 
			`ShipName` ='. "'" . Input::json('shipname')."'" .', 
			`ShipCompany` ='. "'" . Input::json('shipcompany')."'" .', 
			`ShipCity` ='. "'" . Input::json('shipcity')."'" .',
			`ShipZip` ='. "'" . Input::json('shipzip')."'" .',
			`ShipState` ='. "'" . Input::json('shipstate')."'" .',
			`ShipCountry` ='. "'" . Input::json('shipcountry')."'" .',
			`ShipEmail` ='. "'" . Input::json('shipemail')."'" .',
			`BillName` ='. "'" . Input::json('billname')."'" .', 
			`BillAddress1` ='. "'" . Input::json('billaddress')."'" .',
			`BillAddress2` ='. "'" . Input::json('billaddress2')."'" .',
			`BillCompany` ='. "'" . Input::json('billcompany')."'" .',
			`BillCity` ='. "'" . Input::json('billcity')."'" .',
			`BillZip` ='. "'" . Input::json('billzip')."'" .',
			`BillState` ='. "'" . Input::json('billstate')."'" .',
			`BillCountry` ='. "'" . Input::json('billcountry')."'" .',
			`BillEmail` ='. "'" . Input::json('billemail')."'" .',
			`BillPhone` ='. "'" . Input::json('billphone')."'" .', 
			`RefOrderId` ='. "'" . Input::json('ref_order_id')."'" .', 
			`OrderTotal` ='. "'" . Input::json('ordertotal')."'" .',
			`TotalShipmentPrice` ='. "'" . Input::json('total_shipment_price') ."'" .',
			`ShipmentsTotalCost` ='. "'" . Input::json('tot_ship_cost') ."'" .',
			`CarrierName` ='. "'" . Input::json('carrier_name')."'" .',
			`CarrierServiceName` ='. "'" . Input::json('carrier_service_name')."'" .',
			`MODIFY_TS` =  "'.$MODIFY_TS.'",
			`Comments` ='. "'" . Input::json('comments')."'" .' 
		WHERE Order_Id = ' . Input::json('orderid'))); 				
		
		$order_item_count = Input::json('item_count');
		//$order_item_count="2";
		$deleted_item_array = array();
		$deleted_item_array = Input::json('deleted_item_list');		
			for($i=1; $i<=$order_item_count; $i++){
				if (!(in_array($i, $deleted_item_array))) {		
					if(isset(Input::json('order_item')['order_item'.$i])){				
						if(isset(Input::json('order_item_id')['order_item_id'.$i])){					
							$update_order_itm_details = DB::select(DB::raw('UPDATE Orderitems SET `Order_Qty` ='. Input::json('order_qty')['order_qty'.$i]. ', 
								`ItemDescription` ='."'" . Input::json('item_des')['item_des'.$i]."'".',
								`ItemRefId` ='. Input::json('item_ref_no')['item_ref_no'.$i]. ',
								`SKU` ='. Input::json('sku')['sku'.$i]. ',
								`UnitWeight` ='."'" . Input::json('u_weight')['u_weight'.$i]."'". ',
								`ItemPrice` ='. Input::json('price')['price'.$i]. ',
								`Balance_Qty` ='. Input::json('order_qty')['order_qty'.$i]. '								
							WHERE Order_Item_Id = ' . Input::json('order_item_id')['order_item_id'.$i])); 
						}else{	
							$prod_list = $this->getProductDetailsByProductId(Input::json('order_item')['order_item'.$i]);
							if(count($prod_list)>0){
								$order_item_dtl = new Orderitems;				
								$order_item_dtl->Order_Id = Input::json('orderid');
								$order_item_dtl->Order_Item = Input::json('order_item')['order_item'.$i];
								$order_item_dtl->ItemName = $prod_list[0]->Product_Name;
								$order_item_dtl->ItemDescription = $prod_list[0]->Product_Description;
								$order_item_dtl->SKU = $prod_list[0]->SKU;
								$order_item_dtl->UnitWeight = $prod_list[0]->UnitWeight;
								$order_item_dtl->ItemPrice = $prod_list[0]->Price;
								$order_item_dtl->ItemRefId = $prod_list[0]->RefItemId;
								$order_item_dtl->Order_Qty = Input::json('order_qty')['order_qty'.$i];
								$order_item_dtl->Balance_Qty = Input::json('order_qty')['order_qty'.$i];
								$order_item_dtl->ACTIVE = 1;
								$order_item_dtl->CREATE_TS = date("Y-m-d H:i:s");
								$order_item_dtl->MODIFY_TS = date("Y-m-d H:i:s");
								$order_item_dtl->save();					
							}
							if(count($prod_list) ==0){
								$order_item_dtl = new Orderitems;
								$order_item_dtl->Order_Id = Input::json('orderid');
								$order_item_dtl->Order_Item = "0";
								$order_item_dtl->ItemName = Input::json('order_item')['order_item'.$i];
								$order_item_dtl->ItemDescription = Input::json('item_des')['item_des'.$i];
								$order_item_dtl->SKU = Input::json('sku')['sku'.$i];
								$order_item_dtl->UnitWeight = Input::json('u_weight')['u_weight'.$i];
								$order_item_dtl->ItemPrice = Input::json('price')['price'.$i];
								$order_item_dtl->ItemRefId = Input::json('item_ref_no')['item_ref_no'.$i];
								$order_item_dtl->Order_Qty = Input::json('order_qty')['order_qty'.$i];
								$order_item_dtl->Balance_Qty = Input::json('order_qty')['order_qty'.$i]; 
								$order_item_dtl->ACTIVE = 1;
								$order_item_dtl->CREATE_TS = date("Y-m-d H:i:s");
								$order_item_dtl->MODIFY_TS = date("Y-m-d H:i:s");				
								$order_item_dtl->save();						
							}
						}  
					}		
				} 	
			}
		return Response::json(array('response' => "Succesfully Updated!!!"));
	}

	public function updateOrderStatus(){
		$update_job_details = DB::select(DB::raw('UPDATE jobs SET `Channel_Id` ='. Input::json('channel_id'). ',`Job_Status_Id` = '. Input::json('status_id'). ' 
									WHERE Job_Id = ' . Input::json('jobid'))); 
	}

	/*
	*Delete Order Details
	*/	
	public function deleteOrderDetails(){
		$delete_order_details = DB::select(DB::raw('UPDATE orders SET `ACTIVE` = "0" WHERE Order_Id = ' . Input::json('id'))); 
		return Response::json(array('response' => "Record Deleted Successfully!!"));
	}
	
	public function getOrderListCount(){
		$requested_ch_right ="AllowOrderView";
		$usergroup = User::find(Auth::id())->usergroup()->first();
		$order_list = DB::select(DB::raw("SELECT ORE.Requested_Ship_Date,ORE.ORDER_ID,job.Job_Id,job.Channel_id,
			JTS.JobTypeStatus_Id,JTS.Status_Name,ORE.Order_Date,ORE.ChannelName,ORE.ShipName,
			ORE.ShipAddress1,ORE.ShipAddress2,ORE.ShipCompany,ORE.ShipCity,ORE.ShipZip,ORE.ShipState,
			ORE.ShipCountry,ORE.ShipEmail,ORE.BillName,ORE.BillAddress1,ORE.BillAddress2,
			ORE.BillCompany,ORE.BillCity,ORE.BillZip,ORE.BillState,ORE.BillCountry,ORE.BillEmail,
			ORE.BillPhone,ORE.RefOrderId,ORE.OrderTotal,ORE.TotalShipmentPrice,ORE.CarrierName,
			ORE.CarrierServiceName,ORE.Comments,OREI.Order_Qty,OREI.Active,ORE.Create_ts,ORE.Modify_ts,
			OREI.Order_Item,PRO.Product_Name,pro.Price,OREI.ItemDescription,OREI.SKU,OREI.UnitWeight,
			OREI.ItemPrice,OREI.ItemRefId FROM `orders` AS ORE
			LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id
			LEFT JOIN Jobs AS job ON job.Job_Id=ORE.Job_Id
			LEFT JOIN jobtypestatus AS JTS ON JTS.JobTypeStatus_Id=JOB.Job_Status_Id
			LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item
			WHERE ORE.Active = ".'"1"'." AND OREI.Active = ".'"1"'." GROUP BY ORE.ORDER_ID
			HAVING job.Channel_id in(select ugchr.Channel_id
										from Usergroupchannelrights ugchr, channelsrights chr
										  where ugchr.UserGroup_Id = ".$usergroup->UserGroup_Id."
				 								and chr.Channel_Right_Name = '".$requested_ch_right."')"));
		$new_order_list = DB::select(DB::raw("SELECT ORE.ORDER_ID,ORE.Order_Date,ORE.Job_Id,JOB.Job_Status_Id,OREI.Order_Qty,OREI.Order_Item,OREI.Active,PRO.Product_Name,pro.Price FROM `orders` AS ORE LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item LEFT JOIN jobs AS JOB ON JOB.Job_Id = ORE.Job_Id where ORE.Active = ".'"1"'." and JOB.Job_Status_Id = ".'"1"'." and OREI.Active = ".'"1"'." group by ORE.ORDER_ID")); 
		$inprogress_order_list = DB::select(DB::raw("SELECT ORE.ORDER_ID,ORE.Order_Date,ORE.Job_Id,JOB.Job_Status_Id,OREI.Order_Qty,OREI.Order_Item,OREI.Active,PRO.Product_Name,pro.Price FROM `orders` AS ORE LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item LEFT JOIN jobs AS JOB ON JOB.Job_Id = ORE.Job_Id where ORE.Active = ".'"1"'." and JOB.Job_Status_Id = ".'"2"'." and OREI.Active = ".'"1"'." group by ORE.ORDER_ID")); 
		$closed_order_list = DB::select(DB::raw("SELECT ORE.ORDER_ID,ORE.Order_Date,ORE.Job_Id,JOB.Job_Status_Id,OREI.Order_Qty,OREI.Order_Item,OREI.Active,PRO.Product_Name,pro.Price FROM `orders` AS ORE LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item LEFT JOIN jobs AS JOB ON JOB.Job_Id = ORE.Job_Id where ORE.Active = ".'"1"'." and JOB.Job_Status_Id = ".'"3"'." and OREI.Active = ".'"1"'." group by ORE.ORDER_ID"));
		return Response::json(array('all_order_list' =>$order_list, 'new_order_count' => $new_order_list, 'inprogress_order_count' => $inprogress_order_list, 'closed_order_count' => $closed_order_list));
	}
	
	public function getPackingDetails(){
		$order_job_id = DB::select(DB::raw("SELECT job_id FROM orders WHERE Order_Id = ". Input::json('id') )); 
		$packing_order_job_id = DB::select(DB::raw("SELECT job_id FROM jobs WHERE job_type_id = '3' and parent_job_id = ". $order_job_id[0]->job_id )); 
		if($packing_order_job_id){
			$packing_order_details = DB::select(DB::raw("SELECT PACK.Packing_Slip_Id,PACK.Packing_Slip_Date, PACK.Additional_Notes, PACK.Active, 
				PACKIT.Packing_Slip_Item_Id, PACKIT.Packing_Slip_Item, PACKIT.Packing_Slip_Qty, PRO.Product_Name FROM packingslips AS PACK 
				LEFT JOIN packingslipitems AS PACKIT ON PACK.Packing_Slip_Id = PACKIT.Packing_Slip_Id
				LEFT JOIN products AS PRO ON PRO.Product_Id = PACKIT.Packing_Slip_Item 
				WHERE PACK.job_id = ". $packing_order_job_id[0]->job_id )); 
			return Response::json(array('packing_oder_details' =>$packing_order_details));
		}else{
			return Response::json(array('no_packing' =>"No Packing For This Order"));
		}
	}	
	
	public function getShipementDetails(){
		$order_job_id = DB::select(DB::raw("SELECT job_id FROM orders WHERE Order_Id = ". Input::json('id') )); 
		$shipment_order_job_id = DB::select(DB::raw("SELECT job_id FROM jobs WHERE job_type_id = '4' AND parent_job_id = ". $order_job_id[0]->job_id )); 
		$shipment_order_job_id_array = array();
		$shipment_count = count($shipment_order_job_id);
		if($shipment_order_job_id){			
			$shipment_oder_details = DB::select(DB::raw("SELECT Shipment_Id, Date_Of_Shipment, ShipmentCost FROM shipments WHERE Active = '1' AND Job_Id in (select job_id from jobs where job_type_id = '4' AND parent_job_id =".$order_job_id[0]->job_id .")"));
			return Response::json(array('shipment_oder_details' =>$shipment_oder_details));
		}else{
			return Response::json(array('no_packing' =>"No Shipment For This Order"));
		}
	}
	
	/*
	*Query To Fetch Carrier from Carrier table
	*
	*/
	public function getCarrierDetails(){		
		$carrier_list = DB::table('Carrier')->get();
		return Response::json(array('carriername' => $carrier_list));
	}
	
	// Query To Fetch CarrierServiceDetails from CarrierServices table
	
	public function getCarrierServiceDetails(){
		$carrier_service_list = DB::table('CarrierServices')->get();
		return Response::json(array('carrierservicename' => $carrier_service_list));
	}

	public function allowOrderAdd()
	{
		return $this->allowChannelRight("AllowOrderAdd");
	}

	public function allowOrderBulkAdd()
	{
		return $this->allowChannelRight("AllowOrderBulkAdd");
	}

	public function allowChannelRight($channel_right_name)
	{
		$requested_ch_right = $channel_right_name;
		$usergroup = User::find(Auth::id())->usergroup()->first();

		//select form usergroup channel rights where the channel_id and usergroup_id and ch_right
		$Right_list = DB::select(DB::raw(
			"SELECT ugchr.* FROM usergroupchannelrights ugchr, channelsrights chr
				WHERE  ugchr.UserGroup_Id = ".$usergroup->UserGroup_Id."
					and ugchr.Channel_Right_Id =  chr.ChannelRight_Id
					and chr.Channel_Right_Name = '".$requested_ch_right."'"));

		return Response::json(count($Right_list) >0);
	}

	public function allowedOrderStatuses()
	{
		$order_id = Input::json('id');
		$usergroup = User::find(Auth::id())->usergroup()->first();
		$job_id =Order::find($order_id)->Job_Id;
		$job = Jobs::find($job_id);
		$channel_id = $job->Channel_Id;
		$job_status_id = $job->Job_Status_Id;

		//select form usergroup channel rights where the channel_id and usergroup_id and ch_right
		$status_list = DB::select(DB::raw(
			"SELECT jts.* FROM jobtypestatus jts
				WHERE  jts.JobTypeStatus_Id =   ".$job_status_id."
					or   jts.JobTypeStatus_Id in
						(Select jtst.To_JobTypeStatus_Id
							From  jobtypestatustransitions jtst
							where jtst.From_JobTypeStatus_Id= '".$job_status_id."')"));


		return Response::json(array('response' => $status_list));
	}

	public function allowJTS($order_id,$requested_jt_right)
	{

		$usergroup = User::find(Auth::id())->usergroup()->first();
		$job_id =Order::find($order_id)->Job_Id;
		$job = Jobs::find($job_id);
		$channel_id = $job->Channel_Id;
		$job_status_id = $job->Job_Status_Id;

		//select form usergroup channel rights where the channel_id and usergroup_id and ch_right
		$Right_list = DB::select(DB::raw(
			"SELECT ugjtsr.* FROM usergroupsjtsrights ugjtsr, jobtypesrights jtr
				WHERE ugjtsr.Channel_Id = ".$channel_id." and ugjtsr.UserGroup_Id = ".$usergroup->UserGroup_Id."
					and ugjtsr.Job_Type_Status_Id = ".$job_status_id."
					and ugjtsr.Job_Type_Right_Id =  jtr.JobType_Id
					and jtr.Job_Type_Right_Name = '".$requested_jt_right."'"));

		return Response::json(count($Right_list) >0);
	}

	public function allowOrderEditDelete()
	{
		$order_id = Input::json('id');
		$requested_jt_right ="AllowOrderEditDelete";
		return $this->allowJTS($order_id,$requested_jt_right);
	}

	public function allowOrderShipAdd()
	{
		$order_id = Input::json('id');
		$requested_jt_right ="AllowOrderShipAdd";
		return $this->allowJTS($order_id,$requested_jt_right);
	}

	public function allowOrderStatusChange()
	{
		$order_id = Input::json('id');
		$requested_jt_right ="AllowOrderStatusChange";
		return $this->allowJTS($order_id,$requested_jt_right);
	}

}
