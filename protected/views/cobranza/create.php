<?php
/* @var $this CobranzaController */
/* @var $model Cobranza */
?>

<?php
$this->breadcrumbs=array(
	'Cobranzas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Volver', 'url'=>Yii::app()->request->Urlreferrer 
			),
	
	
);

?>

	
<h5 class="well well-small" id="titulo"></h5>
<br>	

<?php $this->renderPartial('_form', array('model'=>$model,'member'=>$member,'validatedMembers'=>$validatedMembers)); ?>

