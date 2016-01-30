'use strict';

/*
 *	Bulk Import Order Controller.
 *
 */
		
angular.module("app.controllers", []).controller("bulkImportOrderCtrl",  ["$scope", "$compile", "$location", "$http", "$sanitize", "$stateParams", "$state","$rootScope", "Messages", "ToastOptions", function($scope, $compile, $location, $http, $sanitize, $stateParams, $state,$rootScope, Messages, ToastOptions) {
		// Clears All Form Fields
		$scope.orderdetails = {orderdate: "",created_date: "",shipmentdate: "",billname: "",shipname: "",shipcompany: "",billcompany: ""};
		$rootScope.breadcrumb_array = [{"name":"Order", "url": "#/order/orderList"},{"name":"Add New", "url": "#/order/addOrder"}];
		$scope.orderdetails.avilable_qty = {};
		$("#header").show();
	    $("#nav-container").show();	
			var item_no = 0;
			var item_total = 0;
			var deleted_item_list = new Array();			
			var carrier_list = [];
			var getCarrierList = $http.get("/order/getCarrierDetail").success(function (data, status, headers, config){
                for(var i = 0; i < data.carriername.length; i++){
                    carrier_list.push({id : data.carriername[i].Carrier_Id, name : data.carriername[i].Carrier_Name});     
                }
                $scope.carrier_lists = carrier_list;
            });
			
			var carrier_service_list = [];
			var getCarrierList = $http.get("/order/getCarrierServiceDetail").success(function (data, status, headers, config){
					for(var i = 0; i < data.carrierservicename.length; i++){
					carrier_service_list.push({id : data.carrierservicename[i].	CarrierService_Id, name : data.carrierservicename[i].CarrierService_Name});     
					}
				$scope.carrier_service_list = carrier_service_list;
            });
			
			$scope.addAdditionalProduct = function(){
				item_no = item_no + 1;
				item_total=item_no + 1;
				var dynamic_element = 	"<div test-dir class='form-group' id='item_no"+item_no+"'>"+
											"<div class='col-sm-4'>"+
											   "<select class='form-control' id='order_item"+item_no+"' name='order_item' ng-model='orderdetails.order_item.order_item"+item_no+"' ng-options='response.id as response.name for response in product_lists' ng-required='true'>"+
													"<option value=''>--- Select Item Type ---</option>"+
												"</select>"+                              
											"</div>"+
											
											"<div class='col-sm-2'>"+
												"<input type='text' class='form-control' id='order_qty"+item_no+"' placeholder='Order Qty'   ng-change=checkQty("+item_no+",this.value) name='order_qty' ng-model='orderdetails.order_qty.order_qty"+item_no+"' required>"+
											"</div>"+
											"<div class='col-sm-1'>"+
												"<button id='remove"+item_no+"' name = 'orderdetails.remove"+item_no+"' data-ng-click='removeItem("+item_no+")'>"+
													"<label for='email' class='glyphicon glyphicon-remove' rel='tooltip' title='Remove'></label>"+
												"</button>"+
											"</div>"+
										"</div>";
				var dynamic_angular_js_element = $compile(dynamic_element)($scope);
				angular.element(document.getElementById('items')).append(dynamic_angular_js_element);	
			}
			
			$scope.addNewProduct = function(){
				item_no = item_no + 1;
				var dynamic_element = 	"<div test-dir class='form-group' id='item_no"+item_no+"'>"+
											"<div class='col-sm-2'>"+
											    "<input type='text' class='form-control' id='order_item"+item_no+"' placeholder='Item Name' name='order_item' ng-model='orderdetails.order_item.order_item"+item_no+"' required>"+                           
											"</div>"+
											
											"<div class='col-sm-2'>"+
												"<input type='text' class='form-control' id='item_des"+item_no+"' placeholder='Item Description'  name='item_des' ng-model='orderdetails.item_des.item_des"+item_no+"' >"+
											"</div>"+
											
											"<div class='col-sm-1'>"+
												"<input type='text' class='form-control' id='item_ref_no"+item_no+"' placeholder='No'  name='item_ref_no' ng-model='orderdetails.item_ref_no.item_ref_no"+item_no+"' required>"+
											"</div>"+
											
											"<div class='col-sm-1'>"+
												"<input type='text' class='form-control' id='sku"+item_no+"' placeholder='SKU'  name='sku' ng-model='orderdetails.sku.sku"+item_no+"' required>"+
											"</div>"+
											
											"<div class='col-sm-2'>"+
												"<input type='text' class='form-control' id='u_weight"+item_no+"' placeholder='Weight'  name='u_weight' ng-model='orderdetails.u_weight.u_weight"+item_no+"' required>"+
											"</div>"+											
											
											"<div class='col-sm-2'>"+
												"<input type='text' class='form-control' id='price"+item_no+"' placeholder='Price'  name='price' ng-model='orderdetails.price.price"+item_no+"' required>"+
											"</div>"+
																																
											"<div class='col-sm-1'>"+
												"<input type='text' class='form-control' id='order_qty"+item_no+"' placeholder='Qty'   ng-change=checkQty("+item_no+",this.value) name='order_qty' ng-model='orderdetails.order_qty.order_qty"+item_no+"' required>"+
											"</div>"+
											
											"<div class='col-sm-1'>"+
												"<button id='remove"+item_no+"' name = 'orderdetails.remove"+item_no+"' data-ng-click='removeItem("+item_no+")'>"+
													"<label for='email' class='glyphicon glyphicon-remove' rel='tooltip' title='Remove'></label>"+
												"</button>"+
											"</div>"+
										"</div>";
				var dynamic_angular_js_element = $compile(dynamic_element)($scope);
				angular.element(document.getElementById('newitems')).append(dynamic_angular_js_element);	
			}
					
			$scope.removeItem = function(item_no){
				var revove_elm_id = "item_no"+item_no;
				var elem = document.getElementById(revove_elm_id);
				angular.element(elem).remove();
				deleted_item_list.push(item_no);
			}
			
			$scope.pageClass = 'page-contact';
			$scope.cancelAdd = function (){
				$state.go('orderlist');
			}	
				
			var channel_list = [];      
				var getChannelList = $http.get("/order/get_channel").success(function (data, status, headers, config){
                    for(var i = 0; i < data.response.length; i++){
                    channel_list.push({id : data.response[i].Channel_Id, name : data.response[i].Channel_Name});     
                }
                $scope.channel_list = channel_list;
            });
					   
			//Get Product List Matching Selected channel
			$scope.channelSelect = function(){				
				// Get product List Matching Selected Channel
				if($scope.product_lists){
					if($scope.product_lists.length > 0){
						for(var i = $scope.product_lists.length; i >= 0; i--){
							$scope.product_lists.pop($scope.product_lists[i]);     
						}
						$scope.orderdetails.order_qty=""; 
					}
				}
												
				var product_list = [];
				var getProductList  = $http.post("/order/get_product",{channel_id : $scope.orderdetails.channel_name}).success(function (data, status, headers, config){
				for(var i = 0; i < data.response.length; i++){
					product_list.push({id : data.response[i].Product_Id, name : data.response[i].Product_Name});     
				}
				$scope.product_lists = product_list;
				}); 										
			}
									
			$scope.toggleSelection = function(){
				$scope.orderdetails.billname = $scope.orderdetails.shipname;
				$scope.orderdetails.billcompany = $scope.orderdetails.shipcompany;
				$scope.orderdetails.billcountry = $scope.orderdetails.shipcountry;	
				$scope.orderdetails.billstate = $scope.orderdetails.shipstate;	
				$scope.orderdetails.billcity = $scope.orderdetails.shipcity;
				$scope.orderdetails.billaddress = $scope.orderdetails.shippingaddress;
				$scope.orderdetails.billaddress2 = $scope.orderdetails.shippingaddress2;	
				$scope.orderdetails.billemail = $scope.orderdetails.shipemail;	
				$scope.orderdetails.billzip = $scope.orderdetails.shipzip;		
			}		
														
            var sanitizeCredentials = function(orderdetails) {				
				return {                    
                        channel_name:orderdetails.channel_name,
					    orderdate: orderdetails.orderdate,
                       	deleted_item_list : orderdetails.deleted_item_list,
						shipmentdate: orderdetails.shipmentdate,
						shipname :$sanitize(orderdetails.shipname),
						shippingaddress : $sanitize(orderdetails.shippingaddress),
						shippingaddress2 : $sanitize(orderdetails.shippingaddress2),
						shipcompany : $sanitize(orderdetails.shipcompany),
						shipzip: $sanitize(orderdetails.shipzip),
						shipcountry : $sanitize(orderdetails.shipcountry),
						shipstate : $sanitize(orderdetails.shipstate),
						shipcity : $sanitize(orderdetails.shipcity),
						shipemail : $sanitize(orderdetails.shipemail),
						billname : $sanitize(orderdetails.billname),
						billaddress : $sanitize(orderdetails.billaddress),
						billaddress2 : $sanitize(orderdetails.billaddress2),
						billcompany : $sanitize(orderdetails.billcompany),
						billcountry : $sanitize(orderdetails.billcountry),
						billstate : $sanitize(orderdetails.billstate),
						billcity : $sanitize(orderdetails.billcity),
						billzip : $sanitize(orderdetails.billzip),
						billemail : $sanitize(orderdetails.billemail),
						billphone : $sanitize(orderdetails.billphone),
						ref_order_id : $sanitize(orderdetails.ref_order_id),
						ordertotal : orderdetails.ordertotal,
						total_shipment_price : orderdetails.total_shipment_price,
						carrier_name : $sanitize(orderdetails.carrier_name),
						carrier_service_name: $sanitize(orderdetails.carrier_service_name),
						comments : $sanitize(orderdetails.comments),
						order_item: orderdetails.order_item,
						avilable_qty:orderdetails.avilable_qty,
                        order_qty: orderdetails.order_qty,
						created_date:orderdetails.created_date,
						item_des:orderdetails.item_des,
						item_ref_no:orderdetails.item_ref_no,
						sku:orderdetails.sku,
						u_weight:orderdetails.u_weight,
						price:orderdetails.price,
				};
			};
      
            // Add Order Details to the db
            $scope.addorderdetails = function(){				
				if($scope.orderdetails.order_item){
					$("#submit").prop('disabled', true);
					$scope.orderdetails.deleted_item_list = deleted_item_list;
					var orderdate = new Date($scope.orderdetails.orderdate);	
					var year = orderdate.getFullYear();
					var month = orderdate.getMonth() + 1;
					var date = orderdate.getDate();
					$scope.orderdetails.orderdate = year + "-" + month + "-" + date;
					var shipmentdate = new Date($scope.orderdetails.shipmentdate);	
					var year = shipmentdate.getFullYear();
					var month = shipmentdate.getMonth() + 1;
					var date = shipmentdate.getDate();
					$scope.orderdetails.shipmentdate = year + "-" + month + "-" + date;
					var created_date = new Date($scope.orderdetails.created_date);	
					var year = created_date.getFullYear();
					var month = created_date.getMonth() + 1;
					var date = created_date.getDate();
					$scope.orderdetails.created_date = year + "-" + month + "-" + date;
					var addNewOrder = $http.post("/order/addOrder",sanitizeCredentials($scope.orderdetails)).success(function (data, status, headers, config) {
						toastr.success(Messages.Order.Success, '', ToastOptions);
						$location.path("/order/orderList");
					});		
				}else{
					alert("Please Add Item");
				}				
            }
        }]);