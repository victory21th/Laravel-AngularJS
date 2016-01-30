/**
 * Created by fulfilldirect on 9/6/2015.
 */

$stateProvider
    .state('signinCtrl', {
        url: "/",
        views:{
            'mainView': {
                templateUrl: "templates/pages/signin.html",
                controller: "signinCtrl"
            }
        }
    })

    .state('dashboard', {
        url: "/dashboard",
        views:{
            'mainView': {
                templateUrl: "templates/dashboard.html",
                controller: "dashboardCtrl"
            }
        }
    })

    .state('inventorylist', {
        url: "/inventory/inventoryList",
        views:{
            'mainView': {
                templateUrl: "templates/inventory/gridData.html",
                controller: "inventoryListCtrl"
            }
        }
    })

    .state('productlist', {
        url: "/product/productlist",
        views:{
            'mainView': {
                templateUrl: "templates/product/gridData.html",
                controller: "productListCtrl"
            }
        }
    })

    .state('addProduct',{
        url: "/product/addProduct",
        views:{
            'addView':{
                templateUrl: "templates/product/addProduct.html",
                controller:	"addProductCtrl",
            }
        }
    })
    .state('showProduct',{
        url: "/product/showProduct/:id",
        views:{
            'addView': {
                templateUrl: "templates/product/showProduct.html",
                controller: "showProductCtrl"
            }
        }
    })

    .state('showInventory',{
        url: "/inventory/showInventory/:id",
        views:{
            'addView': {
                templateUrl: "templates/inventory/showInventory.html",
                controller: "showInventoryCtrl"
            }
        }
    })

    .state('newInventory',{
        url: "/inventory/addInventory",
        views:{
            'addView':{
                templateUrl: "templates/inventory/addInventory.html",
                controller:	"addInventoryCtrl",
            }
        }
    })

    .state('editInventory',{
        url: "/inventory/editInventory/:id",
        views:{
            'addView':{
                templateUrl: "templates/inventory/editInventory.html",
                controller:	"editInventoryCtrl",
            }
        }
    })

    .state('editProduct',{
        url: "/product/editProduct/:id",
        views:{
            'addView':{
                templateUrl: "templates/product/editProduct.html",
                controller:	"editProductCtrl",
            }
        }
    })

    .state('orderlist', {
        url: "/order/orderList",
        views:{
            'mainView': {
                templateUrl: "templates/order/gridData.html",
                controller: "orderListCtrl"
            }
        }
    })

    .state('neworderlist', {
        url: "/order/newOrderList",
        views:{
            'mainView': {
                templateUrl: "templates/order/gridData.html",
                controller: "newOrderListCtrl"
            }
        }
    })

    .state('inprogressorderlist', {
        url: "/order/inprogressOrderList",
        views:{
            'mainView': {
                templateUrl: "templates/order/gridData.html",
                controller: "inprogressOrderListCtrl"
            }
        }
    })

    .state('closedorderlist', {
        url: "/order/closedOrderList",
        views:{
            'mainView': {
                templateUrl: "templates/order/gridData.html",
                controller: "closedOrderListCtrl"
            }
        }
    })

    .state('bulkImportOrder',{
        url: "/order/bulkImportOrder",
        views:{
            'addView':{
                templateUrl: "templates/order/bulkImportOrder.html",
                controller:	"bulkImportOrderCtrl",
            }
        }
    })

    .state('newOrder',{
        url: "/order/addOrder",
        views:{
            'addView':{
                templateUrl: "templates/order/addOrder.html",
                controller:	"addOrderCtrl",
            }
        }
    })

    .state('showOrder',{
        url: "/order/showOrder/:id",
        views:{
            'addView': {
                templateUrl: "templates/order/showOrder.html",
                controller: "showOrderCtrl"
            }
        }
    })

    .state('showNewOrder',{
        url: "/order/showNewOrder/:id",
        views:{
            'addView': {
                templateUrl: "templates/order/showOrder.html",
                controller: "showOrderCtrl"
            }
        }
    })

    .state('showInprogressOrder',{
        url: "/order/showInprogressOrder/:id",
        views:{
            'addView': {
                templateUrl: "templates/order/showOrder.html",
                controller: "showOrderCtrl"
            }
        }
    })

    .state('ClosedOrderList',{
        url: "/order/closedOrderList/:id",
        views:{
            'addView': {
                templateUrl: "templates/order/showOrder.html",
                controller: "showOrderCtrl"
            }
        }
    })

    .state('editOrder',{
        url: "/order/editOrder/:id",
        views:{
            'addView':{
                templateUrl:"templates/order/editOrder.html",
                controller:	"editOrderCtrl",
            }
        }
    })

    .state('orderToShipmentList', {
        url: "/order/orderToShipmentList/:id",
        views:{
            'mainView': {
                templateUrl: "templates/order/gridOrderToShipmentDate.html",
                controller: "orderToShipmentListCtrl"
            }
        }
    })

    .state('startedShipmentList', {
        url: "/shipment/startedShipmentList",
        views:{
            'mainView': {
                templateUrl: "templates/shipment/gridData.html",
                controller: "startedShipmentListCtrl"
            }
        }
    })

    .state('directShipmentlist', {
        url: "/shipment/directShipmentList",
        views:{
            'mainView': {
                templateUrl: "templates/shipment/gridData.html",
                controller: "directShipmentListCtrl"
            }
        }
    })

    .state('addDirectShipment',{
        url: "/shipment/addDirectShipment",
        views:{
            'addView':{
                templateUrl: "templates/shipment/addDirectShipment.html",
                controller:	"addDirectShipmentCtrl",
            }
        }
    })

    .state('showDirectShipment',{
        url: "/shipment/showDirectShipment/:id",
        views:{
            'addView': {
                templateUrl: "templates/shipment/showDirectShipment.html",
                controller: "showDirectShipmentCtrl"
            }
        }
    })

    .state('showDirectPackingSlip',{
        url: "/shipment/showDirectPackingSlip/:id",
        views:{
            'addView': {
                templateUrl: "templates/shipment/showDirectPackingSlip.html",
                controller: "showDirectPackingSlipCtrl"
            }
        }
    })

    .state('showOrderPackingSlip',{
        url: "/shipment/showOrderPackingSlip/:id",
        views:{
            'addView': {
                templateUrl: "templates/shipment/showPackingSlips.html",
                controller: "showOrderPackingSlipCtrl"
            }
        }
    })

    .state('editDirectShipment',{
        url: "/shipment/editDirectShipment/:id",
        views:{
            'addView':{
                templateUrl: "templates/shipment/editDirectShipment.html",
                controller:	"editDirectShipmentCtrl",
            }
        }
    })

    .state('createshipmentbox', {
        url: "/shipment/createshipmentbox/:id",
        views:{
            'mainView': {
                templateUrl: "templates/shipment/createshipmentbox.html",
                controller: "createShipmentBoxCtrl"
            }
        }
    })

    .state('createDirectShipmentbox', {
        url: "/shipment/createDirectShipmentbox/:id",
        views:{
            'mainView': {
                templateUrl: "templates/shipment/createDirectShipmentbox.html",
                controller: "createDirectShipmentBoxCtrl"
            }
        }
    })

    .state('showReadyShipmentList', {
        url: "/shipment/showReadyShipmentList/:id",
        views:{
            'addView': {
                templateUrl: "templates/shipment/showShipment.html",
                controller: "showShipmentCtrl"
            }
        }
    })

    .state('newShipment',{
        url: "/shipment/addShipment/:id",
        views:{
            'addView':{
                templateUrl: "templates/shipment/addShipment.html",
                controller:	"addShipmentCtrl",
            }
        }
    })

    .state('showShipment',{
        url: "/shipment/showShipment/:id",
        views:{
            'addView': {
                templateUrl: "templates/shipment/showShipment.html",
                controller: "showShipmentCtrl"
            }
        }
    })

    .state('showOrderShipment',{
        url: "/shipment/showOrderShipment/:id",
        views:{
            'addView': {
                templateUrl: "templates/shipment/showShipment.html",
                controller: "showShipmentCtrl"
            }
        }
    })

    .state('showPartialShipment',{
        url: "/shipment/showPartialShipment/:id",
        views:{
            'addView': {
                templateUrl: "templates/shipment/showPartialShipment.html",
                controller: "showPartialShipmentCtrl"
            }
        }
    })

    .state('editShipment',{
        url: "/shipment/editShipment/:id",
        views:{
            'addView':{
                templateUrl: "templates/shipment/editShipment.html",
                controller:	"editShipmentCtrl",
            }
        }
    })

    .state('showDirectShipmentBoxItems',{
        url: "/shipment/showDirectShipmentBoxItems/:id",
        views:{
            'addView': {
                templateUrl: "templates/shipment/showDirectShipmentBoxItems.html",
                controller: "showDirectShipmentBoxItemsCtrl"
            }
        }

    })

    .state('editshipmentbox',{
        url: "/shipment/editshipmentbox/:id",
        views:{
            'addView':{
                templateUrl: "templates/shipment/editDirectShipmentBoxItem.html",
                controller:	"editDirectShipmentBoxCtrl",
            }
        }
    })

    .state('editShipmentBoxItem',{
        url: "/shipment/editShipmentBoxItem/:id",
        views:{
            'addView':{
                templateUrl: "templates/shipment/editShipmentBoxItem.html",
                controller:	"editShipmentBoxItemCtrl",
            }
        }
    });
