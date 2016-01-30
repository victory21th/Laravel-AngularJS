<!doctype html>
<!--[if lt IE 8]><html class="no-js lt-ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>FulFillDirect</title>
        <meta name="description" content="Responsive Admin Web App">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">       
        <!-- Needs images, font... therefore can not be part of main.css -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="bower_components/weather-icons/css/weather-icons.min.css">
        <!-- end Needs images -->
		<link rel="stylesheet" href="styles/ui-grid-unstable.css"/>
        <link rel="stylesheet" href="styles/main.css"/>	
		<link rel="stylesheet" href="styles/toastr.css"/>		
		<link rel="stylesheet" href="styles/ngDialog.css">
		<link rel="stylesheet" href="styles/ngDialog-theme-default.css">
		<link rel="stylesheet" href="styles/ngDialog-theme-plain.css">
		<link rel="stylesheet" href="styles/ngDialog-custom-width.css">	
		<link rel="stylesheet" href="styles/ngDialog.css">
		<link rel="stylesheet" href="styles/ngDialog.min.css">
		<link rel="stylesheet" href="styles/ngDialog-theme-default.css">
		<link rel="stylesheet" href="styles/ngDialog-theme-default.min.css">

		<meta name="csrf-token" ng-init='csrf_token = <?php echo csrf_token(); ?>'>

		
	</head>
    <body data-ng-app="app" id="app" class="app" data-custom-page="" data-off-canvas-nav="" data-ng-controller="AppCtrl" data-ng-class=" {'layout-boxed': admin.layout === 'boxed' } ">
        <!--[if lt IE 9]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
	

        <section data-ng-include=" 'templates/header.html' " id="header" class="header-container" data-ng-class=" {'header-fixed': admin.fixedHeader} " data-ng-controller="HeaderCtrl"></section>

        <div class="main-container">
            <aside data-ng-include=" 'templates/nav.html' " id="nav-container" class="nav-container" data-ng-class=" {'nav-fixed': admin.fixedSidebar, 'nav-horizontal': admin.menu === 'horizontal', 'nav-vertical': admin.menu === 'vertical'}">
            </aside>			
            <section id="content"  class="content-container ainmate-scale-up">
				<div class="panel panel-default">               
					<ol class="breadcrumb-alt" >
						<li ng-repeat="path in breadcrumb_array"><a href="{{path.url}}">{{path.name}}</a></li>
					</ol>              
				</div>
				<div ui-view="mainView"></div>
			</section>
			<!--<section ui-view="addView" id="content" class="content-container page {{ pageClass }}"></section>-->
			<section ui-view="addView" id="content" class="content-container ainmate-scale-up"></section>
			<section ui-view="editGrid" id="editGrid" class="content-container ainmate-scale-up"></section> 
			<section ui-view="ShowView" id="content" class="content-container ainmate-scale-up"></section>
        </div>	
		
        <script src="scripts/vendor.js"></script>
        <script src="scripts/bootstrap.min.js"></script>
		<script src="scripts/toastr.js"></script>
        <script src="scripts/ui.js"></script>
		<script src="scripts/pdfmake.min.js"></script>
		<script src="scripts/vfs_fonts.js"></script>
		<script src="scripts/ui-grid-unstable.js"></script>
		<script src="scripts/angular-ui-router.js"></script>
		<script src="scripts/utils-service.js"></script>
	    <script src="scripts/app.js"></script>
		<script src="scripts/constants.js"></script>
		<script src="scripts/ngDialog.js"></script>
		<script src="bower_components/angular-csv-import/dist/angular-csv-import.js"></script>
		
    </body>
</html>