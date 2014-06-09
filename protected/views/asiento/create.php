<?php
/* @var $this AsientoController */
/* @var $model Asiento */
?>

<?php
$this->breadcrumbs=array(
	'Asientos'=>array('index'),
	'Nuevo asiento',
);

$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
		'active' => true,
	)
	
);
?>

<h5 class="well well-small">NUEVO ASIENTO</h5>
<br>
<?php $this->renderPartial('_form', array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers)); ?>