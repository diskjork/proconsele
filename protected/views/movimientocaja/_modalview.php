<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idmovimientocaja',
		'descripcion',
		'fecha',
		'debe',
		'haber',
		'numerooperacion',
		'cajaIdcaja',
		'rubroIdrubro',
		//'formadepagoIdformadepago',
	),
)); ?>