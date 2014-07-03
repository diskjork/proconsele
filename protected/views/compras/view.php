<?php
/* @var $this ComprasController */
/* @var $model Compras */
?>

<?php
$this->breadcrumbs=array(
	'Comprases'=>array('index'),
	$model->idcompra,
);

$this->menu=array(
	array('label'=>'List Compras', 'url'=>array('index')),
	array('label'=>'Create Compras', 'url'=>array('create')),
	array('label'=>'Update Compras', 'url'=>array('update', 'id'=>$model->idcompra)),
	array('label'=>'Delete Compras', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idcompra),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Compras', 'url'=>array('admin')),
);
?>

<h1>View Compras #<?php echo $model->idcompra; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idcompra',
		'nrodefactura',
		'tipofactura',
		'nroremito',
		'fecha',
		'descripcion',
		'formadepago',
		'proveedor_idproveedor',
		'estado',
		'iva',
		'percepcionIIBB',
		'importebruto',
		'ivatotal',
		'importeneto',
		'importeIIBB',
		'movimientocaja_idmovimientocaja',
		'asiento_idasiento',
		'cuenta_idcuenta',
	),
)); ?>