<?php
/* @var $this ChequeController */
/* @var $model Cheque */
?>

<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => '<h4>Cargar Movimiento Cheque</h4>',
			'content' => $this->renderPartial('_form', array('model'=>$model),true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); 
?>