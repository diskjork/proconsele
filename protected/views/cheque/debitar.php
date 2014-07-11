<?php  $this->widget('bootstrap.widgets.TbModal', array(
    		'id' => 'modalup',
    		'header' => 'Debitar Cheque',
			'content' => $this->renderPartial('_formdebitar', array('model'=>$model,'modelBanco'=>$modelBanco),true),
			'show'=>true,
			'backdrop'=> 'static',
			'fade'=>false,
			'keyboard'=> false,
			'buttonOptions'=> false,
			'closeText'=>"",
)); 
?>
