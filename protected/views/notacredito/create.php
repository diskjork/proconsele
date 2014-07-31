<?php
/* @var $this NotacreditoController */
/* @var $model Notacredito */
?>

<?php
$this->breadcrumbs=array(
	'Notacreditos'=>array('index'),
	'Create',
);

$this->menu=array(
	array(
		'label'=>'Admnistrar', 
		'url'=>array('admin'),
	),
	array(
		'label'=>'Nueva NOTA CREDITO',
		'url'=>array('create'),
		'active' => true,
	),
	array('label'=>'Volver', 'url'=>Yii::app()->request->Urlreferrer 
			),
);
?>

<h5 class="well well-small">CARGAR NUEVA NOTA DE CREDITO</h5>
<br><br>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>