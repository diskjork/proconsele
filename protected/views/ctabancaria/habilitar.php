<?php
/* @var $this BancoController */
/* @var $model Banco */
?>


<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => '<h4>Habilitar cuenta bancaria desactivada</h4>',
			'content' => $this->renderPartial('propio',array('model'=>$model), true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); ?>
