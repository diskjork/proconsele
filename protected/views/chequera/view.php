<?php
/* @var $this ChequeraController */
/* @var $model Chequera */
?>

<?php
$this->breadcrumbs=array(
	'Chequeras'=>array('index'),
	$model->idchequera,
);

$this->menu=array(
	array('label'=>'List Chequera', 'url'=>array('index')),
	array('label'=>'Create Chequera', 'url'=>array('create')),
	array('label'=>'Update Chequera', 'url'=>array('update', 'id'=>$model->idchequera)),
	array('label'=>'Delete Chequera', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idchequera),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Chequera', 'url'=>array('admin')),
);
?>

<h1>View Chequera #<?php echo $model->idchequera; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idchequera',
		'nombre',
		'descripcion',
		'estado',
		'tipo',
		'ctabancaria_idctabancaria',
	),
)); ?>