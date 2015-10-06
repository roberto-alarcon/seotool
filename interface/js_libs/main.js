
// Variables Globales //
var site;
var reporte_id = 0;
var detail_grid = null;

var dhxLayout;
var dhxTree_PROJEC;

var menuToolBar = function(){
				
    var session_group = 5;
    var toolbar = new dhtmlXToolbarObject("toolbarObj");
    toolbar.setIconsPath("./menu/imgs/");
                                            
    toolbar.addText("info", 25, "Televisa SEO Tool 1.0v"); 
    toolbar.addSeparator('sep_1', 2);													
    buffer_toolbar = toolbar;
  					
}

var viewInterface = function(){

    document.getElementById("a_tabbar").innerHTML = "";
    
    tabbar = new dhtmlXTabBar("a_tabbar", "top");
    tabbar.setSkin('dhx_skyblue');
    tabbar.setImagePath("./dhtmlx/dhtmlxTabbar/codebase/imgs/");
    tabbar.addTab("a1", "SEO Editorial", "100px");
    tabbar.addTab("a2", "Herramientas", "100px");
    tabbar.setTabActive("a1");

    dhxLayout = tabbar.cells("a1").attachLayout("2U");
    dhxLayout.cells("a").setText("Verticales / Sitios"); 
    dhxLayout.cells("b").hideHeader();
    dhxLayout.cells("a").setWidth(200);
    
    
    // Cargamos el arbol de sitios
    var dhxTree_site = dhxLayout.cells("a").attachTree();
    dhxTree_site.setImagePath("./dhtmlx/dhtmlxTree/codebase/imgs/");
    dhxTree_site.loadXML("./js_menu/tree.xml?rand=123");
    
    dhxTree_site.attachEvent("onClick",function(id){
         
         switch (id) {
            
            case 'http://www2.esmas.com/entretenimiento/musica':
            case 'http://www2.esmas.com/entretenimiento/cine':
            case 'http://www2.esmas.com/entretenimiento/farandula':
            case 'http://www2.esmas.com/mujer':
            case 'http://www2.esmas.com/salud':
            case 'http://noticieros.televisa.com':
            case 'http://deportes.televisa.com':
            case 'http://www.televisa.com/canal5':
            case 'http://www2.esmas.com/salud/enfermedades':
            case 'http://www.televisa.com':
            case 'http://especiales.televisa.com':
            case 'http://www.televisa.com/programas-tv':
            	
            // Incluimos rutas de fotogalerias
            case 'http://noticieros.televisa.com/fotos':
            case 'http://deportes.televisa.com/fotogalerias':
            case 'http://television.televisa.com/fotos':
            case 'http://espectaculos.televisa.com/fotos':
            case 'http://estilodevida.televisa.com/fotos':
                
            // Nuevas rutas 27-08-15
            case 'http://www.televisa.com/sala-de-prensa':
            case 'http://television.televisa.com/programas-tv/la-rosa-de-guadalupe':
            case 'http://television.televisa.com/programas-tv/hoy':
            case 'http://estilodevida.televisa.com':
            case 'http://espectaculos.televisa.com':
                
            // Nuevas rutas 02-10-15
            case 'http://television.televisa.com/telenovelas/amor-de-barrio':
            case 'http://television.televisa.com/telenovelas/la-vecina':
            case 'http://television.televisa.com/telenovelas/a-que-no-me-dejas':
            case 'http://television.televisa.com/telenovelas/antes-muerta-que-lichita':
            case 'http://television.televisa.com/telenovelas/lo-imperdonable':
            	
            	site = id;
            	
            	dhxLayout_reporte = dhxLayout.cells("b").attachLayout("2U");
            	dhxLayout_reporte.cells("a").setText("Reportes");
            	dhxLayout_reporte.cells("a").setWidth(230);
            	dhxLayout_reporte.cells("b").hideHeader();
            	
            	// MENU ARRIBA DEL ARBOL
            	var CELDA_ARBOL = dhxLayout_reporte.cells('a');
            	var toolbar_CELDA_ARBOL = CELDA_ARBOL.attachToolbar();
            	toolbar_CELDA_ARBOL.setIconsPath("js_menu/imgs/");
            	toolbar_CELDA_ARBOL.addSeparator('sep_pagging', 1);
            	toolbar_CELDA_ARBOL.addButton('btn_newReport',2,'Nuevo','new.gif','new.gif');
            	toolbar_CELDA_ARBOL.addSeparator('sep_pagging3',3);
            	toolbar_CELDA_ARBOL.addButton('btn_deleteReport',4,'Borrar','delete.png','delete.png');
            	
            	toolbar_CELDA_ARBOL.attachEvent("onClick", function(id){ 
					console.log(id);
            		
            		if(id == "btn_newReport"){ 
						openWindowNewReport();						
					}
					
					
					if( id == "btn_deleteReport" ){
						
						if(reporte_id != 0 ){
						
							if (confirm("Estas seguro de borrar el registo ? - ID " + reporte_id )){
								
								
								// Ajax para borrar
								
								var params = 'reporte_id='+reporte_id;
								
								
								dhtmlxAjax.post('./ajax/deleteReport.php',params,function(loader){
									
									var values = JSON.parse(loader.xmlDoc.responseText);
									if(values.result == "true"){
										dhxTree_PROJECT.deleteChildItems(0);
										dhxTree_PROJECT.loadXML("./ajax/treeReport.php?site="+site+"&para=123");
										dhxLayout_reporte.cells("b").detachObject(true);
										
									}else{
										
										alert('Hubo un problema al borrar la solicitd, por favor vuelve a intentarlo');
										
									}
									
						                
						        });
								
								
							}
							
						}else{
							
							alert('Es necesario seleccionar un reporte'); 
							
						}
						
					}
					
            	});
            	
            	
            	
            	
            	// ARBOL ADMINISTRADOR DEL PROYECTO
            	dhxTree_PROJECT = dhxLayout_reporte.cells("a").attachTree();
            	dhxTree_PROJECT.setImagePath("./dhtmlx/dhtmlxTree/codebase/imgs/");
            	dhxTree_PROJECT.loadXML("./ajax/treeReport.php?site="+site+"&para=123",function(id){
            	dhxTree_PROJECT.openAllItems('root');
            		
            	});
            	
            	dhxTree_PROJECT.attachEvent("onClick",function(id){
            		
            		if(id != 'root'){
            			
                		reporte_id = id;
            			var dhxTabbar = dhxLayout_reporte.cells("b").attachTabbar();
                        dhxTabbar.setImagePath("./dhtmlx/dhtmlxTabbar/codebase/imgs/");
                        dhxTabbar.setHrefMode("iframes-on-demand");
                        dhxTabbar.addTab("tab1", "Dashboard", "120px");
                       
                        dhxTabbar.addTab("tab2", "Titulos", "120px");
                        dhxTabbar.addTab("tab3", "Descripciones", "120px");
                        dhxTabbar.addTab("tab4", "Densidad", "120px");
                        dhxTabbar.addTab("tab5", "Errores 404", "120px");
                        dhxTabbar.setTabActive("tab1");
                        dhxTabbar.setContentHref("tab1","./ajax/dashborad_dispatcher.php?id="+id);
                        
                        
                        // TITULOS
                        var dhxToolbarTitle = dhxTabbar.cells("tab2").attachToolbar();
                        dhxToolbarTitle.setIconsPath("./js_menu/imgs/");
                        dhxToolbarTitle.addSeparator('sep_pagging', 1);
                        dhxToolbarTitle.addButton('btn_shortTitle',2,'Titulos Cortos','text_document.gif','text_document.gif');
                        dhxToolbarTitle.addButton('btn_longTitle',3,'Titulos Largos','page_range.gif','page_range.gif');
                        dhxToolbarTitle.addButton('btn_doubleTitle',4,'Titulos Duplicados','copy.gif','copy.gif');
                        dhxToolbarTitle.addButton('btn_exportTitle',4,'Exportar','save.gif','save_dis.gif');
                        
						// AGREGAMOS EVENTOS A LA BARRA DE BOTONES
                        dhxToolbarTitle.attachEvent("onClick", function(event_id){ 
        					
                        	var type = 'title';
                        	var action = 'small';
                        	
                        	
                        	if(event_id == 'btn_doubleTitle' ){
                        		detail_grid = 'double_title';
                        		
                        		//dhxTabbar.cells("tab2").attachGrid();
                        		dhxLayout_double = dhxTabbar.cells("tab2").attachLayout("2U");
                        		dhxLayout_double.cells("b").hideHeader();
                        		dhxLayout_double.cells("a").hideHeader();
                        		dhxLayout_double.cells("a").setWidth(330);
                        		
                        		dhxTree_double = dhxLayout_double.cells("a").attachTree();
                        		dhxTree_double.setImagePath("./dhtmlx/dhtmlxTree/codebase/imgs/");
                        		dhxTree_double.loadXML("./ajax/doubleTitle.php?id="+id,function(id){
                        			dhxTree_double.openAllItems('root');
                        		});
                        		
                        		dhxTree_double.attachEvent("onClick",function(tree_id_event){
                        			
                        			
                        			 var gridTitle = dhxLayout_double.cells("b").attachGrid();
    	                             gridTitle.setImagePath("./dhtmlx/dhtmlxGrid/codebase/imgs/"); 
    	                             gridTitle.setHeader("URL");
    	                             gridTitle.setInitWidths("*");
    	                             gridTitle.setColTypes("link");
    	                             gridTitle.init();
    	                             gridTitle.loadXML("./ajax/gridDoubleTitle.php?id="+id+"&identify="+tree_id_event);
                        			
                        			
                        		});
                        		
                        		
                        		
                        	}else if( event_id == 'btn_exportTitle' ){
                        		
                        		if(detail_grid != null){
                   			 		console.log('ajax/excel_export.php?id_Report='+reporte_id+'&detail_grid='+detail_grid);
                   			 		window.open('ajax/excel_export.php?id_Report='+reporte_id+'&detail_grid='+detail_grid, "_blank");
                        		}else{
                        			alert('Es necesario seleccionar un tipo de consulta');
                        			
                        		}
                   			
                        		
                        	}else{
                        	
                        	
	                        	switch(event_id){
	                        		case "btn_shortTitle":var type = 'title';
	                        			type = 'title';
	                        			action = 'small';
	                        			detail_grid = 'small_title';
	                        			
	                        			break;
	                        		case "btn_longTitle":
	                        			type = 'title';
	                        			action = 'long';
	                        			detail_grid = 'long_title';
	                        			break;
	                        	
	                        	
	                        	
	                        	}
	                        	
	                        	
	                        	 var gridTitle = dhxTabbar.cells("tab2").attachGrid();
	                             gridTitle.setImagePath("./dhtmlx/dhtmlxGrid/codebase/imgs/"); 
	                             gridTitle.setHeader("URL, Titulo, No. de palabras,Fecha publicacion");
	                             gridTitle.setInitWidths("350,200,100,*");
	                             gridTitle.setColTypes("link,ro,ro,ro");
	                             gridTitle.init();
	                             gridTitle.loadXML("./ajax/grid.php?id="+id+"&type="+type+"&action="+action);
                        	}
	
        					
                    	});
						
                        
                       
                        
                        
                        
                        // DESCRIPCIONS
                       
                        var dhxToolbarDescription = dhxTabbar.cells("tab3").attachToolbar();
                        dhxToolbarDescription.setIconsPath("./js_menu/imgs/");
                        dhxToolbarDescription.addSeparator('sep_pagging', 1);
                        dhxToolbarDescription.addButton('btn_smallDescription',2,'Descripciones Cortas','text_document.gif','text_document.gif');
                        dhxToolbarDescription.addButton('btn_longDescription',3,'Descripciones Largas','page_range.gif','page_range.gif');
                        dhxToolbarDescription.addButton('btn_doubleDescription',4,'Descripciones Duplicadas','copy.gif','copy.gif');
                        dhxToolbarDescription.addButton('btn_exportDescription',5,'Exportar','save.gif','save_dis.gif');
                        
                        dhxToolbarDescription.attachEvent("onClick", function(event_id){ 
                        	
                        	var type = 'description';
                        	var action = 'small';
                        	
                        	if( event_id == 'btn_exportDescription' ){
                        		
                        		console.log('ajax/excel_export.php?id_Report='+reporte_id+'&detail_grid='+detail_grid); 
                        		window.open('ajax/excel_export.php?id_Report='+reporte_id+'&detail_grid='+detail_grid, "_blank");
                        		
                        	}else{
                        	
                        	
	                        	switch(event_id){
	                        		case "btn_smallDescription":
	                        			
	                        			action = 'small';
	                        			detail_grid = 'small_description';
	                        			
	                        			break;
	                        		case "btn_longDescription":
	                        			action = 'long';
	                        			detail_grid = 'long_description';
	                        			break;
	                        			
	                        		case "btn_doubleTitle":
	                        			alert('titulos dobles');
	                        			break;
	                        			
	                        		
	                        			
	                        		
	                        	
	                        	
	                        	}
                        	
                        	
	                        var gridDescription = dhxTabbar.cells("tab3").attachGrid();
                            gridDescription.setImagePath("./dhtmlx/dhtmlxGrid/codebase/imgs/"); 
                            gridDescription.setHeader("URL, Description, No. de palabras,Fecha publicacion");
                            gridDescription.setInitWidths("350,200,100,*");
                            gridDescription.setColTypes("link,ro,ro,ro");
                            gridDescription.init();
                            gridDescription.loadXML("./ajax/grid.php?id="+id+"&type="+type+"&action="+action);
                        	
                        	
                        	}
                            
                        });
                        
                        
            			
            		}
            		
                    
            		
            		
            		
            	});
            	
            	
            	
                
                
                            
                break;
            
            
            
         }
         
         
         
         
         return true;
    });
  

}

var openWindowNewReport = function(){
	
	var formModel = [{
		type: "fieldset",
		label: "Agregar nuevo reporte:",
		inputWidth: 320,
		list: [ 
						{type: "calendar", name:'start_date', label: "Fecha inicial", skin: "dhx_skyblue", dateFormat: "%Y-%m-%d"},
						{type: "calendar", name:'end_date', label: "Fecha final&nbsp;&nbsp;",   skin: "dhx_skyblue", dateFormat: "%Y-%m-%d"},
						{type: "newcolumn"}, 
						{
							type: "button",
							name:"cancel",
							value: "Cancelar"
						}, 
						{
							type: "newcolumn"
						}, 
						{
							type: "button",
							name:"save",
							value: "Guardar"
						}
		]}];
	
	var idwindow_chief = 'windowNewReport';
	var dhxWins= new dhtmlXWindows(); 					
	dhxWins.setImagePath("./dhtmlx/dhtmlxWindows/codebase/imgs/");
	var win = dhxWins.createWindow(idwindow_chief, 50, 50, 350, 160);
	dhxWins.window(idwindow_chief).centerOnScreen(); 
	dhxWins.window(idwindow_chief).setText("Nuevo reporte");
	dhxWins.window(idwindow_chief).setModal(true);
	
	formModell = win.attachForm(formModel);
	
	
	formModell.attachEvent("onButtonClick", function(name, command){
		if(name == "save"){
			
			var start_txt 	= this.getItemValue("start_date").toString();
			var end_txt		= this.getItemValue("end_date").toString();
			
			
			var start_txt 	= formModell.getItemValue("start_date",true);
			var end_txt		= formModell.getItemValue("end_date",true);
			
			
			var params = 'start='+start_txt+'&end='+end_txt+'&site='+site;
			
			
			dhtmlxAjax.post('./ajax/addReport.php',params,function(loader){
				
				var values = JSON.parse(loader.xmlDoc.responseText);
				if(values.result == "true"){
					win.close();
					dhxTree_PROJECT.deleteChildItems(0);
					dhxTree_PROJECT.loadXML("./ajax/treeReport.php?site="+site+"&para=123");
				}else{
					win.close();
					alert('Hubo un problema al realizar la solicitd, por favor vuelve a intentarlo');
					
				}
				
	                
	        });
			
			
		}
		
		if(name == "cancel"){
			win.close();
		}
		
	});
	
}


var loadInterface = function(){
    menuToolBar();viewInterface();
    
}

