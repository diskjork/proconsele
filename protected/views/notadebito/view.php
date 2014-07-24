<?php
/* @var $this NotadebitoController */
/* @var $model Notadebito */
?>

<?php
$this->breadcrumbs=array(
	'Notadebitos'=>array('index'),
	$model->idnotadebito,
);

$this->menu=array(
	array('label'=>'List Notadebito', 'url'=>array('index')),
	array('label'=>'Create Notadebito', 'url'=>array('create')),
	array('label'=>'Update Notadebito', 'url'=>array('update', 'id'=>$model->idnotadebito)),
	array('label'=>'Delete Notadebito', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idnotadebito),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notadebito', 'url'=>array('admin')),
);
?>

<h1>View Notadebito #<?php echo $model->idnotadebito; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idnotadebito',
		'nronotadebito',
		'fecha',
		'descripcion',
		'cliente_idcliente',
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