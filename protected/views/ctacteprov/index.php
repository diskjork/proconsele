<?php
/* @var $this CtacteprovController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Ctacteprovs',
);

$this->menu=array(
	array('label'=>'Create Ctacteprov','url'=>array('create')),
	array('label'=>'Manage Ctacteprov','url'=>array('admin')),
);
?>

<h1>Ctacteprovs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>