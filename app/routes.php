<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('fulfilldirect');
});
//Route::when('/#/*', 'auth');


Route::resource('users','UsersController');
Route::post('/auth/login', array('before' => 'csrf_json', 'uses' => 'AuthController@login'));
//Route::post('/auth/login', 'AuthController@login');
Route::get('/auth/logout', 'AuthController@logout');
Route::get('/auth/status', 'AuthController@status');
Route::post('auth/haschannelright','AuthController@hasChannelRight');

Route::post('/invenotry/getStockCount', 'InventoryController@stockCount');
Route::get('/order/getInventoryListCount', 'InventoryController@getInventoryListCount');
Route::get('/product/getProductListCount', 'ProductController@getProductListCount');
Route::get('/shipment/getShipmentListCount', 'ShipmentController@getShipmentCount');
Route::get('/order/getOrderListCount', 'OrderController@getOrderListCount');


Route::group(array('before' => 'auth'), function() {
	Route::post('/mail/newmail', 'MailController@sendMail');

//Inventory Details
	Route::get('/inventory/inventoryList', 'InventoryController@inventoryList');
	Route::post('/invenotry/getProduct', 'InventoryController@productList');
	Route::get('/invenotry/getWarehouse', 'InventoryController@warehouseList');
	Route::get('/invenotry/getChannel', 'InventoryController@channelList');
	Route::post('/inventory/addInventory', 'InventoryController@create');
	Route::post('/inventory/getEidtInventoryDetails', 'InventoryController@getEditInventoryDetails');
	Route::post('/inventory/editInventory', 'InventoryController@editInventoryDetail');
	Route::post('/inventory/deleteInventoryItem', 'InventoryController@deleteInventoryDetail');
	Route::post('/inventory/allowInvEditDelete', 'InventoryController@allowInvEditDelete');
	Route::post('/inventory/allowInvAdd', 'InventoryController@allowInvAdd');




//Product Details
	Route::get('/product/product_List', 'ProductController@productList');
	Route::post('/product/addProduct', 'ProductController@saveNewProduct');
	Route::post('/product/showProduct', 'ProductController@getEditProductDetails');
	Route::post('/product/editProduct', 'ProductController@editProductDetail');
	Route::post('/product/deleteProduct', 'ProductController@deleteProductDetail');
	Route::post('/product/allowProductAdd', 'ProductController@allowProductAdd');
	Route::post('/product/allowProductEditDelete', 'ProductController@allowProductEditDelete');


//Order Details
	Route::Post('/order/getWarehouse', 'OrderController@getChannelWarehouseDetails');
	Route::get('/order/orderList', 'OrderController@orderList');
	Route::get('/order/newOrderList', 'OrderController@newOrderList');
	Route::get('/order/inprogressOrderList', 'OrderController@inprogressOrderList');
	Route::get('/order/closedOrderList', 'OrderController@closedOrderList');
	Route::post('/order/addOrder', 'OrderController@storeOrder');
	Route::post('/order/editOrder', 'OrderController@edit');
	Route::get('/order/get_channel', 'OrderController@getChannel');
	Route::post('/order/get_product', 'OrderController@getChannelProductDetails');
	Route::post('/order/orderDelete', 'OrderController@deleteOrderDetails');
	Route::post('/order/edit_order', 'OrderController@editOrderDetails');
	Route::post('/order/getEditOrderDetails', 'OrderController@getEditOrderDetails');

	Route::post('/order/getEditPackingDetails', 'OrderController@getPackingDetails');
	Route::post('/order/getEditShipmentDetails', 'OrderController@getShipementDetails');
	Route::get('/order/getCarrierDetail', 'OrderController@getCarrierDetails');
	Route::get('/order/getCarrierServiceDetail', 'OrderController@getCarrierServiceDetails');
	Route::post('/order/getAvilableQty', 'OrderController@getAvilableQtyDetails');
	Route::post('/order/edit_order_status', 'OrderController@updateOrderStatus');
	Route::post('/order/orderItemDetails', 'OrderController@itemOrderDetails');
	Route::post('/order/bulkImportOrder', 'OrderController@bulkImportOrder');
	Route::post('/order/allowOrderEditDelete', 'OrderController@allowOrderEditDelete');
	Route::post('/order/allowOrderAdd', 'OrderController@allowOrderAdd');
	Route::post('/order/allowOrderBulkAdd', 'OrderController@allowOrderBulkAdd');
	Route::post('/order/allowOrderShipAdd', 'OrderController@allowOrderShipAdd');
	Route::post('/order/allowOrderStatusChange', 'OrderController@allowOrderStatusChange');
	Route::post('/order/allowedOrderStatuses', 'OrderController@allowedOrderStatuses');

//shipment Details

	Route::post('/package/getPackingOrderDetails', 'OrderController@packingOrderDetails');
	Route::post('/shipment/getPackingListCount', 'ShipmentController@getShipmentListCount');
	Route::get('/shipment/allShipmentList', 'ShipmentController@allShipmentList');
	Route::get('/shipment/get_shipment_channel', 'ShipmentController@getShipingChannel');
	Route::get('/shipment/get_shipment_product', 'ShipmentController@getShipingProduct');
	Route::post('/shipment/addShipment', 'ShipmentController@storeShipment');
	Route::post('/shipment/shipmentDelete', 'ShipmentController@deleteShipmentDetails');
	Route::post('/shipment/editShipment', 'ShipmentController@getEditShipmentDetails');
	Route::post('/shipment/edit_Shipment', 'ShipmentController@editShipmentDetails');
	Route::post('/shipment/showPartialShipment', 'ShipmentController@showPartiallShipmentDetails');
	Route::get('/shipment/startedShipmentList', 'ShipmentController@startedShipmentList');

	Route::get('/shipment/pendingShipmentList', 'OrderController@orderListShipment');
	Route::get('/shipment/shippedShipmentList', 'ShipmentController@shippedShipmentList');
	Route::post('/shipment/order_to_shipment', 'ShipmentController@orderToShipmentList');
	Route::post('/shipment/edit_shipment_status', 'ShipmentController@updateShipmentStatus');
	Route::post('/shipment/getWarehouse', 'ShipmentController@getWarehouseFromInventory');
	Route::post('/shipment/get_inv_product', 'ShipmentController@getInventoryProduct');
	Route::post('/shipment/allowDirectShipmentAdd', 'ShipmentController@allowDirectShipmentAdd');
	Route::post('/shipment/allowShipmentEditDelete', 'ShipmentController@allowShipmentEditDelete');
	Route::post('/shipment/allowShipBoxAdd', 'ShipmentController@allowShipBoxAdd');
	Route::post('/shipment/allowShipmentStatusChange', 'ShipmentController@allowShipmentStatusChange');
	Route::post('/shipment/allowedShipmentStatuses', 'ShipmentController@allowedShipmentStatuses');

//Direct Shipment
	Route::get('/shipment/directShipmentList', 'ShipmentController@allDirectShipmentList');
	Route::post('/shipment/addDirectShipment', 'ShipmentController@storeDirectShipment');
	Route::post('/shipment/getDirectShipmentDetails', 'ShipmentController@getEditDirectShipmentList');
	Route::post('/shipment/getEditDirectShipmentList', 'ShipmentController@getEditDirectShipmentDetails');
	Route::post('/shipment/edit_DirectShipment', 'ShipmentController@editDirectShipmentDetails');
	Route::post('/shipment/create_Direct_shipment_box', 'ShipmentBoxController@createDirectShipmentBox');
	Route::post('/shipment/get_product', 'ShipmentController@getChannelProductDetails');

//Shipment Box
	Route::post('/shipment/createshipmentbox', 'ShipmentBoxController@createShipmentBox');
	Route::post('/shipment/getshipmentboxdetails', 'ShipmentBoxController@getShipmentBoxDetailsById');
	Route::post('/shipment/updateshipmentboxdetails', 'ShipmentBoxController@updateShipmentBoxDetails');
	Route::post('/shipment/createshipmentboxitems', 'ShipmentBoxController@createShipmentBoxItems');
	Route::post('/shipment/getShipmentboxitemsdetails', 'ShipmentBoxController@getShipmentBoxItemsDetailsById');
	Route::post('/shipment/deleteShipmentboxitemsdetails', 'ShipmentBoxController@deleteShipmentitm');


//Packing Slip Details
	Route::post('/packingSlip/packingSlipDetail', 'ShipmentController@showPackingSlipDetails');
});
