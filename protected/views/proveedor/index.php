<?php
/* @var $this ProveedorController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Proveedors',
);

$this->menu=array(
	array('label'=>'Create Proveedor','url'=>array('create')),
	array('label'=>'Manage Proveedor','url'=>array('admin')),
);
?>

<h1>Proveedors</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>