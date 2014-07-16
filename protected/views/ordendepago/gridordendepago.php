
<?php 
	
	$dataProvider= $model->search($model->fecha=$anioTab.'-'.$mesTab);
	$dataProvider->setPagination(array('pageSize'=>200)); 
?>

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
			'name'=>'descripcionordendepago',
		),
		array(
			'header'=>'IMPORTE',
			'name'=>'importe',
			'value'=>'$data->importe',
			'class'=>'bootstrap.widgets.TbTotalSumColumn',
		),
		array(
    		'header'=>'PROVEEDOR',
			'name'=>'ctacteprov_idctacteprov',
			'filter'=>false,
			'value'=>array($this,'gridNombreProveedor'),
			
		),
		
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update} {delete}',   
            'buttons'=>array(
            
                 'update'=>array(
					'label'=>'Modificar Orden de pago',
	                    //'icon'=>TbHtml::ICON_MINUS_SIGN,
	                    
						'url'=> 'Yii::app()->createUrl("ordendepago/update",
								 array(	"id"=>$data->idordendepago,
								 		"idctacte"=>$data->ctacteprov_idctacteprov,
								 		"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
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
