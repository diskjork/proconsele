<?php
/* @var $this NotacreditoprovController */
/* @var $model Notacreditoprov */
?>

<?php
$this->breadcrumbs=array(
	'Notacreditoprovs'=>array('index'),
	$model->idnotacreditoprov,
);

$this->menu=array(
	array('label'=>'List Notacreditoprov', 'url'=>array('index')),
	array('label'=>'Create Notacreditoprov', 'url'=>array('create')),
	array('label'=>'Update Notacreditoprov', 'url'=>array('update', 'id'=>$model->idnotacreditoprov)),
	array('label'=>'Delete Notacreditoprov', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idnotacreditoprov),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notacreditoprov', 'url'=>array('admin')),
);
?>

<h1>View Notacreditoprov #<?php echo $model->idnotacreditoprov; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idnotacreditoprov',
		'nrodefactura',
		'tipofactura',
		'fecha',
		'descripcion',
		'proveedor_idproveedor',
		'estado',
		'iva',
		'percepcionIIBB',
		'importebruto',
		'ivatotal',
		'importeneto',
		'importeIIBB',
		'asiento_idasiento',
		'cuenta_idcuenta',
		'compras_idcompras',
		'nronotacreditoprov',
	),
)); ?>