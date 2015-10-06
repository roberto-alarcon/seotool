<?php
include_once("../config.php");

?>
	<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>		
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Sistema SEO </title>
    
    <!-- Incluimos las librerias -->
    
    <!-- TabBar -->
        <link rel="STYLESHEET" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxTabbar/codebase/dhtmlxtabbar.css">
        <script src="<?php echo URL_DXTMLX;?>dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
        <script src="<?php echo URL_DXTMLX;?>dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
        <script src="<?php echo URL_DXTMLX;?>dhtmlxTabbar/codebase/dhtmlxcontainer.js"></script>
    
    <!-- Grid -->
	<script src="<?php echo URL_DXTMLX;?>dhtmlxGrid/codebase/dhtmlxgrid.js"></script>
	<script src="<?php echo URL_DXTMLX;?>dhtmlxGrid/codebase/dhtmlxgridcell.js"></script>
	<script  src="<?php echo URL_DXTMLX;?>dhtmlxGrid/codebase/excells/dhtmlxgrid_excell_link.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxGrid/codebase/dhtmlxgrid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxGrid/codebase/skins/dhtmlxgrid_dhx_skyblue.css">
                                                                                                                     
    <!-- LayOut -->
	<script src="<?php echo URL_DXTMLX;?>dhtmlxLayout/codebase/dhtmlxlayout.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxLayout/codebase/dhtmlxlayout.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxLayout/codebase/skins/dhtmlxlayout_dhx_skyblue.css">
        
    <!-- Tree -->
	<link rel="STYLESHEET" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxTree/codebase/dhtmlxtree.css">
	<script  src="<?php echo URL_DXTMLX;?>dhtmlxTree/codebase/dhtmlxtree.js"></script>
        
    <!-- Menu Bar -->
	<script src="<?php echo URL_DXTMLX;?>dhtmlxToolbar/codebase/dhtmlxtoolbar.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxToolbar/codebase/skins/dhtmlxtoolbar_dhx_skyblue.css"></link>
	
    <!-- Window -->
	<link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxWindows/codebase/dhtmlxwindows.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxWindows/codebase/skins/dhtmlxwindows_dhx_skyblue.css">
	<script src="<?php echo URL_DXTMLX;?>dhtmlxWindows/codebase/dhtmlxwindows.js"></script>
	
    <!-- Formularios -->
	<script src="<?php echo URL_DXTMLX;?>dhtmlxForm/codebase/dhtmlxform.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxForm/codebase/skins/dhtmlxform_dhx_skyblue.css">
	<script src="<?php echo URL_DXTMLX;?>dhtmlxForm/codebase/ext/dhtmlxform_item_calendar.js"></script>
	<script src="<?php echo URL_DXTMLX;?>dhtmlxForm/codebase/ext/dhtmlxform_item_upload.js"></script>
	<script src="<?php echo URL_DXTMLX;?>dhtmlxForm/codebase/ext/dhtmlxform_item_editor.js"></script>
	<script src="<?php echo URL_DXTMLX;?>dhtmlxForm/codebase/ext/dhtmlxform_item_combo.js"></script>
	<script src="<?php echo URL_DXTMLX;?>dhtmlxForm/codebase/ext/dhtmlxform_dyn.js"></script>	
    <script src="<?php echo URL_DXTMLX;?>dhtmlxForm/codebase/ext/swfobject.js"></script>
    
    <!--Calendar -->
	<link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxCalendar/codebase/dhtmlxcalendar.css"></link>
	<link rel="stylesheet" type="text/css" href="<?php echo URL_DXTMLX;?>dhtmlxCalendar/codebase/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
	<script src="<?php echo URL_DXTMLX;?>dhtmlxCalendar/codebase/dhtmlxcalendar.js"></script>
	
    
    <script src="<?php echo URL_JS_LIBS;?>main.js?rand=<?php echo time()?>"></script>
    
    <style>
        
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			overflow: hidden;
		}
    </style>
    
    </head>
    
    <body style="background:#E3EFFF;" onload="loadInterface();">
		
		<div id="toolbarObj">Aqui va el Menu</div>		
		<div id="a_tabbar" style="width:100%; height:100%;"/>
		
    </body>
    
   
		
    
    