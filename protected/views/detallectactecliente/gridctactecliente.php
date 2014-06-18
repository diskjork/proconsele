<?php

$dataProvider= $model->search($model->fecha=$mesTab."/".$anioTab,$model->ctactecliente_idctactecliente);
$dataProvider->setPagination(array('pageSize'=>200)); 
$dataProviderRel=$dataProvider->getData();

//Obtener total debe y haber;
$dataProviderDH=$model->obtenerDebeHaber($mesTab,$anioTab,$model->ctactecliente_idctactecliente);
$dataProviderDebeHaber=$dataProviderDH->getData();
?>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab,'idctactecliente'=>$model->ctactecliente_idctactecliente),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php

$columnas=array_merge(array(
		array(
	    	'value'=>'$this->grid->dataProvider->pagination->currentPage*
	        $this->grid->dataProvider->pagination->pageSize + $row+1',
	        'htmlOptions'=>array('style'=>'text-align:center;width:30px;'),
        ),
		array('name' => 'fecha',
					'header' => 'FECHA',
					'htmlOptions' => array('width' =>'60px'),
			'filter'=>false,
		),
		array('name' => 'descripcion',
					'header' => 'DESCRIPCION',
					'htmlOptions' => array('width' =>'250px'),
								
					),
		array('name' => 'tipo',
					'header' => 'TIPO',
					'htmlOptions' => array('width' =>'160px',
										   'style'=>'padding-right:0px'),
					'value'=>'($data->tipo == 0)? "Factura": "Cobranza"',
			 ),
       	array(
              		'header'=>'DEBE',
              		'name' => 'debe',
					'htmlOptions' => array('width' =>'85px'),
              		'cssClassExpression' => '$data["debe"] > 0 ? "colorDebe": ""',
					'value'=>'($data->debe !== null && $data->debe > 0)?number_format($data->debe, 2, ".", ","): "-"',
              		'footer'=>"$ ".number_format($dataProviderDebeHaber[0]['total_debe']-$dataProviderDebeHaber[0]['total_haber'],2,".",","),
              		'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:center;font-weight:bold;'),
        ),
        array(
			  		'header'=>'HABER',
			  		'name' => 'haber',
					'htmlOptions' => array('width' =>'75px'),
              		'cssClassExpression' => '$data["haber"] > 0 ? "colorHaber": ""',
			  		'value'=>'($data->haber !== null && $data->haber > 0)?number_format($data->haber, 2, ".", ","): "-"',
        ),
        array(
        	'header'=>'Opciones',
        	'headerHtmlOptions'=>array('colspan'=>2),
        	'htmlOptions' => array('colspan'=>2),
        	'footerHtmlOptions'=>array('colspan'=>2),
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{updatefact}{delete}{deletecobranza}',
			'buttons' => array(
				'update'=>array(
					'label'=>'Modificar Cobranza',
	                    //'icon'=>TbHtml::ICON_MINUS_SIGN,
	                    'visible'=>'$data->tipo == 1',
						'url'=> 'Yii::app()->createUrl("cobranza/update",
								 array(	"id"=>$data->iddocumento,
								 		"idctacte"=>$data->ctactecliente_idctactecliente,
								 		"nombre"=>$data->ctacteclienteIdctactecliente->clienteIdcliente,
								 		))',
						
	                  ),
	            'updatefact'=>array(
					'label'=>'Modificar Factura',
	                    'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->tipo == 0',
						'url'=> 'Yii::app()->createUrl("factura/update",
								 array(	"id"=>$data->iddocumento,
								 		
								 		))',
						
	                  ),
	            'delete'=>array(
					'label'=>'Borrar Factura',
	                    //'icon'=>TbHtml::ICON_PENCIL,
	                    'visible'=>'$data->tipo == 0',
						'url'=> 'Yii::app()->createUrl("factura/delete",
								 array(	"id"=>$data->iddocumento,
								 		
								 		))',
	                  'options'=>array('class'=>'delete'),
						
	                  ),
	            'deletecobranza'=>array(
					'label'=>'Borrar Cobranza',
	                    'icon'=>TbHtml::ICON_TRASH,
	                    'visible'=>'$data->tipo == 1',
						'url'=> '$this->grid->controller->createUrl("cobranza/delete",
								 array(	"id"=>$data->iddocumento,
								 		
								 		))',
	                   'options'=>array('class'=>'delete',
	                  		/*	'ajax'=>array(
                                        'type'=>'GET',
                                        'url'=>"js:$(this).attr('href')",
                                        'success'=>'js:function(result){
                                                alert(result);
                                        }',
                               		 ),*/
	                 			 ),
						
	                  ),
		),
		),
	));
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	//'id'=>'detallectactecliente-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>$columnas,
	'template' => "{items}",
	'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
)); ?>

<script type="text/javascript">
<!--

var $table = $("<?php echo "#yw".date("n",strtotime($anioTab."-".$mesTab));?>").children('table');
var $tbody = $table.children('tbody');
$tbody.append('<tr> <td></td> <td></td> <td></td> <td></td> <td><?php echo "$ ".number_format($dataProviderDebeHaber[0]['total_debe'],2,".",",");?></td><td><?php echo "$ ".number_format($dataProviderDebeHaber[0]['total_haber'],2,".",",");?></td><td colspan="2"></td>  </tr>');
//-->
</script>	
