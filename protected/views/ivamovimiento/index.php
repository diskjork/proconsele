<?php
/* @var $this IvamovimientoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Ivamovimientos',
);

$this->menu=array(
	array('label'=>'Create Ivamovimiento','url'=>array('create')),
	array('label'=>'Manage Ivamovimiento','url'=>array('admin')),
);
?>

<h1>Ivamovimientos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>