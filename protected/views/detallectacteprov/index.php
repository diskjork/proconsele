<?php
/* @var $this DetallectacteprovController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Detallectacteprovs',
);

$this->menu=array(
	array('label'=>'Create Detallectacteprov','url'=>array('create')),
	array('label'=>'Manage Detallectacteprov','url'=>array('admin')),
);
?>

<h1>Detallectacteprovs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>