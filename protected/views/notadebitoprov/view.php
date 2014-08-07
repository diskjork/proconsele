<?php
/* @var $this NotadebitoprovController */
/* @var $model Notadebitoprov */
?>

<?php
$this->breadcrumbs=array(
	'Notadebitoprovs'=>array('index'),
	$model->idnotadebitoprov,
);

$this->menu=array(
	array('label'=>'List Notadebitoprov', 'url'=>array('index')),
	array('label'=>'Create Notadebitoprov', 'url'=>array('create')),
	array('label'=>'Update Notadebitoprov', 'url'=>array('update', 'id'=>$model->idnotadebitoprov)),
	array('label'=>'Delete Notadebitoprov', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idnotadebitoprov),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notadebitoprov', 'url'=>array('admin')),
);
?>

<h1>View Notadebitoprov #<?php echo $model->idnotadebitoprov; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idnotadebitoprov',
		'nronotadebitoprov',
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
	),
)); ?>