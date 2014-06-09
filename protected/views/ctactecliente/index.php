<?php
/* @var $this CtacteclienteController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Ctacteclientes',
);

$this->menu=array(
	array('label'=>'Create Ctactecliente','url'=>array('create')),
	array('label'=>'Manage Ctactecliente','url'=>array('admin')),
);
?>

<h1>Ctacteclientes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>