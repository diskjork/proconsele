<?php 
	$dataProvider=$model->search($model->fecha=$anioTab."-".$mesTab);
	//$model->fecha=$anioTab."-".$mesTab,$model->ctabancaria_idctabancaria=$bancoid);
	//$dataProvider= $model->generarGrid($anioTab,$mesTab);
	
	$dataProvider->setPagination(array('pageSize'=>$model->count())); 
	
	$dataArray=$dataProvider->getData();
	$importeFinalTotal=0;
	
	//print_r($dataArray); die();
	for ($i=0;$i<$dataProvider->totalItemCount;$i++){
		//echo $dataArray[$i]['importeTotal'];
		$importeFinalTotal+=$dataArray[$i]['importeneto'];
	}
?>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php 
	$gridColumns= array(
		
		array(
			'header'=>'N° FACTURA',
			'name'=>'nrodefactura',
			'htmlOptions'=>array('class'=>'anchoMedium'),
		),
		array(
			'header'=>'FECHA',
			'name'=>'fecha',
			'filter'=>false,
		),
		array(
			'header'=>'PROVEEDOR',
			'name'=>'proveedor_idproveedor',
			'value'=>'GxHtml::valueEx($data->proveedorIdproveedor)',
			'filter'=>GxHtml::listDataEx(Proveedor::model()->findAllAttributes(array('idproveedor','nombre'),true,array('order'=>'nombre ASC')),'idproveedor','nombre'),
		),
		array(
			'header'=>'DESCRIPCION',
			'name'=>'descripcion',
			//'filter'=>false,
		),
		array(
			'header'=>'IMPORTE',
			'value'=>'number_format($data->importeneto,2,".","")',
			'footer'=>'bootstrap.widgets.TbTotalSumColumn',
			'footer'=>"$ ".number_format($importeFinalTotal,2,".",","),
		),
		
		/*array(
			'header'=>'ESTADO',
			'name'=>'estado',
			'value'=>'($data->estado == 1) ? "Pagada":"Impaga"',
		),*/
		
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('width' =>'70px'),
			'template'=>'{update} {delete} ',
            'buttons'=>array(
                'view'=>
                    array(
                        'url'=>'Yii::app()->createUrl("factura/view", array("id"=>$data->idcompra))',
                        'options'=>array(
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
                            ),
                        ),
                    ),
               ),
        ),
	);
	$this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'filter'=>$model,
    //'fixedHeader' => false,
    //'headerOffset' => 40, // 40px is the height of the main navigation at bootstrap
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
    'dataProvider' => $dataProvider,
	'template' => "{items}{pager}",
    'columns' => $gridColumns,
    ));
?>
