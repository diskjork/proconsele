<?php
/* @var $this OrdendepagoController */
/* @var $model ordendepago */
?>

<?php
$this->breadcrumbs=array(
	'Orden de pago'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Volver', 'url'=>Yii::app()->request->Urlreferrer 
			),
);

?>

	
<h5 class="well well-small" id="titulo"></h5>
<br>	

<?php $this->renderPartial('_form', array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers,'modelchequecargado'=>$modelchequecargado)); ?>

