<?php
/* @var $this NotadebitoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Notadebitos',
);

$this->menu=array(
	array('label'=>'Create Notadebito','url'=>array('create')),
	array('label'=>'Manage Notadebito','url'=>array('admin')),
);
?>

<h1>Notadebitos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>