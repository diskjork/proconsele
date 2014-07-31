<?php
/* @var $this CtacteclienteController */
/* @var $model Ctactecliente */

?>
<?php
$this->menu=array(
	array('label'=>'Cta. Cte. - Clientes', 'url'=>array('admin'),	'active' => true,
		),
	array('label'=>'Cobranzas realizadas', 'url'=>Yii::app()->createUrl('cobranza/admin')
		),
	array('label'=>'Nueva Cobranza', 'url'=>Yii::app()->createUrl("cobranza/create" 
		)),
	array('label'=>'Nueva Nota Crédito', 'url'=>Yii::app()->createUrl("notacredito/create" 
		)),	
	array('label'=>'Nueva Nota Débito', 'url'=>Yii::app()->createUrl("notadebito/create" 
		)),	
	
);
?>
<h5 class="well well-small">CUENTAS CORRIENTES - CLIENTES</h5>
<br>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel'),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php 
$dataProvider=$model->search2();//del nuevo criteria en el BaseCtactecliente
$dataProvider->setPagination(array('pageSize'=>20)); 
$columnas=array(
		
		array('name' => 'clienteIdcliente',
					'header' => 'CLIENTE',
					'filter'=> CHtml::activeTextField($model->searchcliente, 'nombre'),
					'value'=>'$data->clienteIdcliente->nombre',
					'htmlOptions' => array('width' =>'50%')),	
		array('name' => 'debe',
					'header' => 'DEBE',
					'filter'=> false,
					'htmlOptions' => array('width' =>'15%'),
					'value'=>'($data->debe !== null)? "$".number_format($data->debe, 2, ".", ","): ""',			
					),
		array('name' => 'haber',
					'header' => 'HABER',
					'filter'=> false,
					'htmlOptions' => array('width' =>'15%'),
					'value'=>'($data->haber !== null)? "$".number_format($data->haber, 2, ".", ","): ""',			
					),
		array('name' => 'saldo',
					'header' => 'SALDO',
					'htmlOptions' => array('width' =>'15%'),
					'value'=>'($data->saldo !== null)? "$".number_format($data->saldo, 2, ".", ","): ""',			
					),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}',
			'header'=>'Opciones',
			'htmlOptions'=>array('style'=>'width:5%; text-align:center;'),
			'buttons' => array(
				'view'=>array(
					'label'=>'Ver detalle Cta.Cte.',
	                    //'icon'=>TbHtml::ICON_MINUS_SIGN,
						'url'=> 'Yii::app()->createUrl("detallectactecliente/admin",
								 array(	"id"=>$data->idctactecliente,
								 		"nombre"=>$data->clienteIdcliente,
								 		
								 		))',
						
	                  ),
		),
		),
		);
		?>

<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'ctactecliente-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>$columnas,
	'fixedHeader' => false,
    'headerOffset' => 40, // 40px is the height of the main navigation at bootstrap
    'template' => "{summary}{items}{pager}",
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
		
)); ?>