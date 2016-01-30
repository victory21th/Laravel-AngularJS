<?php
/**	
*	File Name 			: 	ShipmentBoxController.php
*	File Description	:	To packing Details 
*	Created Date 		:	13- DEC - 2015
*	Modified Date 		:	02- June - 2015
*	Company				:	iExemplar
*	Created By			:	Thilakkumar K S
*	Contributors		:	Thilakkumar K S, Manthiriyappan.A
**/
class ShipmentBoxController extends BaseController {	
   	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
		public function createShipmentBox()	{
			$shb_dtl = new Shipmentsboxes;
			$shb_dtl->Shipment_Id = Input::json('shipmentid');
			$shb_dtl->BoxName =  Input::json('boxname');
			$shb_dtl->BoxLength = Input::json('boxlength');
			$shb_dtl->BoxWidth =  Input::json('boxwidth');
			$shb_dtl->BoxHeight =  Input::json('boxheight');
			$shb_dtl->ACTIVE = 1;
			$shb_dtl->CREATE_TS = date("Y-m-d H:i:s");
			$shb_dtl->MODIFY_TS = date("Y-m-d H:i:s");
			$shb_dtl->save();
							
			$itembox_id  = Input::json('item_id');
			$itembox_qty = Input::json('box_qty');
			for($i=0; $i < count($itembox_id); $i++){			
				$itm_id =  $itembox_id[$i];	
				$shipment_qty = $itembox_qty[$itm_id];			
				$inventory_id =  $this->getInventoryIDByShipmentItemId($itm_id);
				$inv_id = $inventory_id[0]->InventoryItem_Id;
				$current_stock = $inventory_id[0]->Stock_Count;	 
				$prod_list = $this->getProductDetailsByProductId($inventory_id[0]->Product_Id);	
					$bal_qty = ($inventory_id[0]->Ship_Balance_Qty) - $shipment_qty;					
					$shb_box_dtl = new Shipmentsboxitems;
					$shb_box_dtl->Shipment_Box_Id = $shb_dtl->id;
					$shb_box_dtl->Shipment_Item_Id = $itm_id; 
					$shb_box_dtl->Item_Name = $prod_list[0]->Product_Name;
					$shb_box_dtl->Price = $prod_list[0]->Price;
					$shb_box_dtl->RefItemId = $prod_list[0]->RefItemId;
					$shb_box_dtl->SKU = $prod_list[0]->SKU;
					$shb_box_dtl->UnitWeight = $prod_list[0]->UnitWeight;
					$shb_box_dtl->Boxed_Qty = $shipment_qty;		
					$shb_box_dtl->CREATE_TS = date("Y-m-d H:i:s");
					$shb_box_dtl->MODIFY_TS = date("Y-m-d H:i:s");
					$shb_box_dtl->save(); 
					$this->updateBalanceQtyShipmentItems($bal_qty, $itm_id);
					$stock_onhand = ($current_stock - $shipment_qty);				
			}	
		}  
		
		public function createDirectShipmentBox(){
			$shb_dtl = new Shipmentsboxes;
			$shb_dtl->Shipment_Id = Input::json('shipmentid');
			$shb_dtl->BoxName =  Input::json('boxname');
			$shb_dtl->BoxLength = Input::json('boxlength');
			$shb_dtl->BoxWidth =  Input::json('boxwidth');
			$shb_dtl->BoxHeight =  Input::json('boxheight');
			$shb_dtl->ACTIVE = 1;
			$shb_dtl->CREATE_TS = date("Y-m-d H:i:s");
			$shb_dtl->MODIFY_TS = date("Y-m-d H:i:s");
			$shb_dtl->save();
				
			$itembox_id  = Input::json('item_id');
			$itembox_qty = Input::json('box_qty');
			for($i=0; $i < count($itembox_id); $i++){
				$itm_id =  $itembox_id[$i];	
				$shipment_qty = $itembox_qty[$itm_id];			
				$inventory_id =  $this->getInventoryIDByShipmentItemId($itm_id);
				$inv_id = $inventory_id[0]->InventoryItem_Id;
				$current_stock = $inventory_id[0]->Stock_Count;	 
				$prod_list = $this->getProductDetailsByProductId($inventory_id[0]->Product_Id);	
					$bal_qty = ($inventory_id[0]->Ship_Balance_Qty) - $shipment_qty;					
					$shb_box_dtl = new Shipmentsboxitems;
					$shb_box_dtl->Shipment_Box_Id = $shb_dtl->id;
					$shb_box_dtl->Shipment_Item_Id = $itm_id; 
					$shb_box_dtl->Item_Name = $prod_list[0]->Product_Name;
					$shb_box_dtl->Price = $prod_list[0]->Price;
					$shb_box_dtl->RefItemId = $prod_list[0]->RefItemId;
					$shb_box_dtl->SKU = $prod_list[0]->SKU;
					$shb_box_dtl->UnitWeight = $prod_list[0]->UnitWeight;
					$shb_box_dtl->Boxed_Qty = $shipment_qty;		
					$shb_box_dtl->CREATE_TS = date("Y-m-d H:i:s");
					$shb_box_dtl->MODIFY_TS = date("Y-m-d H:i:s");
					$shb_box_dtl->save(); 
					$this->updateBalanceQtyShipmentItems($bal_qty, $itm_id);
					$stock_onhand = ($current_stock - $shipment_qty);	 
				}				
		}  
  	   
		public function getShipmentBoxDetailsById(){	  
	    $shipmentbox_list = DB::select(DB::raw("SELECT sbox.*,sboxitem.Shipment_Box_Item_Id,sboxitem.Shipment_Box_Id,
			si.Shipment_Qty,si.Ship_Balance_Qty,si.Shipment_Item_Id,sboxitem.Item_Name,
			sboxitem.Boxed_Qty FROM ShipmentsBoxes AS sbox
			INNER JOIN shipmentsboxitems AS sboxitem ON sboxitem.Shipment_Box_Id=sbox.Shipment_Box_Id 
			LEFT JOIN shipmentitems AS si ON si.Shipment_Item_Id=sboxitem.Shipment_Item_Id 
			WHERE sbox.Shipment_Box_Id=".Input::json('id')));
	    return Response::json(array('response' => $shipmentbox_list));
		}
	  
		public function updateShipmentBoxDetails(){	
			$MODIFY_TS = date("Y-m-d H:i:s");		
			$update_shipment_details = DB::select(DB::raw('UPDATE ShipmentsBoxes SET 
				BoxName ='."'".Input::json('boxname')."'".',
				BoxLength ='. "'" .Input::json('boxlength'). "'" .',
				BoxWidth ='. "'" .Input::json('boxwidth'). "'" .',
				BoxHeight ='. "'" .Input::json('boxheight'). "'" .',
				Modify_ts = "'.$MODIFY_TS.'"
				WHERE Shipment_Box_Id ='.Input::json('shipment_box_id')));
				
			$shipment_item_count = count(Input::json('order_item'));		
			for($i=0; $i < $shipment_item_count; $i++){
				if(Input::json('old_boxed_qty')['old_boxed_qty'.$i] > Input::json('boxed_qty')['boxed_qty'.$i]){
					$new_balance_qty = Input::json('old_boxed_qty')['old_boxed_qty'.$i] - Input::json('boxed_qty')['boxed_qty'.$i];
					$new_balance_qtys = Input::json('shipment_balance_qty')['shipment_balance_qty'.$i] + $new_balance_qty;
					$update_ship_item_details = DB::select(DB::raw('UPDATE shipmentitems SET `Ship_Balance_Qty` ='. $new_balance_qtys .' where Shipment_Item_Id = '.Input::json('shipment_item_id')['shipment_item_id'.$i])); 
					$box_qty = Input::json('boxed_qty')['boxed_qty'.$i];
					$update_ship_box_item_details = DB::select(DB::raw('UPDATE shipmentsboxitems SET `Boxed_Qty` ='. $box_qty .' where Shipment_Box_Item_Id = '.Input::json('shipment_box_item_id')['shipment_box_item_id'.$i])); 
				}else if(Input::json('old_boxed_qty')['old_boxed_qty'.$i] < Input::json('boxed_qty')['boxed_qty'.$i]){
					$new_balance_qty = Input::json('old_boxed_qty')['old_boxed_qty'.$i] - Input::json('boxed_qty')['boxed_qty'.$i];
					$new_balance_qtys = Input::json('shipment_balance_qty')['shipment_balance_qty'.$i] + $new_balance_qty;
					$update_ship_item_details = DB::select(DB::raw('UPDATE shipmentitems SET `Ship_Balance_Qty` ='. $new_balance_qtys .' where Shipment_Item_Id = '.Input::json('shipment_item_id')['shipment_item_id'.$i])); 
					$box_qty = Input::json('boxed_qty')['boxed_qty'.$i];
					$update_ship_item_details = DB::select(DB::raw('UPDATE shipmentsboxitems SET `Boxed_Qty` ='. $box_qty .' where Shipment_Box_Item_Id = '.Input::json('shipment_box_item_id')['shipment_box_item_id'.$i] )); 
				}
			}
		}	

		public function deleteShipmentBoxDetails(){			
			$MODIFY_TS = date("Y-m-d H:i:s");		
			$update_shipment_details = DB::select(DB::raw('UPDATE ShipmentsBoxes SET  Active="0",Modify_ts = "'.$MODIFY_TS.'"
															WHERE Shipment_Box_Id ='.Input::json('shipment_box_id'))); 			
			return Response::json(array('response' => "Succesfully Updated!!!"));
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @return Response
		 */		 
		
		public function createShipmentBoxItems(){
		$shipment_box_id = Input::json('shipment_boxid');	
	    $itembox_id  = Input::json('item_id');
		$itembox_qty = Input::json('box_qty');
			for($i=0; $i < count($itembox_id); $i++){
				$itm_id =  $itembox_id[$i];	
				$shipment_qty = $itembox_qty[$itm_id];			
				$inventory_id =  $this->getInventoryIDByShipmentItemId($itm_id);
				$inv_id = $inventory_id[0]->InventoryItem_Id;
				$current_stock = $inventory_id[0]->Stock_Count;	 
				$prod_list = $this->getProductDetailsByProductId($inventory_id[0]->Product_Id);	
				$bal_qty = ($inventory_id[0]->Balance_Qty) - $shipment_qty;					
				$shb_dtl = new Shipmentsboxitems;
				$shb_dtl->Shipment_Box_Id = Input::json('shipment_boxid');
				$shb_dtl->Shipment_Item_Id = $itm_id; 
				$shb_dtl->Item_Name = $prod_list[0]->Product_Name;
				$shb_dtl->Price = $prod_list[0]->Price;
				$shb_dtl->RefItemId = $prod_list[0]->RefItemId;
				$shb_dtl->SKU = $prod_list[0]->SKU;
				$shb_dtl->UnitWeight = $prod_list[0]->UnitWeight;
				$shb_dtl->Shipment_Qty = $shipment_qty;		
				$shb_dtl->CREATE_TS = date("Y-m-d H:i:s");
				$shb_dtl->MODIFY_TS = date("Y-m-d H:i:s");
				$shb_dtl->save(); 
				$this->updateBalanceQtyShipmentItems($bal_qty, $itm_id);
				$stock_onhand = ($current_stock - $shipment_qty);	 
				$this->updateInventoryStock($stock_onhand, $inv_id);
			}		
		}
		
		public function getInventoryIDByShipmentItemId($item_id){
		$inventory_list = DB::select(DB::raw("SELECT it.InventoryItem_Id, it.Product_Id, it.Stock_Count, si.Ship_Balance_Qty
													FROM InventoryItems it
													LEFT JOIN ShipmentItems si ON si.Inventory_Item_Id = it.InventoryItem_Id
													WHERE si.Shipment_Item_Id = ".$item_id)); 		  
		  return $inventory_list;
		}   
   
		public function getProductDetailsByProductId($pro_id){
			$product_id_list = DB::select(DB::raw("SELECT * FROM Products p WHERE p.Product_Id =".$pro_id));
			return $product_id_list;
		}		
				
		public function updateBalanceQtyShipmentItems($balance_qty,$itm_id){
			$update_shipment_details = DB::select(DB::raw('UPDATE ShipmentItems SET Ship_Balance_Qty='. "'" .$balance_qty. "'" .'
				WHERE Shipment_Item_Id = '.$itm_id )); 			
		}			
	
		public function updateInventoryStock($stock,$inv_itm_id){
			$update_shipment_details = DB::select(DB::raw('UPDATE inventoryitems SET Stock_Count='. "'" .$stock. "'" .'
				WHERE InventoryItem_Id = '.$inv_itm_id )); 			
		}	
	
		public function getShipmentBoxItemsDetailsById(){
			$shipmentboxitm_list = DB::select(DB::raw("SELECT * FROM ShipmentsBoxItems
							WHERE Shipment_Box_Id=".'1'));
			return Response::json(array('response' => $shipmentboxitm_list));
		}
		
		public function getShipmentBoxNameFlag($shipmentid,$boxname){	  
		   $shipmentboxname_list = DB::select(DB::raw("SELECT count(*) AS cntrow FROM ShipmentsBoxes 
				WHERE BoxName = '".$boxname."' AND Active='1' AND Shipment_Id=".$shipmentid ));
			return  $shipmentboxname_list;
		}
    
		public function deleteShipmentitm(){	   
			$MODIFY_TS = date("Y-m-d H:i:s");					
			$update_shipment_details = DB::select(DB::raw('UPDATE ShipmentsBoxes SET  Active="0",Modify_ts = "'.$MODIFY_TS.'" 
							WHERE Shipment_Box_Id ='.Input::json('shipment_box_id'))); 
			 
			$update_shipment_item_details = DB::select(
									DB::raw('SELECT sboxitem.Shipment_Box_Item_Id, sboxitem.Shipment_Item_Id, si.Ship_Balance_Qty, sboxitem.Boxed_Qty 
									FROM shipmentsboxitems AS sboxitem 
									LEFT JOIN shipmentitems AS si ON si.Shipment_Item_Id = sboxitem.Shipment_Item_Id 
									WHERE sboxitem.Shipment_Box_Id ='.Input::json('shipment_box_id')));		
			for($i=0; $i < count($update_shipment_item_details); $i++){				
			$update_Ship_Balance_Qty = $update_shipment_item_details[$i]->Ship_Balance_Qty + $update_shipment_item_details[$i]->Boxed_Qty;				
			$update_ship_details = DB::select(DB::raw('UPDATE shipmentitems SET `Ship_Balance_Qty` ='. $update_Ship_Balance_Qty .' where Shipment_Item_Id = '.$update_shipment_item_details[$i]->Shipment_Item_Id)); 			
			}  
			return Response::json(array('response' => "Succesfully Updated!!!"));
		} 
		
	}
