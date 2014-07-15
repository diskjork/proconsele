<?php
/* @var $this ChequeController */
/* @var $model Cheque */

$this->menu=array(
	array('label'=>'Nuevo Cheque','url'=>'create'),
	array('label'=>'Nuevo Banco','url'=>'#',
						'htmlOptions'=>array('data-toggle' => 'modal',
    					'data-target' => '#ModalBanco'),
	),
	array('label'=>'Cheque Recibidos','url'=>'recibido'),
	//array('label'=>'Cheque Endosados','url'=>'endosados'),
);
	
?>
<?php  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/cancelarDebito.js', CClientScript::POS_HEAD);?>
<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'ModalBanco',
    'header' => '<h4>Nuevo Banco</h4>',
	'fade'=>false,
    'content' => $this->renderPartial('_formbanco',array('model'=>$modelBanco), true),
  )); ?>
    
<h5 class="well well-small">ADMINISTRACIÓN DE CHEQUES EMITIDOS</h5>
<div>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
</div>


<?php 
	$dataProvider= $model->search($model->debeohaber= 1);
	$dataProvider->setPagination(array('pageSize'=>20));
	$dataArray=$dataProvider->getData();
	$dataDebeTotal=0;$dataHaberTotal=0;

	for ($i=0;$i<count($dataArray);$i++){
		$dataDebeTotal+=$dataArray[$i]['debe'];
		$dataHaberTotal+=$dataArray[$i]['haber'];
	}
?>
<br>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel'),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php
$valores=array('0'=>'A pagar', '1'=>'Pagado');
$columnas=array(
	array(
					'header' => '#',
                    'value'=>'$this->grid->dataProvider->pagination->currentPage*
              	    $this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
       				),
		array('name' => 'nrocheque',
					'header' => 'NRO.',
					'htmlOptions' => array('width' =>'10%'),
					),
		array('name' => 'fechacobro',
					'header' => 'F. COBRO',
					'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				                'model'=>$model, 
				                'attribute'=>'fechacobro', 
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
	            ), // (#4)
		array(
			'header'=>'ENTREGADO A:',
			'value'=>'$data->proveedor_idproveedor != NULL ? $data->proveedorIdproveedor : "-" ',
			'htmlOptions' => array('width' =>'150px','style'=>'text-align:center'),
		),
		
		array('name' => 'chequeraIdchequera',
					'header' => 'CHEQUERA',
					'htmlOptions' => array('width' =>'150px'),
					'filter' => CHtml::activeDropDownList($model, 'chequeraIdchequera', CHtml::listData(Chequera::model()->findAll(), 'idchequera', 'nombre'), array('prompt' => ' ')),
		),	
		
		array('name' => 'haber',
				'header' => 'IMPORTE',
				'value'=>'($data->haber !== null)?number_format($data->haber, 2, ".", ","): ""',
				'footer'=>"$".$dataHaberTotal,				
		),	
		array('name' => 'estado',
					'header' => 'ESTADO',
					//'htmlOptions' => array('width' =>'30px'),
					'value'=>array($this,'labelEstado'),
					'filter' => CHtml::activeDropDownList($model, 'estado', $valores, array('prompt' => '','style'=>'width:100%;')),
					),

		array(
			'header'=>'Opciones',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('style' =>'text-align: right'),
			'template'=>'{debitar} {view} {update} {delete} {canDebito}',
			'buttons' => array(
				 'view'=>
                    array(
                        'url'=>'Yii::app()->createUrl("cheque/view", array("id"=>$data->idcheque))',
                        'options'=>array(
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
                            ),
                        ),
                    ),
                'update'=>
                    array(
                        'url'=>'Yii::app()->createUrl("cheque/update", array("id"=>$data->idcheque))',
                        'visible'=>'$data->estado == 0 || $data->estado == 2 ',
                    ),
				'debitar'=>array(
					'label'=>'Debitar',
	                    'icon'=>TbHtml::ICON_MINUS_SIGN ,
						'visible'=>'$data->haber != null and $data->debe == 0 and $data->estado == 0',
	                   	'url'=> 'Yii::app()->createUrl("cheque/debitar", array("id"=>$data->idcheque))',
						
	                  ),
	            'canDebito'=>array(
	                  	'label'=>'Cancelar Debito',
	                    'icon'=>TbHtml::ICON_ASTERISK,
						'visible'=>'$data->estado == 1',
	                  	'url'=>'Yii::app()->createUrl("cheque/cancelarDebito", array("id"=>$data->idcheque))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de cancelar el débito?',
		                  		'ajax' => array(
		                            'type' => 'POST',
		                            'url' => "js:$(this).attr('href')",
		                  			'success' => 'function(data){
	                                	if(data == "true"){
		                                  $.fn.yiiGridView.update("cheque-grid");
		                                  alert("Fue cambiand con éxito!");
		                                  return false;
	                                	} else {
	                                		$.fn.yiiGridView.update("cheque-grid");
	                                		alert("No pudo cambiarse.");
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
<?php
	
	$this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'cheque-grid',
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