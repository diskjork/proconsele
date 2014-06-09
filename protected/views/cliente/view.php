<?php
/* @var $this ClienteController */
/* @var $model Cliente */
?>

<?php
$this->breadcrumbs=array(
	'Clientes'=>array('index'),
	$model->idcliente,
);

$this->menu=array(
	array('label'=>'List Cliente', 'url'=>array('index')),
	array('label'=>'Create Cliente', 'url'=>array('create')),
	array('label'=>'Update Cliente', 'url'=>array('update', 'id'=>$model->idcliente)),
	array('label'=>'Delete Cliente', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idcliente),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cliente', 'url'=>array('admin')),
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
		'cuit',
		'direccion',
		'telefono',
		'nombrecontacto',
		'email',
		'web',
		'localidadIdlocalidad',
		'tipodecontribuyenteIdtipocontribuyente',
	),
)); ?>