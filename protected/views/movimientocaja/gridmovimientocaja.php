
<?php 
$dataProvider= $model->search(array($model->fecha=$anioTab."-".$mesTab,$model->caja_idcaja=$bancoid));
/*$dataProvider=$model->findAll('year(fecha)=:ano and month(fecha)=:mes and caja_idcaja=:caja',
							array(':ano'=>$anioTab,
								  ':mes'=>$mesTab,
								  ':caja'=>$bancoid)); */
							


	$dataProvider->setPagination(array('pageSize'=>$model->count()));
	$datosArray=$dataProvider->getData();
	
	//Obtener total debe y haber;
	$dataProviderDH=$model->obtenerDebeHaber($mesTab,$anioTab,$bancoid);
	
	$dataProviderDebeHaber=$dataProviderDH->getData();
?>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php
$columnas=array_merge(array(
				array(
                    'value'=>'$this->grid->dataProvider->pagination->currentPage*
              	    $this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
       				),
			  
          	  array(
          	  		'header'=>'FECHA',
          	  		'name' => 'fecha',
					'htmlOptions' => array('width' =>'50px'),
          	  		'filter'=>"",
          	  		),
          	array(
          	  		'header'=>'DESCRIPCION',
					'name' => 'descripcion',
          	  		),
              array(
              		'header'=>'INGRESOS',
              		'name' => 'debe',
					'htmlOptions' => array('width' =>'75px'),
              		'cssClassExpression' => '$data["debe"] > 0 ? "colorDebe": ""',
					'value'=>'($data->debe !== null && $data->debe > 0)?number_format($data->debe, 2, ".", ","): "-"',
              		//'footer'=>"$ ".number_format($dataProviderDebeHaber[0]['total_debe']-$dataProviderDebeHaber[0]['total_haber'],2,".",","),
              		'footer'=>"(T.D:$".number_format($dataProviderDebeHaber[0]['total_debe'],2,".",",").")  (T.H:$".number_format($dataProviderDebeHaber[0]['total_haber'],2,".",",").")",
              		'footerHtmlOptions'=>array('colspan'=>2 ,'style'=>'text-align:center;font-weight:bold;'),
              ),
			  array(
			  		'header'=>'EGRESOS',
			  		'name' => 'haber',
					'htmlOptions' => array('width' =>'75px'),
              		'cssClassExpression' => '$data["haber"] > 0 ? "colorHaber": ""',
			  		'value'=>'($data->haber !== null && $data->haber > 0)?number_format($data->haber, 2, ".", ","): "-"',
  			),
			 array(
	            'header'=>'Opciones',
	            'class'=>'bootstrap.widgets.TbButtonColumn',
			 	'template' => ' {view} {update} {delete}',
	            'buttons'=>array(
	               /* 'Factura compra'=>
	                    array(
	                    	'icon'=>TbHtml::ICON_PLUS_SIGN,
	                        'url'=>'$data["debeohaber"] == 0 ? Yii::app()->createUrl("factura/view", array("id"=>$data->id_de_trabajo)):Yii::app()->createUrl("compras/view", array("id"=>$data->id_de_trabajo))',
	                        'visible'=>'$data["rubro_idrubro"] == 2 ',
	                        'options'=>array(
	                            'ajax'=>array(
	                                'type'=>'POST',
	                                'url'=>"js:$(this).attr('href')",
	                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
	                            ),
	                        ),
	                    ),
	                'Factura venta'=>
	                    array(
	                    	'icon'=>TbHtml::ICON_PLUS_SIGN,
	                        'url'=>'$data["debeohaber"] == 0 ? Yii::app()->createUrl("factura/view", array("id"=>$data->id_de_trabajo)):Yii::app()->createUrl("compras/view", array("id"=>$data->id_de_trabajo))',
	                        'visible'=>'$data["rubro_idrubro"] == 4 ',
	                        'options'=>array(
	                            'ajax'=>array(
	                                'type'=>'POST',
	                                'url'=>"js:$(this).attr('href')",
	                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
	                            ),
	                        ),
	                    ),
	                'Cobranza'=>
	                    array(
	                    	'icon'=>TbHtml::ICON_PLUS_SIGN,
	                        'url'=>'Yii::app()->createUrl("cobranza/view", array("id"=>$data->id_de_trabajo))',
	                    	'visible'=>'$data["rubro_idrubro"]==5',
	                        'options'=>array(
	                            'ajax'=>array(
	                                'type'=>'POST',
	                                'url'=>"js:$(this).attr('href')",
	                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
	                            ),
	                        ),
	                    ),*/
	                 'view'=>
	                    array(
	                    	'label'=>'Ver asiento contable',
	                        'url'=>'Yii::app()->createUrl("asiento/update", array("id"=>$data->asiento_idasiento,"vista"=>2))',
	                       /* 'options'=>array(
	                            'ajax'=>array(
	                                'type'=>'POST',
	                                'url'=>"js:$(this).attr('href')",
	                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
	                            ),
	                        ),*/
	                    ),
	                    
	            ),
	            'headerHtmlOptions'=>array('colspan'=>2),
	            'htmlOptions' => array('colspan'=>2),
	            'footerHtmlOptions'=>array('colspan'=>2),
	        ),
		));?>


	<?php 
	$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	    //'filter'=>$model,
	    //'fixedHeader' => false,
	    //'headerOffset' => 20, // height of the main navigation at bootstrap
	    'dataProvider' => $dataProvider,
	    'columns' => $columnas,
		'template' => "{items}{pager}",
		'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
		
	));

?>

