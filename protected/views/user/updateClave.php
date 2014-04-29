<?php
$this->breadcrumbs=array(
	'User'=>array('index'),
	$model->iduser=>array('view','id'=>$model->iduser),
	'Actualizar clave',
);

?>
<div id="anchoFormLogin">
<h5 class="well well-small">CAMBIAR CONTRASEÑA</h5>
<br>
<?php echo $this->renderPartial('_formpass',array('model'=>$model)); ?>
