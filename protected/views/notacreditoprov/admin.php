<?php

$this->menu=array(
	
	array('label'=>'Nueva NOTA CREDITO','url'=>array('create')),
	//array('label'=>'Cheque Endosados','url'=>'endosados'),
);
	
?>
   
<h5 class="well well-small">ADMINISTRACIÓN DE NOTAS CREDITO - PROVEEDOR</h5>
<div>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
</div>


<?php 
	$dataProvider= $model->search();
	
?>
<br>
<div id="iconoExportar" align="right">
<?php //echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel'),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php
$valores=array('0'=>'A Pagar', '1'=>'Pagado');
$columnas=array(
		array(
					'header' => 'NRO.',
					'value'=>'$data->nronotacreditoprov',
					'htmlOptions' => array('width' =>'10%'),
					),
		array('name' => 'fecha',
					'header' => 'FECHA',
					'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				                'model'=>$model, 
				                'attribute'=>'fecha', 
				                'language' => 'es',
				                // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
				                'htmlOptions' => array(
				                    'id' => 'datepicker_for_due_date',
				                    'size' => '10',
				                ),
				                'defaultOptions' => array(  // (#3)
				                    'showOn' => 'focus', 
				                    'dateFormat' => 'dd/mm/yy',
				                    'showOtherMonths' => true,
				                    'selectOtherMonths' => true,
				                    'changeMonth' => true,
				                    'changeYear' => true,
				                    'showButtonPanel' => true,
				                )
				            ), 
				            true),
				'htmlOptions' => array('width' =>'10%'),
	            ), // (#4)
		
		
		array(
			'header'=>'DESCRIPCIÓN',
			'value'=>'"Relac. a la Compra Fac. Nro: ".$data->comprasIdcompras->nrodefactura." - ".$data->proveedorIdproveedor',
			'htmlOptions' => array('width' =>'70%','style'=>'text-align:center'),
		),
		
		array(
			'header' => 'MOTIVO',
			'htmlOptions' => array('width' =>'15%'),
			'value' =>'($data->importeneto == $data->comprasIdcompras->importeneto)?"Anulación Factura":"Devolución mercadería"'
		),	
		
		array(
			//'name' => 'importeneto',
			'header' => 'IMPORTE',
			'value'=>'"$".number_format($data->importeneto, 2, ".", ",")',
			'htmlOptions' => array('width' =>'10%'),		
		),	
		
		array(
			'header'=>'Opciones',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('style' =>'text-align: right','width' =>'10%'),
			'template'=>'{update} {delete}',
			
		          ),
		 );
?>
<?php
	
	$this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'notacredito-grid',
	'dataProvider'=>$dataProvider,
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
	'filter'=>$model,
	'afterAjaxUpdate' => 'reinstallDatePicker', // (#1)
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