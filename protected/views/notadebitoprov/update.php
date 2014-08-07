<?php
/* @var $this NotadebitoprovController */
/* @var $model Notadebitoprov */
?>

<?php
$this->breadcrumbs=array(
	'Notadebitoprovs'=>array('index'),
	$model->idnotadebitoprov=>array('view','id'=>$model->idnotadebitoprov),
	'Update',
);
$this->menu=array(
	
	array('label'=>'Administrar', 'url'=>array('admin')),
);
?>

<h5 class="well well-small">ACTUALIZAR NOTA DE DEBITO - PROVEEDOR</h5>
<br><br>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>