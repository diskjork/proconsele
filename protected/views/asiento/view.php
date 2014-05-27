<?php
/* @var $this AsientoController */
/* @var $model Asiento */
?>

<?php
$this->breadcrumbs=array(
	'Asientos'=>array('index'),
	$model->idasiento,
);

$this->menu=array(
	array('label'=>'List Asiento', 'url'=>array('index')),
	array('label'=>'Create Asiento', 'url'=>array('create')),
	array('label'=>'Update Asiento', 'url'=>array('update', 'id'=>$model->idasiento)),
	array('label'=>'Delete Asiento', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idasiento),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Asiento', 'url'=>array('admin')),
);
?>

<h1>View Asiento #<?php echo $model->idasiento; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idasiento',
		'fecha',
		'descripcion',
	),
)); ?>