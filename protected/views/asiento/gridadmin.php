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
			'template'=>'{update}{delete}',
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
	                    
						'url'=> 'Yii::app()->createUrl("asiento/update",
								 array(	"id"=>$data->idasiento,
								 		//"idctacte"=>$data->ctacteprov_idctacteprov,
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