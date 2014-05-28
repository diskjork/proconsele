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
								'cacheData'=>false,
														/*'afterAjaxUpdate' => 'js:function(tr,rowid,data){
								
								//$("span.wh-relational-column[data-rowid="+rowid+"]").find("i").removeClass("icon-chevron-down");
								//$("span.wh-relational-column[data-rowid="+rowid+"]").find("i").addClass("icon-chevron-up");
								}'*/
							)
						) 	
						),
)); ?>