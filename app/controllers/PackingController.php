<?php
/**	
*	File Name 			: 	packingController.php
*	File Description	:	To packing Details 
*	Created Date 		:	11- DEC - 2014
*	Modified Date 		:	11- DEC - 2014
*	Company				:	iExemplar
*	Created By			:	Manthiriyappan A
*	Contributors		:	Manthiriyappan A
**/
class PackingController extends BaseController {
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function packingList()
	{
		/* $packing_list = DB::select(DB::raw("SELECT PACK.Packing_Slip_Id,PACK.Packing_Slip_Date,PRO.Product_Id, PACK.Additional_Notes,PITEMS.Packing_Slip_Item,PITEMS.Packing_Slip_Qty,CHA.Channel_Name,JOB.Job_Id,JOB.Channel_Id,PRO.Product_Name FROM PACKINGSLIPS AS PACK INNER JOIN PACKINGSLIPITEMS AS PITEMS ON PITEMS.PACKING_SLIP_ID = PACK.PACKING_SLIP_ID LEFT JOIN products AS PRO ON PRO.Product_Id=PITEMS.Packing_Slip_Item LEFT JOIN jobs AS JOB ON JOB.Job_Id=PACK.Job_Id LEFT JOIN channels AS CHA ON CHA.Channel_Id=JOB.Channel_Id where PACK.Active = ".'"1"' ." Group By PACK.Packing_Slip_Id")); 
		return Response::json(array('response' => $packing_list)); */
	}


	/*
	*	Get Channel and Id form Channel Table
	*
	**/
	public function getPackingChannel(){
		// Query To Fetch Products Details
	/* 	$channel_list = DB::table('channels')->get();
		return Response::json(array('response' => $channel_list)); */
	}

	/*
	*	Get Product and Id form Product Table
	*
	**/
	public function getPackingProduct(){
		// Query To Fetch Products Details
		/* $product_list = DB::table('products')->get();
		return Response::json(array('response' => $product_list)) */;
	}


   	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function storePacking()
	{

		// Insert New Jobs Details in Jobs Table
		/* $jobs_dtl = new Jobs;
		$jobs_dtl->Channel_Id = Input::json('channel_name');
		$jobs_dtl->Job_Type_Id = "3";
		$jobs_dtl->Parent_Job_Id = Input::json('p_jobid');
		$jobs_dtl->Job_Status_Id = "11";
		$jobs_dtl->ACTIVE = 1;
		$jobs_dtl->CREATE_TS = date("Y-m-d H:i:s");
		$jobs_dtl->MODIFY_TS = date("Y-m-d H:i:s");
		$jobs_dtl->save();
		
		// Insert New PackingSlips Details in Packingslips Table
		$packing_dtl = new Packingslips;
		$packing_dtl->Job_Id =$jobs_dtl->id;
		$packing_dtl->Packing_Slip_Date	 =  Input::json('packing_slip_date');
		$packing_dtl->Additional_Notes	 = Input::json('additional_notes');
		$packing_dtl->ACTIVE = 1;
		$packing_dtl->CREATE_TS = date("Y-m-d H:i:s");
		$packing_dtl->MODIFY_TS = date("Y-m-d H:i:s");
		$packing_dtl->save();

		// Insert New PackingSlipsItems Details in Packingslipitems Table
		$packing_slip_item_count = count(Input::json('packing_slip_item'));		
		for($i=0; $i < $packing_slip_item_count; $i++){
			$packing_slip_dtl = new Packingslipitems;
			$packing_slip_dtl->Packing_Slip_Id = $packing_dtl->id;
			$packing_slip_dtl->Packing_Slip_Item =  Input::json('packing_slip_item')['order_item'.$i];
			$packing_slip_dtl->Packing_Slip_Qty = Input::json('packing_slip_qty')['order_qty'.$i];
			$packing_slip_dtl->ACTIVE = 1;
			$packing_slip_dtl->CREATE_TS = date("Y-m-d H:i:s");
			$packing_slip_dtl->MODIFY_TS = date("Y-m-d H:i:s");
			$packing_slip_dtl->save();
		}
		return Response::json(array('Response'=> $packing_slip_dtl->id, 'flash' => 'Save Successfully!!!!!')); */
	}
  
	public function getEditPackingDetails(){
		/* $packing_list = DB::select(DB::raw("SELECT PACKSL.Packing_Slip_Id,PACKSL.Job_Id,PACKSL.Packing_Slip_Date,PACKSL.Additional_Notes,PACKSLIT.Packing_Slip_Item, PACKSLIT.Packing_Slip_Item_Id,PACKSLIT.Packing_Slip_Qty,JOB.Channel_Id,CHAN.Channel_Name,PRO.Product_Name FROM packingslips AS PACKSL LEFT JOIN packingslipitems AS PACKSLIT ON PACKSLIT.Packing_Slip_Id=PACKSL.Packing_Slip_Id LEFT JOIN JOBS AS JOB ON JOB.Job_Id=PACKSL.Job_Id LEFT JOIN channels AS CHAN ON CHAN.Channel_Id=JOB.Channel_Id LEFT JOIN products AS PRO ON PRO.Product_Id=PACKSLIT.Packing_Slip_Item  WHERE PACKSL.Packing_Slip_Id = ". Input::json('id') )); 
		$channel_list = DB::table('channels')->get();
		$product_list = DB::table('products')->get();
		return Response::json(array('response' => $packing_list, 'channel' => $channel_list, 'product' => $product_list)); */
	}

	public function editPackingDetails(){
		/* $update_job_details = DB::select(DB::raw('update jobs set `Channel_Id` ='. Input::json('channel_name'). ' where Job_Id = ' . Input::json('jobid'))); 
		$update_packing_details = DB::select(DB::raw('update packingslips set  `Additional_Notes` ='. "'" .Input::json('additional_notes'). "'" .', `Packing_Slip_Date` =  '  . "'". Input::json('packing_slip_date'). "'".' where Packing_Slip_Id = ' . Input::json('packingid'))); 
		$order_item_count = count(Input::json('packingslip_id'));
		for($i=0; $i < $order_item_count; $i++){
			$update_packing_item_details = DB::select(DB::raw('update packingslipitems set `Packing_Slip_Item` =  '. Input::json('packing_slip_item')['order_item'.$i]. ' , `Packing_Slip_Qty` = '. Input::json('packing_slip_qty')['order_qty'.$i]. ' where Packing_Slip_Item_Id = ' . Input::json('packingslip_id')['order_item_id'.$i])); 
		}
		return Response::json(array('response' => "Succesfully Updated!!!")); */
	}
	
	public function deletePackingDetails(){
		/* $delete_packing_details = DB::select(DB::raw('update packingslips set `ACTIVE` = "0" where Packing_Slip_Id = ' . Input::json('id'))); 
		return Response::json(array('response' => "Record Deleted Successfully!!")); */
	}
	
	public function getPackingListCount(){
		/* $order_list = DB::select(DB::raw("select ORE.ORDER_ID, ORE.Order_Date, ORE.First_Name, ORE.Last_Name, ORE.Job_Id, OREI.Order_Qty, OREI.Order_Item, PRO.Product_Name from orders AS ORE LEFT JOIN orderitems AS OREI ON OREI.Order_Id=ORE.Order_Id LEFT JOIN products AS PRO ON PRO.Product_Id = OREI.Order_Item where ORE.Job_Id in (select JOBS.Job_Id from JOBS JOBS where JOBS.Job_Status_Id in (".'"1"'.",".'"2"'.",".'"3"'.") and Parent_Job_Id IS NULL and job_id not in (select distinct parent_job_id from JOBS where Job_Status_Id = ".'"11"'."))and ORE.Active = ".'"1"'." Group By ORE.ORDER_ID")); 		
		$created_packing_list = DB::select(DB::raw("SELECT PACK.Packing_Slip_Id,PACK.Packing_Slip_Date,PRO.Product_Id, PACK.Additional_Notes,PITEMS.Packing_Slip_Item,PITEMS.Packing_Slip_Qty,CHA.Channel_Name,JOB.Job_Id,JOB.Channel_Id,PRO.Product_Name FROM PACKINGSLIPS AS PACK INNER JOIN PACKINGSLIPITEMS AS PITEMS ON PITEMS.PACKING_SLIP_ID = PACK.PACKING_SLIP_ID LEFT JOIN products AS PRO ON PRO.Product_Id=PITEMS.Packing_Slip_Item LEFT JOIN jobs AS JOB ON JOB.Job_Id=PACK.Job_Id LEFT JOIN channels AS CHA ON CHA.Channel_Id=JOB.Channel_Id where PACK.Active = ".'"1"' ." Group By PACK.Packing_Slip_Id")); 
		return Response::json(array('all_order_list' =>$order_list, 'created_packing_count' => $created_packing_list)); */
	}
}
