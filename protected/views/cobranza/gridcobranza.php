
<?php 
	$dataProvider= $model->search($model->fecha=$anioTab.'-'.$mesTab);
	$dataProvider->setPagination(array('pageSize'=>200)); 
?>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php 
	$gridColumns= array(
		//'idproduccion',
		array(
	    	'value'=>'$this->grid->dataProvider->pagination->currentPage*
	        $this->grid->dataProvider->pagination->pageSize + $row+1',
	        'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
    		'header'=>'FECHA',
			'name'=>'fecha',
			'filter'=>false,
		),
		array(
    		'header'=>'DESCRIPCION',
			'name'=>'descripcioncobranza',
		),
		array(
			'header'=>'IMPORTE',
			'name'=>'importe',
			'value'=>'$data->importe',
			'class'=>'bootstrap.widgets.TbTotalSumColumn',
		),
		array(
    		'header'=>'CLIENTE',
			'name'=>'ctactecliente_idctactecliente',
			'value'=>array($this,'gridNombreCliente'),
			
		),
		
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update} {delete}',
            'buttons'=>array(
                'view'=>
                    array(
                        'url'=>'Yii::app()->createUrl("cobranza/view", array("id"=>$data->idcobranza))',
                        'options'=>array(
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
                            ),
                        ),
                    ),
                 'update'=>array(
					'label'=>'Modificar Cobranza',
	                    //'icon'=>TbHtml::ICON_MINUS_SIGN,
	                    //'visible'=>'$data->tipo == 1',
						'url'=> 'Yii::app()->createUrl("cobranza/update",
								 array(	"id"=>$data->idcobranza,
								 		"idctacte"=>$data->ctactecliente_idctactecliente,
								 		"nombre"=>$data->ctacteclienteIdctactecliente->clienteIdcliente,
								 		))',
						
	                  ),
            ),
        ),
	);
	?>

	<?php 
	$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	    'filter'=>$model,
	    'fixedHeader' => false,
	    'headerOffset' => 20, // height of the main navigation at bootstrap
	    'dataProvider' => $dataProvider,
	    'columns' => $gridColumns,
		'template' => "{items}",
		'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
	
    ));
?>
