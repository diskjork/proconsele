<?php
/* @var $this RetencioniibbController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Retencioniibbs',
);

$this->menu=array(
	array('label'=>'Create Retencioniibb','url'=>array('create')),
	array('label'=>'Manage Retencioniibb','url'=>array('admin')),
);
?>

<h1>Retencioniibbs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>