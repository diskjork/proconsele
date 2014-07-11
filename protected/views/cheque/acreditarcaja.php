<?php   $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => 'Acreditar Cheque',
			'content' => $this->renderPartial('_formacreditarcaja', array('model'=>$modelCheque,'modelCaja'=>$modelCaja),true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
					
));

?>
