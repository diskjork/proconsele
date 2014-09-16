
<div id="iconoExportar" align="right">


<?php echo " ".TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", 
				array("color" => TbHtml::LABEL_COLOR_WARNING)),
				array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab,'tipo'=>2),
				'Exportar asiento resumen anual',
				array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
<?php echo " ".TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>",
				array("color" => TbHtml::LABEL_COLOR_SUCCESS)),
				array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab,'tipo'=>0),
				'Exportar asiento resumen del mes',
				array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
<?php  echo " ".TbHtml::tooltip(TbHtml::labelTb(TbHtml::icon(TbHtml::ICON_TASKS),
				 array("color" => TbHtml::LABEL_COLOR_WARNING)),
				 array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab,'tipo'=>3),
				 'Exportar Libro Diario Año',
				 array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
<?php  echo " ".TbHtml::tooltip(TbHtml::labelTb(TbHtml::icon(TbHtml::ICON_TASKS),
				 array("color" => TbHtml::LABEL_COLOR_SUCCESS)),
				 array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab,'tipo'=>1),
				 'Exportar Libro Diario del mes',
				 array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
<?php  echo " ".TbHtml::tooltip(TbHtml::labelTb(TbHtml::icon(TbHtml::ICON_SIGNAL),
				 array("color" => TbHtml::LABEL_COLOR_WARNING)),
				 array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab,'tipo'=>5),
				 'Resumen cuenta con saldos - Año',
				 array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
<?php  echo " ".TbHtml::tooltip(TbHtml::labelTb(TbHtml::icon(TbHtml::ICON_SIGNAL),
				 array("color" => TbHtml::LABEL_COLOR_SUCCESS)),
				 array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab,'tipo'=>4),
				 'Resumen cuenta con saldos - Mes',
				 array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>


</div>
<?php
$dataProvider=$model->search($model->fecha=$anioTab."-".$mesTab);
$dataProvider->setPagination(array('pageSize'=>200));
$gridColumns= array(
		
		array(
				'header'=>'FECHA',
				'name'=>'fecha',
				'filter'=>false,
				'htmlOptions' => array('width' =>'15px'),
			),
		array(
			'header'=>'DESCRIPCION',
			'name'=>'descripcion',
			//'filter'
			'htmlOptions' => array('width' =>'80%',
										'style'=>'text-align:left;'),
		),
		
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('style'=>'width:5%;text-align:center;'),
			'template'=>'{update} {delete} {actNC} {actND} {actmovbanco} {actmovcaja} {actcompra} {actordenpago} 
						{actcobranza} {actfactura} {borrarOrPago} {borrarCobranza} {borrarFactura} {borrarCompra}
						{borrarNC} {borrarND} {actNC-P} {borrarNC-P} {actND-P} {borrarND-P}',
            'buttons'=>array(
             	 'delete'=>array(
					'label'=>'Borrar asiento',
					'visible'=>'$data->movimientobanco_idmovimientobanco == NULL AND
	                    		    $data->movimientocaja_idmovimientocaja == NULL AND 
	                    		    $data->compra_idcompra == NULL AND
	                    		    $data->factura_idfactura == NULL AND
	                    		    $data->ordendepago_idordendepago == NULL AND
	                    		    $data->cobranza_idcobranza == NULL AND
	                    		    $data->notadebito_idnotadebito == NULL AND
	                    		    $data->notacreditoprov_idnotacreditoprov == NULL AND
	                    		    $data->notadebitoprov_idnotadebitoprov == NULL AND
	                    		    $data->notacredito_idnotacredito == NULL AND
	                    		    $data->idcheque == NULL
	                    		    ',
				 ),
                 'update'=>array(
					'label'=>'Modificar asiento',
	                    //'icon'=>TbHtml::ICON_MINUS_SIGN,
	                    'visible'=>'$data->movimientobanco_idmovimientobanco == NULL AND
	                    		    $data->movimientocaja_idmovimientocaja == NULL AND 
	                    		    $data->compra_idcompra == NULL AND
	                    		    $data->factura_idfactura == NULL AND
	                    		    $data->ordendepago_idordendepago == NULL AND
	                    		    $data->cobranza_idcobranza == NULL AND
	                    		    $data->notadebito_idnotadebito == NULL AND
	                    		    $data->notacreditoprov_idnotacreditoprov == NULL AND
	                    		    $data->notadebitoprov_idnotadebitoprov == NULL AND
	                    		    $data->notacredito_idnotacredito == NULL AND
	                    		    $data->idcheque == NULL
	                    		    ',
						'url'=> 'Yii::app()->createUrl("asiento/update",
								 array(	"id"=>$data->idasiento,
								 		
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
	              'actmovbanco'=>array(
					'label'=>'Modificar Mov.Banco',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->movimientobanco_idmovimientobanco != NULL AND $data->idcheque == NULL ',
						'url'=> 'Yii::app()->createUrl("movimientobanco/update",
								 array(	"id"=>$data->movimientobanco_idmovimientobanco,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
	              'actmovcaja'=>array(
					'label'=>'Modificar Mov.Caja',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->movimientocaja_idmovimientocaja != NULL AND $data->idcheque == NULL',
						'url'=> 'Yii::app()->createUrl("movimientocaja/update",
								 array(	"id"=>$data->movimientocaja_idmovimientocaja,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
	              'actcompra'=>array(
					'label'=>'Modificar Compra',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->compra_idcompra != NULL',
						'url'=> 'Yii::app()->createUrl("compras/update",
								 array(	"id"=>$data->compra_idcompra,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
	              'actfactura'=>array(
					'label'=>'Modificar Factura',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->factura_idfactura != NULL AND $data->facturaIdfactura->estado == 0',
						'url'=> 'Yii::app()->createUrl("factura/update",
								 array(	"id"=>$data->factura_idfactura,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),  
	              'actordenpago'=>array(
					'label'=>'Modificar Orden de pago',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->ordendepago_idordendepago != NULL',
						'url'=> 'Yii::app()->createUrl("ordendepago/update",
								 array(	"id"=>$data->ordendepago_idordendepago,
								 		//"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),   
	               'actcobranza'=>array(
					'label'=>'Modificar Cobranza',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->cobranza_idcobranza != NULL',
						'url'=> 'Yii::app()->createUrl("cobranza/update",
								 array(	"id"=>$data->cobranza_idcobranza,
								 		//"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
	                'borrarOrPago'=>array(
	                  	'label'=>'Borrar Orden de Pago',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data->ordendepago_idordendepago != NULL',
	                  	'url'=>'Yii::app()->createUrl("ordendepago/borrar", array("id"=>$data->ordendepago_idordendepago))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de borrar la orden de pago?',
		                  		'ajax' => array(
		                            'type' => 'POST',
		                            'url' => "js:$(this).attr('href')",
	                  				'error'=>'function(jqXHR ,textStatus,errorThrown){alert(jqXHR.responseText);}',
		                  			'success' => 'function(data){
	                                	if(data == "true"){
		                                    location.reload();
		                                  alert("Fue borrado con éxito!");
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
		            'borrarCobranza'=>array(
	                  	'label'=>'Borrar Cobranza',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data->cobranza_idcobranza != NULL',
	                  	'url'=>'Yii::app()->createUrl("cobranza/borrar", array("id"=>$data->cobranza_idcobranza))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de borrar la Cobranza?',
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
		             'borrarFactura'=>array(
	                  	'label'=>'Borrar Factura',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data->factura_idfactura != NULL AND $data->facturaIdfactura->estado == 0 ',
	                  	'url'=>'Yii::app()->createUrl("factura/borrar", array("id"=>$data->factura_idfactura))',
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
		              'borrarCompra'=>array(
	                  	'label'=>'Borrar Compra',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data->compra_idcompra != NULL',
	                  	'url'=>'Yii::app()->createUrl("compras/borrar", array("id"=>$data->compra_idcompra))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de borrar la Compra?',
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
		              'actNC'=>array(
						'label'=>'Modificar Nota Credito',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->notacredito_idnotacredito != NULL',
						'url'=> 'Yii::app()->createUrl("notacredito/update",
								 array(	"id"=>$data->notacredito_idnotacredito,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
					'actND'=>array(
						'label'=>'Modificar Nota Débito',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->notadebito_idnotadebito != NULL',
						'url'=> 'Yii::app()->createUrl("notadebito/update",
								 array(	"id"=>$data->notadebito_idnotadebito,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
					'borrarND'=>array(
	                  	'label'=>'Borrar Nota Débito',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data->notadebito_idnotadebito != NULL',
	                  	'url'=>'Yii::app()->createUrl("notadebito/borrar", array("id"=>$data->notadebito_idnotadebito))',
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
					'borrarNC'=>array(
	                  	'label'=>'Borrar Nota Crédito',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data->notacredito_idnotacredito != NULL',
	                  	'url'=>'Yii::app()->createUrl("notacredito/borrar", array("id"=>$data->notacredito_idnotacredito))',
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
		           'actNC-P'=>array(
						'label'=>'Modificar Nota Crédito - Proveedor',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->notacreditoprov_idnotacreditoprov != NULL',
						'url'=> 'Yii::app()->createUrl("notacreditoprov/update",
								 array(	"id"=>$data->notacreditoprov_idnotacreditoprov,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
				  'borrarNC-P'=>array(
	                  	'label'=>'Borrar Nota Crédito - Proveedor',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data->notacreditoprov_idnotacreditoprov != NULL',
	                  	'url'=>'Yii::app()->createUrl("notacreditoprov/borrar", array("id"=>$data->notacreditoprov_idnotacreditoprov))',
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
		           'actND-P'=>array(
						'label'=>'Modificar Nota Débito - Proveedor',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->notadebitoprov_idnotadebitoprov != NULL',
						'url'=> 'Yii::app()->createUrl("notadebitoprov/update",
								 array(	"id"=>$data->notadebitoprov_idnotadebitoprov,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
				  'borrarND-P'=>array(
	                  	'label'=>'Borrar Nota Débito - Proveedor',
	                    'icon'=>TbHtml::ICON_REMOVE_SIGN,
						'visible'=>'$data->notadebitoprov_idnotadebitoprov != NULL',
	                  	'url'=>'Yii::app()->createUrl("notadebitoprov/borrar", array("id"=>$data->notadebitoprov_idnotadebitoprov))',
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

//Yii::app()->getComponent('yiiwheels')->registerAssetJs('bootbox.min.js');
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	//'id'=>'asientogrid',
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
	'dataProvider' =>$dataProvider,
	'template' => "{items}",
	'filter'=>$model,
	'afterAjaxUpdate'=>"js:function(id, data){
						visualizar();
						
								}",
	'columns' => array_merge(
					$gridColumns,
					array(
						array(
								'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
								'name' => 'Visualizar',
								'filter'=>false,
								'url' => $this->createUrl('asiento/grilla'),
								'value' => '""',
								'htmlOptions' => array('style' =>'width:5%; text-align:center;'),
								'cacheData'=>false,
								'afterAjaxUpdate' => 'js:function(tr,rowid,data){
								$("td[colspan]").css("background-color","#F5F5DC");
								//botonvisualizar();
								//$("span.wh-relational-column[data-rowid="+rowid+"]").find("i").removeClass("icon-chevron-down");
								//$("span.wh-relational-column[data-rowid="+rowid+"]").find("i").addClass("icon-chevron-up");
								}'
							)
						) 	
						),
)); ?>