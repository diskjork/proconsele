<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */
?>

<?php
$this->breadcrumbs=array(
	'Proveedors'=>array('index'),
	$model->idproveedor,
);

$this->menu=array(
	array('label'=>'List Proveedor', 'url'=>array('index')),
	array('label'=>'Create Proveedor', 'url'=>array('create')),
	array('label'=>'Update Proveedor', 'url'=>array('update', 'id'=>$model->idproveedor)),
	array('label'=>'Delete Proveedor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idproveedor),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Proveedor', 'url'=>array('admin')),
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
		array(
			'name'=>'Tipo contribuyente',
			'value'=>$model->tipodecontribuyenteIdtipocontribuyente,
		),
		array(
			'name'=>'Localidad',
			'value'=>$model->localidadIdlocalidad,
		),
	),
)); ?>