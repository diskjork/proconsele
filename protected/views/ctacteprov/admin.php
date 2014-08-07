<?php
/* @var $this CtacteprovController */
/* @var $model Ctacteprov */
/*

$this->breadcrumbs=array(
	'Ctacteprovs'=>array('index'),
	'Manage',
);*/


$this->menu=array(
	array('label'=>'Cta. Cte. - Proveedor', 'url'=>array('admin'),	'active' => true,
		),
	array('label'=>'Ordenes de pago realizadas', 'url'=>Yii::app()->createUrl('ordendepago/admin')
		),
	array('label'=>'Nueva Orden de pago', 'url'=>Yii::app()->createUrl("ordendepago/create" 
		)),
	array('label'=>'Nueva Nota Crédito', 'url'=>Yii::app()->createUrl("notacreditoprov/create" 
		)),	
	array('label'=>'Nueva Nota Débito', 'url'=>Yii::app()->createUrl("notadebitoprov/create" 
		)),	
	
);
?>
<h5 class="well well-small">CTA. CTE. PROVEEDORES</h5>
<br>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel'),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php 
$dataProvider=$model->search2();
$dataProvider->setPagination(array('pageSize'=>20)); 
$columnas=array(
		
		array('name' => 'proveedorIdproveedor',
					'header' => 'PROVEEDOR',
					'filter'=> CHtml::activeTextField($model->searchprov, 'nombre'),
					'value'=>'$data->proveedorIdproveedor->nombre',
					'htmlOptions' => array('width' =>'50%')
		),	
		array('name' => 'debe',
					'header' => 'DEBE',
					'filter'=> false,
					'value'=>'($data->debe !== null)? "$".number_format($data->debe, 2, ".", ","): ""',
					'htmlOptions' => array('width' =>'15%'),			
					),
		array('name' => 'haber',
					'header' => 'HABER',
					'filter'=> false,
					'value'=>'($data->haber !== null)? "$".number_format($data->haber, 2, ".", ","): ""',
					'htmlOptions' => array('width' =>'15%'),			
					),
		array('name' => 'saldo',
					'header' => 'SALDO',
					'value'=>'($data->saldo !== null)? "$".number_format($data->saldo, 2, ".", ","): ""',
					'htmlOptions' => array('width' =>'15%'),
					),
		array(
			'header'=>'Opciones',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}',
			'htmlOptions'=>array('style'=>'width:5%; text-align:center;'),
			'buttons' => array(
				'view'=>array(
					'label'=>'Ver Detalle Cta.Cte.',
	                    //'icon'=>TbHtml::ICON_MINUS_SIGN,
						'url'=> 'Yii::app()->createUrl("detallectacteprov/admin",
								 array(	"id"=>$data->idctacteprov,
								 		"nombre"=>$data->proveedorIdproveedor
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
	'fixedHeader' => false,
    'headerOffset' => 40, // 40px is the height of the main navigation at bootstrap
    'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
	'columns'=>$columnas,
	'template' => '{summary}{items}{pager}',
	
		
)); ?>