for(var item_no = 0; item_no < data.response.length; item_no++){
							alert(data.response.length);							
							if(data.response[item_no].Order_Item > 0){
								alert("Mandy Avilable Product");
								 var dynamic_element	=   "<div class='form-group'>"+
															"<label for='inputPassword3' class='col-sm-12 text-left' style='color:#0955d1;margin-top:-20px' >Item Details</label>"+
														"</div>"+
														"<div class='form-group' style='margin-top:-10px'>"+
															"<label class='col-sm-4'>Item Name</label>"+
															/* "<label class='col-sm-2'>Available Qty</label>"+ */
															"<label class='col-sm-2'>Total Order Qty</label>"+
															"<label class='col-sm-2'>Un Shipped Qty</label>"+
															"<label class='col-sm-2'>Ship Qty</label>"+											
														"</div>"; 
										for(var pro_item_no = 0; pro_item_no < data.response.length; pro_item_no++){
										if(data.response[pro_item_no].Order_Item > 0){
										dynamic_element   +=	"<div classs='form-group'>"+
															"<input type='hidden' class='form-control' id='orderid' name='order_item_id'  ng-model='shipmentdetails.order_item_id.order_item_id"+pro_item_no+"'>"+					
													"</div>"+
													
													"<div class='form-group' id='item_no"+pro_item_no+"'>"+
													"<div>"+
															"<input type='hidden' class='form-control' id='order_item_no"+pro_item_no+"' placeholder='Order Item Id'  name='order_item_no' ng-model='shipmentdetails.order_item_no.order_item_no"+pro_item_no+"' ng-disabled='true'>"+
													"</div>"+											
																										
													"<div class='col-sm-4'>"+
															"<input type='text' class='form-control' id='order_item"+pro_item_no+"' placeholder='Order Item'  name='order_item' ng-model='shipmentdetails.order_item.order_item"+pro_item_no+"' ng-disabled='true'>"+
													"</div>"+											
																									
													/* "<div class='col-sm-2'>"+
														"<input type='text' class='form-control' id='avilable_qty"+pro_item_no+"' placeholder='Available Qty'  name='order_qty' ng-model='shipmentdetails.avilable_qty.avilable_qty"+pro_item_no+"' required ng-disabled='true'>"+
													"</div>"+ */
													
													"<div class='col-sm-2'>"+
														"<input type='text' class='form-control' id='order_qty"+pro_item_no+"' placeholder='Order Qty'  name='order_qty' ng-model='shipmentdetails.order_qty.order_qty"+pro_item_no+"' required ng-disabled='true'>"+
													"</div>"+
													
													"<div class='col-sm-2'>"+
														"<input type='text' class='form-control' id='balance_qty"+pro_item_no+"' placeholder='Balance Qty'  name='balance_qty' ng-model='shipmentdetails.balance_qty.balance_qty"+pro_item_no+"' required ng-disabled='true'>"+
													"</div>"+
													
													"<div class='col-sm-2'>"+
														"<input type='text' class='form-control' id='shipment_qty"+pro_item_no+"'  name='shipment_qty' ng-model='shipmentdetails.shipment_qty.shipment_qty"+pro_item_no+"' required>"+
													"</div>"+																																			
												"</div>";									
											}else{
												$("#item_no"+pro_item_no).remove();	
											}	
										}
										
										var dynamic_angular_js_element = $compile(dynamic_element)($scope);
										angular.element(document.getElementById('items')).append(dynamic_angular_js_element); 
																				
										var order_item_new_name, order_qty_new_name, order_item_id_new_name;
										for(var item_nos = 0; item_nos <= data.response.length; item_nos++){
											order_item_new_name = "order_item"+item_nos;
											order_qty_new_name = "order_qty"+item_nos;
											order_item_id_new_name = "order_item_id"+item_nos;
											//inv_avail_qty = "avilable_qty"+item_nos;
											$scope.shipmentdetails.order_item = {};
											$scope.shipmentdetails.order_qty = {};
											$scope.shipmentdetails.balance_qty = {};
											$scope.shipmentdetails.shipment_qty = {};
											$scope.shipmentdetails.order_item_id = {};
										//	$scope.shipmentdetails.avilable_qty = {};
										}							
									
										/*var shipmentdetails, order_item, order_qty, order_item_id, balance_qty, shipment_qty, active_status = {};
										for(var item_num = 0; item_num <data.response.length; item_num++){
											if(data.response[item_num].Order_Item != "0"){	
													var order_item_new_name = "order_item"+item_num;
													var order_qty_new_name = "order_qty"+item_num;
													var order_item_id_new_name = "order_item_id"+item_num;
													var balance_qty_new_name = "balance_qty"+item_num;
													var shipment_qty_new_name = "shipment_qty"+item_num;
													var inv_avail_qty = "avilable_qty"+item_num;											
																							
													$scope.shipmentdetails.order_item[order_item_new_name] = data.response[item_num].Order_Item;
													//$scope.shipmentdetails.order_item_num[order_item_new_name_num] = data.response[item_num].ItemName;
													$scope.shipmentdetails.avilable_qty = {};
													$scope.shipmentdetails.order_qty[order_qty_new_name] = data.response[item_num].Order_Qty;
													$scope.shipmentdetails.order_item_id[order_item_id_new_name] = data.response[item_num].Order_Item_Id;
													if(data.response[item_num].Balance_Qty == "0"){
														$scope.shipmentdetails.balance_qty[balance_qty_new_name] = data.response[item_num].Balance_Qty;
														$scope.shipmentdetails.shipment_qty[shipment_qty_new_name] = data.response[item_num].Balance_Qty;
														$("#item_no"+item_num).remove();
													}else{
														$scope.shipmentdetails.balance_qty[balance_qty_new_name] = data.response[item_num].Balance_Qty;
													} 											 
												}else{
												$("#item_no"+item_num).remove();
											} 											
										}*/ 											
							} else if(data.response[item_no].Order_Item == "0"){
								alert("kandy Avilable Product");
								 var dynamic_element =	"<div class='form-group'>"+
												"<label for='inputPassword3' class='col-sm-12 text-left' style='color:#0955d1;margin-top:-10px' >Item Details</label>"+
												"</div>"+
												"<div class='form-group' style='margin-top:-5px'>"+
													"<label class='col-sm-3'>Item Name</label>"+
													"<label class='col-sm-3'>Avilable Item</label>"+
													/* "<label class='col-sm-2'>Available Qty</label>"+ */
													"<label class='col-sm-2'>Total Order Qty</label>"+
													"<label class='col-sm-2'>Un Shipped Qty</label>"+
													"<label class='col-sm-2'>Ship Qty</label>"+											
												"</div>";
								for(var pro_item_no = 0; pro_item_no < data.response.length; pro_item_no++){
								if(data.response[pro_item_no].Order_Item == 0){
								dynamic_element   +=	"<div classs='form-group'>"+
														"<input type='hidden' class='form-control' id='orderid' name='order_item_id'  ng-model='shipmentdetails.order_item_id.order_item_id"+pro_item_no+"'>"+					
													"</div>"+
													
													"<div class='form-group' id='item_no"+pro_item_no+"'>"+
														"<div class='col-sm-3'>"+
															"<input type='text' class='form-control' id='order_items"+pro_item_no+"' placeholder='Order Item'  name='order_items' ng-model='shipmentdetails.order_items.order_items"+pro_item_no+"' ng-disabled='true'>"+
													"</div>"+	

													"<div class='col-sm-3'>"+
													   "<select class='form-control' id='order_item"+pro_item_no+"' ng-change=invAvilableQty("+pro_item_no+") name='order_item' ng-model='shipmentdetails.order_item.order_item"+pro_item_no+"' ng-options='response.p_id as response.name for response in product_lists' ng-required='true'>"+
															"<option value=''>--- Select Item Type ---</option>"+												
														"</select>"+                              
													"</div>"+
																									
													/* "<div class='col-sm-2'>"+
														"<input type='text' class='form-control' id='avilable_qty"+pro_item_no+"' placeholder='Available Qty'  name='avilable_qty' ng-model='shipmentdetails.avilable_qty.avilable_qty"+pro_item_no+"' required ng-disabled='true'>"+
													"</div>"+ */
													
													"<div class='col-sm-2'>"+
														"<input type='text' class='form-control' id='order_qty' placeholder='Order Qty'  name='order_qty' ng-model='shipmentdetails.order_qty.order_qty"+pro_item_no+"' required ng-disabled='true'>"+
													"</div>"+
													
													"<div class='col-sm-2'>"+
														"<input type='text' class='form-control' id='balance_qty' placeholder='Balance Qty'  name='balance_qty' ng-model='shipmentdetails.balance_qty.balance_qty"+pro_item_no+"' required ng-disabled='true'>"+
													"</div>"+
													
													"<div class='col-sm-2'>"+
														"<input type='text' class='form-control' id='shipment_qty'  name='shipment_qty' ng-model='shipmentdetails.shipment_qty.shipment_qty"+pro_item_no+"' required>"+
													"</div>"+																																			
												"</div>";	

											var product_list = [];
											var getProductList  = $http.post("/shipment/get_product",{warehouse_id : "4"}).success(function (data, status, headers, config){
												for(var i = 0; i < data.response.length; i++){
													product_list.push({p_id : data.response[i].Product_Id, name : data.response[i].Product_Name});     
												}
												$scope.product_lists = product_list;
											});		
									}else{									
									}
								}					
								var dynamic_angular_js_element = $compile(dynamic_element)($scope);
								angular.element(document.getElementById('items')).append(dynamic_angular_js_element); 
								
								
								
								/* $scope.invAvilableQty = function(item_no){									
									var new_order_item = "order_item"+item_no;
									var getavilableQtyList  = $http.post("/order/getAvilableQty",{product_id : $scope.shipmentdetails.order_item[new_order_item]}).success(function (data, status, headers, config){
										console.log(data.avilable_qty[0].Stock_Count);	
										var new_avail_qty = "avilable_qty"+item_no;
										$scope.shipmentdetails.avilable_qty[new_avail_qty] = data.avilable_qty[0].Stock_Count;
									}); 
								} 	 */																		
								
								/*var order_item_new_names, order_qty_new_name, order_item_id_new_name;
									for(var item_nos = 0; item_nos <= data.response.length; item_nos++){
										order_item_new_names = "order_items"+item_nos;
									//	order_item_names = "order_items"+item_nos;
										order_qty_new_name = "order_qty"+item_nos;
										order_item_id_new_name = "order_item_id"+item_nos;										
										$scope.shipmentdetails.order_items = {};										
										$scope.shipmentdetails.order_qty = {};
										$scope.shipmentdetails.balance_qty = {};
										$scope.shipmentdetails.shipment_qty = {};
										$scope.shipmentdetails.order_item_id = {};
										$scope.shipmentdetails.avilable_qty = {};
									}																				
									var shipmentdetails,order_item, order_qty, order_item_id, balance_qty, shipment_qty, active_status = {};
									for(var item_num = 0; item_num < data.response.length; item_num++){
										if(data.response[item_nos].Order_Item == "0"){																					
											var order_item_new_names = "order_items"+item_nos;
											var order_qty_new_name = "order_qty"+item_nos;
											var order_item_id_new_name = "order_item_id"+item_nos;
											var balance_qty_new_name = "balance_qty"+item_nos;
											var shipment_qty_new_name = "shipment_qty"+item_nos;										
											var available_qty_new_name = "avilable_qty"+item_nos;											
											$scope.shipmentdetails.order_items[order_item_new_names] = data.response[item_nos].ItemName;
											$scope.shipmentdetails.order_qty[order_qty_new_name] = data.response[item_nos].Order_Qty;
											$scope.shipmentdetails.order_item_id[order_item_id_new_name] = data.response[item_nos].Order_Item_Id;
											if(data.response[item_nos].Balance_Qty == "0"){
												$scope.shipmentdetails.balance_qty[balance_qty_new_name] = data.response[item_nos].Balance_Qty;
												$scope.shipmentdetails.shipment_qty[shipment_qty_new_name] = data.response[item_nos].Balance_Qty;
												$("#item_no"+item_nos).remove();
											}else{
												$scope.shipmentdetails.balance_qty[balance_qty_new_name] = data.response[item_nos].Balance_Qty;
											}						
										}else{												
											$("#item_no"+item_nos).remove();												
										}  
									}*/	
								}							
						}							
				}		