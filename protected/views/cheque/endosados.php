<?php
/* @var $this ChequeController */
/* @var $model Cheque */


$this->breadcrumbs=array(
	'Cheques'=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Cheques endosados','url'=>'#','active' => true),
	array('label'=>'Volver','url'=>'recibido'),
);
	
?>


    
<h5 class="well well-small">CHEQUES ENDOSADOS</h5>
<div>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
</div>


<?php 
	$dataProvider= $model->search($model->estado=4);
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
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('ExcelEndosados'),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php	
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
					),
		array(
			'header'=>'RECIBIDO DE',
			'value'=>'$data->clienteIdcliente',
			'htmlOptions' => array('width' =>'150px'),
		),
					
		array(
			'header'=>'ENTREGADO A',
			'value'=>'$data->proveedorIdproveedor',
			'htmlOptions' => array('width' =>'150px'),
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
			'value'=>'($data->debe !== null)?number_format($data->debe, 2, ".", ","): ""',			
			'footer'=>"$".$dataDebeTotal,			
		),
		/*array('name' => 'haber',
				'header' => 'EMITIDO',
				'value'=>'($data->haber !== null)?number_format($data->haber, 2, ".", ","): ""',
				'footer'=>"$".$dataHaberTotal,				
		),	
		/*array('name' => 'estado',
					'header' => 'ESTADO',
					'value'=>array($this,'labelEstado'),
					),*/

		array(
			'header'=>'Opciones',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			//'htmlOptions' => array('width' =>'60px'),
			'template'=>'{view}',
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
	'columns'=>$columnas,
	'template' => "{items}",
)); ?>

<?php 

    $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'viewModal',
    'header' => '<h4>Detalle de cheque</h4>',
    'fade'=>false,	
    'content' => '<div class="modal-body"><p></p></div>', //--> lo modificado 
    ));
?>
