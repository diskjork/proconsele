
<?php 
	$dataProvider= $model->search($model->fecha=$anioTab."-".$mesTab, $model->tipomoviento= 1);
	$dataProvider->setPagination(array('pageSize'=>$model->count()));
	
	
?>
<br>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", 
array("color" => TbHtml::LABEL_COLOR_SUCCESS)),
array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab,'tipo'=>1),
'Exportar Libro Compras',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php
$valores=array('1.21'=>'21%', '1.105'=>'10.5%');$columnas=array(
	array(
					'header' => '#',
                    'value'=>'$this->grid->dataProvider->pagination->currentPage*
              	    $this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
       				),
		array('name' => 'nrocomprobante',
					'header' => 'NRO.COMP.',
					'htmlOptions' => array('width' =>'5%'),
					),
		array('name' => 'fecha',
					'header' => 'F. COBRO',
					'filter'=>false,
	            'htmlOptions' => array('width' =>'30px'),
			), // (#4)
		array(
			'header'=>'EMPRESA',
			'value'=>'($data->proveedorIdproveedor != null)?$data->proveedorIdproveedor:$data->clienteIdcliente',
			'htmlOptions' => array('width' =>'150px','style'=>'text-align: left;'),
		),
		
		array(		//'name' => 'proveedorIdproveedor.cuit',
					'header' => 'CUIT',
					'htmlOptions' => array('width' =>'100px'),
					'value'=>'($data->proveedorIdproveedor != null)? $data->proveedorIdproveedor->cuit : $data->clienteIdcliente->cuit'
					),	
		
		array(//'name' => 'tipofactura',
				'header' => 'TIPO COMP.',
				'value'=>array($this,'labelEstado'),
								
		),
		array(//'name' => 'tipoiva',
				'header' => 'IVA',
				'value'=>'($data->tipoiva == 1.21)?"21%" :"10,5%"',
				
		),
		array(
				'header' => 'IIBB',
				'value'=>'($data->importeiibb != null) ? "$".number_format($data->importeiibb, 2, ".", ","): ""',
								
		),
		array(
				'header' => 'TOTAL IVA',
				'value'=>'"$".number_format($data->importeiva, 2, ".", ",")',
								
		),
		array(
				'header' => 'TOTAL NETO',
				'value'=>'"$".number_format($data->importeneto, 2, ".", ",")',
								
		),

		array(
			//'header'=>'Opciones',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('style' =>'text-align: right; width:5%;'),
			'template'=>' {actcompra} {actNC}',
			'buttons'=> array(
					'actcompra'=>array(
					'label'=>'Modificar Compra',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->compra_idcompra != NULL',
						'url'=> 'Yii::app()->createUrl("compras/update",
								 array(	"id"=>$data->compra_idcompra,
								 		"vista"=>3,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
	                  'actNC'=>array(
						'label'=>'Modificar Nota Crédito',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->notacredito_idnotacredito != NULL',
						'url'=> 'Yii::app()->createUrl("notacredito/update",
								 array(	"id"=>$data->notacredito_idnotacredito,
								 		"vista"=>3,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),    
					)
		          ),
		 );
?>
<?php
	
	$this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'ivaventa-grid',
	'dataProvider'=>$dataProvider,
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
	'filter'=>$model,
	//'afterAjaxUpdate' => 'reinstallDatePicker', // (#1)
	'columns'=>$columnas,
	'template' => "{items}{pager}",
)); ?>

<?php 

    $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'viewModal',
    'header' => '<h4>Detalle de cheque</h4>',
    'fade'=>false,	
    'content' => '<div class="modal-body"><p></p></div>', //--> lo modificado 
    ));
    
    Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
        //use the same parameters that you had set in your widget else the datepicker will be refreshed by default
    $('#datepicker_for_fechacobro').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['es'],{'dateFormat':'dd/mm/yy'}));
}
");
?>


<script>
$("#content").css('width','850px');
$(".grid-view .table td").css('text-align','center');
</script>