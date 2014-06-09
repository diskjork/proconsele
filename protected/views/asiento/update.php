<?php
/* @var $this AsientoController */
/* @var $model Asiento */
?>

<?php
$this->breadcrumbs=array(
	'Asientos'=>array('index'),
	$model->idasiento=>array('view','id'=>$model->idasiento),
	'Actualizar',
);

$this->menu=array(
	array(
		'label'=>'Administrar', 
		'url'=>array('admin'),
		'active' => true,
	),
	array(
		'label'=>'Nuevo asiento', 
		'url'=>array('/asiento/create'),
	),
);
?>

    <h5 class="well well-small">ACTUALIZACIÓN ASIENTO N°: <?php echo $model->idasiento; ?></h5>
	<br>
<?php $this->renderPartial('_form', array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers)); ?>