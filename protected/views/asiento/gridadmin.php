<?php
$dataProvider=$model->search($model->fecha=$anioTab."-".$mesTab);
$dataProvider->setPagination(array('pageSize'=>200));
$gridColumns= array(
		array(
				'header'=>'N°',
				'name'=>'idasiento',
				'htmlOptions' => array('width' =>'60px'),
			),
		array(
				'header'=>'FECHA',
				'name'=>'fecha',
				'htmlOptions' => array('width' =>'90px'),
			),
		array(
			'header'=>'DESCRIPCION',
			'name'=>'descripcion',
			'htmlOptions' => array('width' =>'60%',
										'style'=>'text-align:left;'),
		),
		array(
            'header'=>'Opciones',
            'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{actmovbanco}{actmovcaja}{delete}',
            'buttons'=>array(
             /*   'view'=>
                    array(
                        'url'=>'Yii::app()->createUrl("ordendepago/view", array("id"=>$data->idordendepago))',
                        'options'=>array(
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
                            ),
                        ),
                    ),*/
                 'update'=>array(
					'label'=>'Modificar asiento',
	                    //'icon'=>TbHtml::ICON_MINUS_SIGN,
	                    'visible'=>'$data->movimientobanco_idmovimientobanco == NULL AND $data->movimientocaja_idmovimientocaja == NULL',
						'url'=> 'Yii::app()->createUrl("asiento/update",
								 array(	"id"=>$data->idasiento,
								 		
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
	              'actmovbanco'=>array(
					'label'=>'Modificar Mov.Banco',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->movimientobanco_idmovimientobanco != NULL',
						'url'=> 'Yii::app()->createUrl("movimientobanco/update",
								 array(	"id"=>$data->movimientobanco_idmovimientobanco,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
	              'actmovcaja'=>array(
					'label'=>'Modificar Mov.Caja',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->movimientocaja_idmovimientocaja != NULL',
						'url'=> 'Yii::app()->createUrl("movimientocaja/update",
								 array(	"id"=>$data->movimientocaja_idmovimientocaja,
								 		"vista"=>2,
								 		//"nombre"=>$data->ctacteprovIdctacteprov->proveedorIdproveedor->nombre,
								 		))',
						
	                  ),
            ),
           
        ),
		
	);

//Yii::app()->getComponent('yiiwheels')->registerAssetJs('bootbox.min.js');
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	'type' => 'striped bordered',
	'dataProvider' =>$dataProvider,
	'template' => "{items}",
	'columns' => array_merge(
					$gridColumns,
					array(
						array(
								'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
								'name' => 'Visualizar',
								'url' => $this->createUrl('asiento/grilla'),
								'value' =>'""',
								'htmlOptions' => array('width' =>'10%'),
								'cacheData'=>false,
								'afterAjaxUpdate' => 'js:function(tr,rowid,data){
								$("td[colspan]").css("background-color","rgb(222,245,217)");
								//$("span.wh-relational-column[data-rowid="+rowid+"]").find("i").removeClass("icon-chevron-down");
								//$("span.wh-relational-column[data-rowid="+rowid+"]").find("i").addClass("icon-chevron-up");
								}'
							)
						) 	
						),
)); ?>