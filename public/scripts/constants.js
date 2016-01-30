(function() {
    'use strict'

    var Constants = angular.module('Constants', []);

	Constants.constant('Messages', {
        Authentication: {
            Invalid: 'Invalid Credentials',
            Success: 'Successfully Signed In'
        },
		Sigup: {
            Invalid: 'Mail id Already Exist',
            Success: 'Registered Successfully',
			Error : 'Not Able to Sigup'
        },
		 Inventory: {
            Success: 'Inventory successfully saved',
			Error: 'Inventory Not Saved',
		},
		InventoryEdit: {
            Success: 'Inventory updated successfully',
			Error: 'Inventory Not Updated',
        },
		InventoryDelete: {
            Success: 'Inventory Deleted successfully',
			Error: 'Inventory Not Deleted',
        },
		Product: {
            Success: 'Product successfully saved',
			Error: 'Product Not Saved',
		},
		ProductEdit: {
            Success: 'Product updated successfully',
			Error: 'Product Not Updated',
        },
		ProductDelete: {
            Success: 'Product Deleted successfully',
			Error: 'Product Not Deleted',
        },
        Order: {
            Success: 'Order successfully saved',
			Error: 'Order Not Saved',
		},
		OrderEdit: {
            Success: 'Order updated successfully',
			Error: 'Order Not Updated',
        },
		OrderDelete: {
            Success: 'Order Deleted successfully',
			Error: 'Order Not Deleted',
        },
		Shipments: {
            Success: 'Shipments successfully saved',
			Error: 'Shipments Not Saved',
		},
		ShipmentsEdit: {
            Success: 'Shipments updated successfully',
			Error: 'Shipments Not Updated',
        },
		ShipmentsDelete: {
            Success: 'Shipments Deleted successfully',
			Error: 'Shipments Not Deleted',
        },
		DirectShipments: {
            Success: 'Direct Shipments successfully saved',
			Error: 'Direct Shipments Not Saved',
		},
		DirectShipmentsEdit: {
            Success: 'Direct Shipments updated successfully',
			Error: 'Direct Shipments Not Updated',
        },
		DirectShipmentsDelete: {
            Success: 'Direct Shipments Deleted successfully',
			Error: 'Direct Shipments Not Deleted',
        },
		
		ShipmentsBoxCreation: {
            Success: 'Shipments Box successfully Created',
			Error: 'Shipments Box Not Saved',
		},
		ShipmentsBoxEdit: {
            Success: 'Shipments Box updated successfully',
			Error: 'Shipments Box Not Updated',
        },
		ShipmentsBoxDelete: {
            Success: 'Shipments Box Deleted successfully',
			Error: 'Direct Shipments Not Deleted',
        },
		
		       
    });	
	
	Constants.constant('ToastOptions', {
        "timeOut": "4000",
		"positionClass": "toast-top-center",
    });
})();