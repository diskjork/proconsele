<?php   $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => 'Acreditar Cheque',
			'content' => $this->renderPartial('_acreditarbotones', array('model'=>$model,'modelBanco'=>$modelBanco),true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
			'footer'=>array(CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/cheque/recibido',array ('class'=>'btn btn-primary'))),
			
			
));
//echo "hola como estas";
?>
