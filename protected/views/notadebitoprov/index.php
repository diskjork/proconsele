<?php
/* @var $this NotadebitoprovController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Notadebitoprovs',
);

$this->menu=array(
	array('label'=>'Create Notadebitoprov','url'=>array('create')),
	array('label'=>'Manage Notadebitoprov','url'=>array('admin')),
);
?>

<h1>Notadebitoprovs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>