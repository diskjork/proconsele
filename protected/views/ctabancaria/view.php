<?php
/* @var $this CtabancariaController */
/* @var $model Ctabancaria */
?>

<?php
$this->breadcrumbs=array(
	'Ctabancarias'=>array('index'),
	$model->idctabancaria,
);

$this->menu=array(
	array('label'=>'List Ctabancaria', 'url'=>array('index')),
	array('label'=>'Create Ctabancaria', 'url'=>array('create')),
	array('label'=>'Update Ctabancaria', 'url'=>array('update', 'id'=>$model->idctabancaria)),
	array('label'=>'Delete Ctabancaria', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idctabancaria),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ctabancaria', 'url'=>array('admin')),
);
?>

<h1>View Ctabancaria #<?php echo $model->idctabancaria; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idctabancaria',
		'nombre',
		'descripcion',
		'banco_idBanco',
		'tipoctabancaria_idtipoctabancaria',
		'estado',
	),
)); ?>