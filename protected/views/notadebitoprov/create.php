<?php
/* @var $this NotadebitoprovController */
/* @var $model Notadebitoprov */
?>

<?php
$this->breadcrumbs=array(
	'Notadebitoprovs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Notadebitoprov', 'url'=>array('index')),
	array('label'=>'Manage Notadebitoprov', 'url'=>array('admin')),
);
$this->menu=array(
	array(
		'label'=>'Admnistrar', 
		'url'=>array('admin'),
	),
	array('label'=>'Volver', 'url'=>Yii::app()->request->Urlreferrer 
			),
	
);
?>

<h5 class="well well-small" >CARGAR NUEVA NOTA DE DEBITO - PROVEEDOR</h5>
<br><br>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>