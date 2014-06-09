<?php
/* @var $this CtacteprovController */
/* @var $model Ctacteprov */
/*

$this->breadcrumbs=array(
	'Ctacteprovs'=>array('index'),
	'Manage',
);*/


$this->menu=array(
	array(
		'label'=>'Cta. Cte. - Proveedores', 
		'url'=>array('admin'),
		'active' => true,
	),
	array(
		'label'=>'Ordenes de Pago', 
		'url'=>Yii::app()->createUrl('ordendepago/admin'),
	),
);
?>
<h5 class="well well-small">CTA. CTE. PROVEEDORES</h5>
<br>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel'),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php 
$dataProvider=$model->search();
$dataProvider->setPagination(array('pageSize'=>20)); 
$columnas=array(
		
		array('name' => 'proveedorIdproveedor',
					'header' => 'PROVEEDOR',
					
					'htmlOptions' => array('width' =>'200px')),	
		array('name' => 'debe',
					'header' => 'DEBE',
					'filter'=> false,
					'value'=>'($data->debe !== null)? "$".number_format($data->debe, 2, ".", ","): ""',			
					),
		array('name' => 'haber',
					'header' => 'HABER',
					'filter'=> false,
					'value'=>'($data->haber !== null)? "$".number_format($data->haber, 2, ".", ","): ""',			
					),
		array('name' => 'saldo',
					'header' => 'SALDO',
					'value'=>'($data->saldo !== null)? "$".number_format($data->saldo, 2, ".", ","): ""',			
					),
		array(
			'header'=>'Opciones',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}',
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