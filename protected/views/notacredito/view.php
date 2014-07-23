<?php
/* @var $this NotacreditoController */
/* @var $model Notacredito */
?>

<?php
$this->breadcrumbs=array(
	'Notacreditos'=>array('index'),
	$model->idnotacredito,
);

$this->menu=array(
	array('label'=>'List Notacredito', 'url'=>array('index')),
	array('label'=>'Create Notacredito', 'url'=>array('create')),
	array('label'=>'Update Notacredito', 'url'=>array('update', 'id'=>$model->idnotacredito)),
	array('label'=>'Delete Notacredito', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idnotacredito),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notacredito', 'url'=>array('admin')),
);
?>

<h1>View Notacredito #<?php echo $model->idnotacredito; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idnotacredito',
		'nrodefactura',
		'fecha',
		'formadepago',
		'cliente_idcliente',
		'estado',
		'descrecar',
		'tipodescrecar',
		'iva',
		'retencionIIBB',
		'presupuesto',
		'nropresupuesto',
		'cantidadproducto',
		'producto_idproducto',
		'nombreproducto',
		'precioproducto',
		'stbruto_producto',
		'asiento_idasiento',
		'impuestointerno',
		'desc_imp_interno',
		'importebruto',
		'ivatotal',
		'importeneto',
		'importeIIBB',
		'importeImpInt',
		'factura_idfactura',
	),
)); ?>