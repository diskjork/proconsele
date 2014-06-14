<?php
$this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'idmovimientobanco',
		'descripcion',
		'fecha',
		'debe',
		'haber',
		'numerooperacion',
		'rubro_idrubro',
		'Banco_idBanco',
		'formadepago_idformadepago',
		'cheque_idcheque',
	),
));
?>