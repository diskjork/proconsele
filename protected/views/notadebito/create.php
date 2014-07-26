<?php
/* @var $this NotadebitoController */
/* @var $model Notadebito */
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
		'label'=>'Nueva NOTA DEDITO',
		'url'=>array('create'),
		'active' => true,
	),
);
?>

<h5 class="well well-small" >CARGAR NUEVA NOTA DE DEBITO</h5>
<br><br>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>