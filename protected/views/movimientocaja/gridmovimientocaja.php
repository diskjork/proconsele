
<?php 
$n=04;
$dataProvider= $model->search($model->fecha=$mesTab."/".$anioTab);
$dataProvider->setPagination(array('pageSize'=>200)); 
$dataProviderRel=$dataProvider->getData();
//Obtener total debe y haber;
$dataProviderDH=$model->obtenerDebeHaber($mesTab,$anioTab);
$dataProviderDebeHaber=$dataProviderDH->getData();
?>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php
$columnas=array_merge(array(
				array(
                    'value'=>'$this->grid->dataProvider->pagination->currentPage*
              	    $this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
       				),
			  
          	  array(
          	  		'header'=>'FECHA',
          	  		'name' => 'fecha',
					'htmlOptions' => array('width' =>'50px'),
          	  		'filter'=>"",
          	  		),
          	array(
          	  		'header'=>'DESCRIPCION',
					'name' => 'descripcion',
          	  		),
              array(
              		'header'=>'INGRESOS',
              		'name' => 'debe',
					'htmlOptions' => array('width' =>'75px'),
              		'cssClassExpression' => '$data["debe"] > 0 ? "colorDebe": ""',
					'value'=>'($data->debe !== null && $data->debe > 0)?number_format($data->debe, 2, ".", ","): "-"',
              		'footer'=>"$ ".number_format($dataProviderDebeHaber[0]['total_debe']-$dataProviderDebeHaber[0]['total_haber'],2,".",","),
              		'footerHtmlOptions'=>array('colspan'=>2 ,'style'=>'text-align:center;font-weight:bold;'),
              ),
			  array(
			  		'header'=>'EGRESOS',
			  		'name' => 'haber',
					'htmlOptions' => array('width' =>'75px'),
              		'cssClassExpression' => '$data["haber"] > 0 ? "colorHaber": ""',
			  		'value'=>'($data->haber !== null && $data->haber > 0)?number_format($data->haber, 2, ".", ","): "-"',
  			),
			 array(
	            'header'=>'Opciones',
	            'class'=>'bootstrap.widgets.TbButtonColumn',
			 	'template' => '{Factura compra} {Factura venta} {Cobranza} {view} {update} {delete}',
	            'buttons'=>array(
	                'Factura compra'=>
	                    array(
	                    	'icon'=>TbHtml::ICON_PLUS_SIGN,
	                        'url'=>'$data["debeohaber"] == 0 ? Yii::app()->createUrl("factura/view", array("id"=>$data->id_de_trabajo)):Yii::app()->createUrl("compras/view", array("id"=>$data->id_de_trabajo))',
	                        'visible'=>'$data["rubro_idrubro"] == 2 ',
	                        'options'=>array(
	                            'ajax'=>array(
	                                'type'=>'POST',
	                                'url'=>"js:$(this).attr('href')",
	                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
	                            ),
	                        ),
	                    ),
	                'Factura venta'=>
	                    array(
	                    	'icon'=>TbHtml::ICON_PLUS_SIGN,
	                        'url'=>'$data["debeohaber"] == 0 ? Yii::app()->createUrl("factura/view", array("id"=>$data->id_de_trabajo)):Yii::app()->createUrl("compras/view", array("id"=>$data->id_de_trabajo))',
	                        'visible'=>'$data["rubro_idrubro"] == 4 ',
	                        'options'=>array(
	                            'ajax'=>array(
	                                'type'=>'POST',
	                                'url'=>"js:$(this).attr('href')",
	                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
	                            ),
	                        ),
	                    ),
	                'Cobranza'=>
	                    array(
	                    	'icon'=>TbHtml::ICON_PLUS_SIGN,
	                        'url'=>'Yii::app()->createUrl("cobranza/view", array("id"=>$data->id_de_trabajo))',
	                    	'visible'=>'$data["rubro_idrubro"]==5',
	                        'options'=>array(
	                            'ajax'=>array(
	                                'type'=>'POST',
	                                'url'=>"js:$(this).attr('href')",
	                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
	                            ),
	                        ),
	                    ),
	                 'view'=>
	                    array(
	                        'url'=>'Yii::app()->createUrl("movimientocaja/view", array("id"=>$data->idmovimientocaja))',
	                        'options'=>array(
	                            'ajax'=>array(
	                                'type'=>'POST',
	                                'url'=>"js:$(this).attr('href')",
	                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
	                            ),
	                        ),
	                    ),
	                    
	            ),
	            'headerHtmlOptions'=>array('colspan'=>2),
	            'htmlOptions' => array('colspan'=>2),
	            'footerHtmlOptions'=>array('colspan'=>2),
	        ),
		));?>


	<?php 
	$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	    'filter'=>$model,
	    //'fixedHeader' => false,
	    //'headerOffset' => 20, // height of the main navigation at bootstrap
	    'dataProvider' => $dataProvider,
	    'columns' => $columnas,
		'template' => "{items}{pager}",
		'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
		
	));

?>
<script type="text/javascript">
<!--

var $table = $("<?php echo "#yw".date("n",strtotime($anioTab."-".$mesTab));?>").children('table');
var $tbody = $table.children('tbody');
$tbody.append('<tr> <td></td> <td></td> <td></td> <td><?php echo "$ ".number_format($dataProviderDebeHaber[0]['total_debe'],2,".",",");?></td><td><?php echo "$ ".number_format($dataProviderDebeHaber[0]['total_haber'],2,".",",");?></td><td colspan=2></td>  </tr>');
//-->
</script>	
