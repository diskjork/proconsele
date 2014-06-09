<?php
/* @var $this DetallectacteclienteController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Detallectacteclientes',
);

$this->menu=array(
	array('label'=>'Create Detallectactecliente','url'=>array('create')),
	array('label'=>'Manage Detallectactecliente','url'=>array('admin')),
);
?>

<h1>Detallectacteclientes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>