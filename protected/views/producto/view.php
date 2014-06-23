<?php
/* @var $this ProductoController */
/* @var $model Producto */
?>

<?php
$this->breadcrumbs=array(
	'Productos'=>array('index'),
	$model->idproducto,
);

$this->menu=array(
	array('label'=>'List Producto', 'url'=>array('index')),
	array('label'=>'Create Producto', 'url'=>array('create')),
	array('label'=>'Update Producto', 'url'=>array('update', 'id'=>$model->idproducto)),
	array('label'=>'Delete Producto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idproducto),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Producto', 'url'=>array('admin')),
);
?>

<?php $this->widget('yiiwheels.widgets.detail.WhDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
	),
    'type' => 'striped bordered',
    
    'data'=>$model,
     'attributes'=>array(
		//'idproducto',
		'nombre',
		'descripcion',
		//'costoproduccion',
		//'costomateriaprima',
		//'modified',
	),
)); ?>