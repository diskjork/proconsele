<?php
/* @var $this ProductoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Productos',
);

$this->menu=array(
	array('label'=>'Create Producto','url'=>array('create')),
	array('label'=>'Manage Producto','url'=>array('admin')),
);
?>

<h1>Productos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>