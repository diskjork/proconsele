<?php
$idctacte=$_GET['id'];
$nombre=$_GET['nombre'];
$this->menu=array(
	array(
		'label'=>'Ctas. Ctes. Proveedor', 
		'url'=>Yii::app()->createUrl('ctacteprov/admin'),
	),
	array(
		'label'=>'Vista filtrada', 
		'url'=>Yii::app()->createUrl('detallectacteprov/admin',array("id"=>$idctacte,"nombre"=>$nombre) ),
	),
	array(
		'label'=>'Nueva ordendepago', 
		'url'=>Yii::app()->createUrl("ordendepago/create")
		),
	array(
		'label'=>'Nueva Nota Crédito', 
		'url'=>Yii::app()->createUrl("notacreditoprov/create")
		),	
	array(
		'label'=>'Nueva Nota Débito', 
		'url'=>Yii::app()->createUrl("notadebitoprov/create")
		),
	
);
?>
<h5 class="well well-small">CTA. CTE. - PROVEEDOR - <?php echo $nombre;?></h5>
<br>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", 
array("color" => TbHtml::LABEL_COLOR_SUCCESS)),
array('Excel','mesTab'=>'08',
			  'anioTab'=>'2014',
			  'idctacteprov'=>$idctacte,
			  'nombre'=>$nombre,
			  'caso'=>1),
'Exportar',
array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php
$datos= $model->generarGrillaSaldos_secuencial($idctacte,'2014','08',1)->data;
$cant=count($datos);
			$datos=new CArrayDataProvider($datos, array(
				    'keyField'=>'iddetallectacteprov',
				    'sort'=>array(
				        'attributes'=>array(
				           'iddetallectacteprov','fecha', 'descripcion',
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
			'template'=>'{update}{updatefact}{delete}{deleteordendepago}{actNC}{actND}{borrarND}{borrarNC}',
			'buttons' => array(
				'update'=>array(
					'label'=>'Modificar ordendepago',
	                    //'icon'=>TbHtml::ICON_MINUS_SIGN,
	                    'visible'=>'$data["tipo"] == 1',
						'url'=> 'Yii::app()->createUrl("ordendepago/update",
								 array(	"id"=>$data["ordendepago_idordendepago"],
								 		"idctacte"=>$data["ctacteprov_idctacteprov"],
								 		"nombre"=>$data["proveedor"],
								 		))',
						
	                  ),
	            'updatefact'=>array(
					'label'=>'Modificar compra',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data["tipo"] == 0',
						'url'=> 'Yii::app()->createUrl("compra/update",
								 array(	"id"=>$data["compra_idcompra"],
								 		
								 		))',
						
	                  ),
				'delete'=>array(
	                  	'label'=>'Borrar compra',
	                    //'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data["tipo"] == 0',
	                  	'url'=>'Yii::app()->createUrl("compra/borrar", array("id"=>$data["compra_idcompra"]))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de borrar la compra?',
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
	            
	            'deleteordendepago'=>array(
					'label'=>'Borrar ordendepago',
	                    'icon'=>TbHtml::ICON_TRASH,
	                    'visible'=>'$data["tipo"] == 1',
						'url'=> '$this->grid->controller->createUrl("ordendepago/delete",
								 array("id"=>$data["ordendepago_idordendepago"]))',
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
	                    'visible'=>'$data["notacreditoprov_idnotacreditoprov"] != NULL',
						'url'=> 'Yii::app()->createUrl("notacreditoprov/update",
								 array(	"id"=>$data["notacreditoprov_idnotacreditoprov"],
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
				  'borrarNC'=>array(
	                  	'label'=>'Borrar Nota Crédito ',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data["notacreditoprov_idnotacreditoprov"] != NULL',
	                  	'url'=>'Yii::app()->createUrl("notacreditoprov/borrar", array("id"=>$data["notacreditoprov_idnotacreditoprov"]))',
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
	                    'visible'=>'$data["notadebitoprov_idnotadebitoprov"] != NULL',
						'url'=> 'Yii::app()->createUrl("notadebitoprov/update",
								 array(	"id"=>$data["notadebitoprov_idnotadebitoprov"],
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
				  'borrarND'=>array(
	                  	'label'=>'Borrar Nota Débito',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data["notadebitoprov_idnotadebitoprov"] != NULL',
	                  	'url'=>'Yii::app()->createUrl("notadebitoprov/borrar", array("id"=>$data["notadebitoprov_idnotadebitoprov"]))',
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
	//'id'=>'detallectacteprov-grid',
	'dataProvider'=>$datos,
	//'filter'=>$datos->sort(),
	'columns'=>$columnas,
	'template' => "{items}{pager}",
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
)); ?>