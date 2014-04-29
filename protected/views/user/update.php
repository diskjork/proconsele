<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
			'header' => '<h4>Actualizar Usuario</h4>',
			'content' => $this->renderPartial('_form',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); 
?>