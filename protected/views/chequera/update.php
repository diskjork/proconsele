<?php
/* @var $this ChequeraController */
/* @var $model Chequera */
?>

<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalcreate',
    		'header' => '<h4>Actualizar chequera</h4>',
			'content' => $this->renderPartial('_form',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); 
?>