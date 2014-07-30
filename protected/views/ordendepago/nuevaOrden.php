<?php   $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => 'Acreditar Cheque',
			'content' => $this->renderPartial('_proveedores', array('model'=>$model,
																	'member'=>$member,
														        	'validatedMembers' => $validatedMembers,
																	'modelchequecargado'=> $modelchequecargado,),true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
			'footer'=>array(CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/cheque/recibido',array ('class'=>'btn btn-primary'))),
			
			
));

?>