<?php
/* @var $this IvamovimientoController */
/* @var $model Ivamovimiento */
?>

<?php
$this->breadcrumbs=array(
	'Ivamovimientos'=>array('index'),
	$model->idivamovimiento,
);

$this->menu=array(
	array('label'=>'List Ivamovimiento', 'url'=>array('index')),
	array('label'=>'Create Ivamovimiento', 'url'=>array('create')),
	array('label'=>'Update Ivamovimiento', 'url'=>array('update', 'id'=>$model->idivamovimiento)),
	array('label'=>'Delete Ivamovimiento', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idivamovimiento),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ivamovimiento', 'url'=>array('admin')),
);
?>

<h1>View Ivamovimiento #<?php echo $model->idivamovimiento; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idivamovimiento',
		'tipomoviento',
		'fecha',
		'nrocomprobante',
		'proveedor_idproveedor',
		'cliente_idcliente',
		'cuitentidad',
		'tipofactura',
		'tipoiva',
		'importeiibb',
		'importeiva',
		'importeneto',
		'compra_idcompra',
		'factura_idfactura',
	),
)); ?>