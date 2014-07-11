<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'nrocheque',
		'titular',
    	'cuittitular',
		'fechaingreso',
		'fechacobro',
		array(
			'name'=>'debe',
			'value'=> ($model->debe == null)? '0' : $model->debe,
		),
		'haber',
		'Banco_idBanco',
		'proveedor_idproveedor',
		'cliente_idcliente',
		'estado'
				
	),
)); ?>