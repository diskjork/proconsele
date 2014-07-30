<?php
/* @var $this NotacreditoprovController */
/* @var $model Notacreditoprov */
?>

<?php
$this->breadcrumbs=array(
	'Notacreditoprovs'=>array('index'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Administrar', 'url'=>array('admin')),
	array('label'=>'Volver', 'url'=>Yii::app()->request->Urlreferrer 
			),
);
?>

<h5 class="well well-small">CARGAR NUEVA NOTA DE CREDITO - PROVEEDOR</h5>
<br><br>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>