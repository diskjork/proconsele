<?php
/* @var $this TipodecontribuyenteController */
/* @var $model Tipodecontribuyente */
?>

<?php
$this->breadcrumbs=array(
	'Tipodecontribuyentes'=>array('index'),
	$model->idtipodecontribuyente,
);

$this->menu=array(
	array('label'=>'List Tipodecontribuyente', 'url'=>array('index')),
	array('label'=>'Create Tipodecontribuyente', 'url'=>array('create')),
	array('label'=>'Update Tipodecontribuyente', 'url'=>array('update', 'id'=>$model->idtipodecontribuyente)),
	array('label'=>'Delete Tipodecontribuyente', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idtipodecontribuyente),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tipodecontribuyente', 'url'=>array('admin')),
);
?>

<?php $this->widget('yiiwheels.widgets.detail.WhDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
	),
    'type' => 'striped bordered',
    
    'data'=>$model,
    'attributes'=>array(
		'nombre',
		'iva',
	),
)); ?>