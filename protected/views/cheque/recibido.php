<?php
/* @var $this ChequeController */
/* @var $model Cheque */


$this->breadcrumbs=array(
	'Cheques'=>array('index'),
	'Administrar',
);

$this->menu=array(
	
	array('label'=>'Cheques Emitidos','url'=>'emitido'),
	array('label'=>'Cheque Endosados','url'=>'endosados'),
);
	
?>

<?php /* $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'ModalBanco',
    'header' => '<h4>Nuevo Banco</h4>',
	'fade'=>false,
    'content' => $this->renderPartial('_formbanco',array('model'=>$modelBanco), true),
  )); */?>
    
<h5 class="well well-small">ADMINISTRACIÓN DE CHEQUES RECIBIDOS</h5>
<div>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
</div>


<?php 
	$dataProvider= $model->search($model->debeohaber=0);
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
$valores=array('0'=>'A Cobrar', '3'=>'Cobrado-Caja','4'=>'Endozado','5'=>'Cobrado-Banco');

$columnas=array(
	array(
					'header' => '#',
                    'value'=>'$this->grid->dataProvider->pagination->currentPage*
              	    $this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
       				),
		array('name' => 'nrocheque',
					'header' => 'NRO. CHEQUE',
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
			'header'=>'LIBERADO POR:',
			'value'=>'$data->cliente_idcliente != NULL ? $data->clienteIdcliente : "YVN S.R.L."',
			'htmlOptions' => array('width' =>'150px','style'=>'text-align:center'),
		),
		array(
			'header'=>'TITULAR:',
			'value'=>'$data->cliente_idcliente != NULL ? $data->titular : "YVN S.R.L."',
			'htmlOptions' => array('width' =>'150px','style'=>'text-align:center'),
		),
		array(
			'header'=>'CUIT TITULAR',
			'value'=>'$data->cliente_idcliente != NULL ? $data->cuittitular : "-"',
			'htmlOptions' => array('width' =>'150px','style'=>'text-align:center'),
		),
		array(
			'header'=>'ENTREGADO A:',
			'value'=>'$data->proveedor_idproveedor != NULL ? $data->proveedorIdproveedor : "-" ',
			'htmlOptions' => array('width' =>'150px','style'=>'text-align:center'),
		),
		
		array('name' => 'Banco_idBanco',
					'header' => 'BANCO',
					'value'=> '$data->bancoIdBanco',
					'htmlOptions' => array('width' =>'150px'),
			'filter' => CHtml::activeDropDownList($model, 'Banco_idBanco', CHtml::listData(Banco::model()->findAll(), 'idBanco', 'nombre'), array('prompt' => ' ')),
		),	
		array(	
			'name' => 'debe',
			'header' => 'IMPORTE',
			//'htmlOptions' => array('width' =>'30px'),
			'value'=>'($data->debe !== null)?number_format($data->debe, 2, ".", ","): ""',			
			'footer'=>"$".$dataDebeTotal,			
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
			'template'=>'{view} {update}  {acreditar} {canAcreditarCaja} {canAcreditarBanco}',
			
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
                    	'label'=>'Modificar cheque desde cobranza',
                    	'visible'=>'$data->estado == 2 AND $data->iddetallecobranza != null',
                        'url'=>'Yii::app()->createUrl("cobranza/update", array("id"=>$data->detallecobranzaIddetallecobranza->cobranza_idcobranza))',
                        //'visible'=>'$data->estado == 0 || $data->estado == 2 ',
                    ),
                 'acreditar'=>array(
					'label'=>'Acreditar',
	                    'icon'=>TbHtml::ICON_PLUS_SIGN,
	                  	'visible'=>'$data->debe != null and $data->haber == 0 and $data->estado == 2',
	                    'url'=>'Yii::app()->createUrl("cheque/acreditar", array("id"=>$data->idcheque))',
	             ),
				
	             'canAcreditarCaja'=>array(
	                  	'label'=>'Cancelar Acreditación por Caja',
	                    'icon'=>TbHtml::ICON_ASTERISK,
						'visible'=>'$data->estado == 3',
	                  	'url'=>'Yii::app()->createUrl("cheque/cancelarAcreditaCaja", array("id"=>$data->idcheque))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de cancelar la acreditación?',
		                  		'ajax' => array(
		                            'type' => 'POST',
		                            'url' => "js:$(this).attr('href')",
	             					'error'=>'function(jqXHR ,textStatus,errorThrown){alert(jqXHR.responseText);}',
		                  			'success' => 'function(data){
	                                	if(data == "true"){
		                                  $.fn.yiiGridView.update("cheque-grid");
		                                  alert("Fue cambiando con éxito!");
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
		          'canAcreditarBanco'=>array(
	                  	'label'=>'Cancelar Acreditación por Banco',
	                    'icon'=>TbHtml::ICON_ASTERISK,
						'visible'=>'$data->estado == 5',
	                  	'url'=>'Yii::app()->createUrl("cheque/cancelarAcreditaBanco", array("id"=>$data->idcheque))',
	                  	'options'=>array(
	                  		'confirm' => 'Está seguro de cancelar la acreditación?',
		                  		'ajax' => array(
		                            'type' => 'POST',
		                            'url' => "js:$(this).attr('href')",
		              				'error'=>'function(jqXHR ,textStatus,errorThrown){alert(jqXHR.responseText);}',
		              				'success' => 'function(data){
	                                	if(data == "true"){
		                                  $.fn.yiiGridView.update("cheque-grid");
		                                  alert("Fue cambiando con éxito!");
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
	             )
			),
		
	);
?>
<?php
	
	$this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'cheque-grid',
	'dataProvider'=>$dataProvider,
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
	'filter'=>$model,
	//'ajaxUpdateError'=>'function(xhr,ts,et,err){ alert("si"); }',
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
$(".grid-view .table td").css('text-align','center');
</script>