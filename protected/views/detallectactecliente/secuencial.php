<?php
$idctacte=$_GET['id'];
$nombre=$_GET['nombre'];
$this->menu=array(
	array(
		'label'=>'Ctas. Ctes. Cliente', 
		'url'=>Yii::app()->createUrl('ctactecliente/admin'),
	),
	array(
		'label'=>'Vista filtrada', 
		'url'=>Yii::app()->createUrl('detallectactecliente/admin',array("id"=>$idctacte,"nombre"=>$nombre) ),
	),
	array(
		'label'=>'Nueva Cobranza', 
		'url'=>Yii::app()->createUrl("cobranza/create")
		),
	array(
		'label'=>'Nueva Nota Crédito', 
		'url'=>Yii::app()->createUrl("notacredito/create")
		),	
	array(
		'label'=>'Nueva Nota Débito', 
		'url'=>Yii::app()->createUrl("notadebito/create")
		),
	
);
?>
<h5 class="well well-small">CTA. CTE. - CLIENTE - <?php echo $nombre;?></h5>
<br>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", 
array("color" => TbHtml::LABEL_COLOR_SUCCESS)),
array('Excel','mesTab'=>'08',
			  'anioTab'=>'2014',
			  'idctactecliente'=>$idctacte,
			  'nombre'=>$nombre,
			  'caso'=>1),
'Exportar',
array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php
$datos= $model->generarGrillaSaldos_secuencial($idctacte,'2014','08',1)->data;
$cant=count($datos);
			$datos=new CArrayDataProvider($datos, array(
				    'keyField'=>'iddetallectactecliente',
				    'sort'=>array(
				        'attributes'=>array(
				           'iddetallectactecliente','fecha', 'descripcion',
				        ),
				        
				    ),
				    'pagination'=>array(
				        'pageSize'=>40,
				    ),
				));
$columnas=array(
		array(
	    	'value'=>'$this->grid->dataProvider->pagination->currentPage*
	        $this->grid->dataProvider->pagination->pageSize + $row+1',
	        'htmlOptions'=>array('style'=>'text-align:center;width:30px;'),
        ),
		array('name' => 'fecha',
					'header' => 'FECHA',
					'htmlOptions' => array('width' =>'60px'),
			'filter'=>false,
		),
		array('name' => 'descripcion',
					'header' => 'DESCRIPCION',
					'htmlOptions' => array('width' =>'250px'),
								
					),
		array('name' => 'tipo',
					'header' => 'TIPO',
					'htmlOptions' => array('width' =>'10%',
										   'style'=>'padding-right:0px'),
					'value'=>array($this,'labelTipo'),
			 ),
       	array(
              		'header'=>'DEBE',
              		//'name' => 'debe',
					'htmlOptions' => array('width' =>'85px'),
              		'cssClassExpression' => '$data["debe"] > 0 ? "colorDebe": ""',
					'value'=>'($data["debe"] !== null && $data["debe"] > 0)?number_format($data["debe"], 2, ".", ","): "-"',
              		//'footer'=>"Saldo: $ ".number_format($dataProviderDebeHaber[0]['total_debe']-$dataProviderDebeHaber[0]['total_haber'],2,".",","),
              		'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:center;font-weight:bold;'),
        ),
        array(
			  		'header'=>'HABER',
			  		//'name' => 'haber',
					'htmlOptions' => array('width' =>'75px'),
              		'cssClassExpression' => '$data["haber"] > 0 ? "colorHaber": ""',
			  		'value'=>'($data["haber"] !== null && $data["haber"] > 0)?number_format($data["haber"], 2, ".", ","): "-"',
        ),
         array(
			  		'header'=>'Saldo',
			  		//'name' => 'saldo',
					'htmlOptions' => array('width' =>'75px'),
              		//'cssClassExpression' => '$data["haber"] > 0 ? "colorHaber": ""',
			  		'value'=>'($data["saldo"] !== null && $data["saldo"] > 0)?number_format($data["saldo"], 2, ".", ","): number_format($data["saldo"], 2, ".", ",")',
        ),
       array(
        	'header'=>'Opciones',
        	'headerHtmlOptions'=>array('colspan'=>2),
        	'htmlOptions' => array('colspan'=>2,'width'=>'12%'),
        	'footerHtmlOptions'=>array('colspan'=>2),
			'class'=>'bootstrap.widgets.TbButtonColumn',
        	'deleteConfirmation'=>'Seguro que quiere eliminar el elemento?',
			'template'=>'{update}{updatefact}{delete}{deletecobranza}{actNC}{actND}{borrarND}{borrarNC}',
			'buttons' => array(
				'update'=>array(
					'label'=>'Modificar Cobranza',
	                    //'icon'=>TbHtml::ICON_MINUS_SIGN,
	                    'visible'=>'$data["tipo"] == 1',
						'url'=> 'Yii::app()->createUrl("cobranza/update",
								 array(	"id"=>$data["cobranza_idcobranza"],
								 		"idctacte"=>$data["ctactecliente_idctactecliente"],
								 		"nombre"=>$data["cliente"],
								 		))',
						
	                  ),
	            'updatefact'=>array(
					'label'=>'Modificar Factura',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data["tipo"] == 0',
						'url'=> 'Yii::app()->createUrl("factura/update",
								 array(	"id"=>$data["factura_idfactura"],
								 		
								 		))',
						
	                  ),
				'delete'=>array(
	                  	'label'=>'Borrar Factura',
	                    //'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data["tipo"] == 0',
	                  	'url'=>'Yii::app()->createUrl("factura/borrar", array("id"=>$data["factura_idfactura"]))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de borrar la Factura?',
		                  		'ajax' => array(
		                            'type' => 'POST',
		                            'url' => "js:$(this).attr('href')",
		                  			'error'=>'function(jqXHR ,textStatus,errorThrown){alert(jqXHR.responseText);}',
		                            'success' => 'function(data){
	                                	if(data == "true"){
		                                    location.reload();
		                                  alert("Fue borrada con éxito!");
		                                  return false;
	                                	} else {
	                                		   //location.reload();
	                                		alert("No pudo borrarse.");
	                                		return false;
	                                	} 
	                                }',
	                  			),	
		                  	),
		              	),
	            
	            'deletecobranza'=>array(
					'label'=>'Borrar Cobranza',
	                    'icon'=>TbHtml::ICON_TRASH,
	                    'visible'=>'$data["tipo"] == 1',
						'url'=> '$this->grid->controller->createUrl("cobranza/delete",
								 array("id"=>$data["cobranza_idcobranza"]))',
	                   'options'=>array('class'=>'delete',
	                  		/*	'ajax'=>array(
                                        'type'=>'GET',
                                        'url'=>"js:$(this).attr('href')",
                                        'success'=>'js:function(result){
                                                alert(result);
                                        }',
                               		 ),*/
	                 			 ),
						
	                  ),
	             'actNC'=>array(
						'label'=>'Modificar Nota Crédito',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data["notacredito_idnotacredito"] != NULL',
						'url'=> 'Yii::app()->createUrl("notacredito/update",
								 array(	"id"=>$data["notacredito_idnotacredito"],
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
				  'borrarNC'=>array(
	                  	'label'=>'Borrar Nota Crédito ',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data["notacredito_idnotacredito"] != NULL',
	                  	'url'=>'Yii::app()->createUrl("notacredito/borrar", array("id"=>$data["notacredito_idnotacredito"]))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de borrar la Nota de crédito?',
		                  		'ajax' => array(
		                            'type' => 'POST',
		                            'url' => "js:$(this).attr('href')",
		                  			'error'=>'function(jqXHR ,textStatus,errorThrown){alert(jqXHR.responseText);}',
		                            'success' => 'function(data){
	                                	if(data == "true"){
		                                    location.reload();
		                                  alert("Fue borrada con éxito!");
		                                  return false;
	                                	} else {
	                                		   //location.reload();
	                                		alert("No pudo borrarse.");
	                                		return false;
	                                	} 
	                                }',
	                  			),	
		                  	),
		              	),
		         'actND'=>array(
						'label'=>'Modificar Nota Débito',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data["notadebito_idnotadebito"] != NULL',
						'url'=> 'Yii::app()->createUrl("notadebito/update",
								 array(	"id"=>$data["notadebito_idnotadebito"],
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
				  'borrarND'=>array(
	                  	'label'=>'Borrar Nota Débito',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data["notadebito_idnotadebito"] != NULL',
	                  	'url'=>'Yii::app()->createUrl("notadebito/borrar", array("id"=>$data["notadebito_idnotadebito"]))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de borrar la Nota de débito?',
		                  		'ajax' => array(
		                            'type' => 'POST',
		                            'url' => "js:$(this).attr('href')",
		                  			'error'=>'function(jqXHR ,textStatus,errorThrown){alert(jqXHR.responseText);}',
		                            'success' => 'function(data){
	                                	if(data == "true"){
		                                    location.reload();
		                                  alert("Fue borrada con éxito!");
		                                  return false;
	                                	} else {
	                                		   //location.reload();
	                                		alert("No pudo borrarse.");
	                                		return false;
	                                	} 
	                                }',
	                  			),	
		                  	),
		              	),
		),
		),
	);
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	//'id'=>'detallectactecliente-grid',
	'dataProvider'=>$datos,
	//'filter'=>$datos,
	'columns'=>$columnas,
	'template' => "{items}{pager}",
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
)); ?>