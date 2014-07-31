<?php
/* @var $this NotacreditoprovController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Notacreditoprovs',
);

$this->menu=array(
	array('label'=>'Create Notacreditoprov','url'=>array('create')),
	array('label'=>'Manage Notacreditoprov','url'=>array('admin')),
);
?>

<h1>Notacreditoprovs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>