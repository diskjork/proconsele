<?php   $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => 'Endozar Cheque',
			'content' => $this->renderPartial('_acreditarendozar', array('modelcheque'=>$modelcheque,'model'=>$model,
                          'member'=>$member,'validatedMembers'=>$validatedMembers),true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
			
));

?>



