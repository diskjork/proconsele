
<?php

$gridColumns= array(
	array(
			'header'=>'CUENTA',
			'name'=>'cuentaIdcuenta',
			'htmlOptions' => array('width' =>'60%',
										'style'=>'text-align:left;'),
		),
	array(
			'header'=>'DEBE',
			'name'=>'debe',
		'htmlOptions' => array('width' =>'10%'),
		),
		array(
			'header'=>'HABER',
			'name'=>'haber',
		'htmlOptions' => array('width' =>'10%'),
		),
		
	);
	
	$this->widget('yiiwheels.widgets.grid.WhGridView',array(
	//'id'=>'caja-grid',
	'dataProvider'=>new CArrayDataProvider($model,
	array(
            'id'=>'iddetalleasiento',
            'keys'=>array('debe', 'haber', 'cuenta_idcuenta', 'asiento_idasiento', 'proveedor_idproveedor','cliente_idcliente','iddocumento'),
            
            'pagination'=>array(
                'pageSize'=>15,
            ),
        )),
	
	//'filter'=>$model,
	'columns'=>$gridColumns,
    'template' => "{items}{pager}",
		'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
));
?>

