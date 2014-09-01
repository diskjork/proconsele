

<?php 
	$dataProvider= $model->generarGrillaSaldos($anioTab,$mesTab,$bancoid);
	//print_r($dataProvider); die();
	
	
	
?>
<div id="iconoExportar" align="right">
<?php echo TbHtml::tooltip(TbHtml::labelTb("<i class='icon-download-alt icon-white'></i>", array("color" => TbHtml::LABEL_COLOR_SUCCESS)),array('Excel','mesTab'=>$mesTab,'anioTab'=>$anioTab,'idbanco'=>$bancoid),'Exportar',array('placement' => TbHtml::TOOLTIP_PLACEMENT_RIGHT)); ?>
</div>
<?php	
	$colum=array_merge(array(
			array(
					'header' => '#',
                    'value'=>'$this->grid->dataProvider->pagination->currentPage*
              	    $this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
       				),
			array(
				//'name' => 'fecha',
				'header'=>'FECHA',
				'value'=>'DateTime::createFromFormat("Y-m-d", $data["fecha"])->format("d/m/Y")',
						'htmlOptions' => array('width' =>'100px'),
						'filter'=>"",
						),
			array(
				//'name' => 'descripcion',
				'header'=>'DESCRIPCION',
				'value'=>'$data["descr"]',
						'htmlOptions' => array('width' =>'400px')
						),
			
			array(
				//'name' => 'debe',
				'header'=>'INGRESOS',	
				'cssClassExpression' => '$data["debe"] > 0 ? "colorDebe": ""',
				'htmlOptions' => array('width' =>'100px'),
				'value'=>'($data["debe"] !== null && $data["debe"] > 0)?"$".number_format($data["debe"], 2, ".", ","): "-"',
				//'footer'=>"(T.D:$".number_format($dataProviderDebeHaber[0]['total_debe'],2,".",",").")  (T.H:$".number_format($dataProviderDebeHaber[0]['total_haber'],2,".",",").")",
				//'footer'=>"$ ".number_format($dataProviderDebeHaber[0]['total_debe']-$dataProviderDebeHaber[0]['total_haber'],2,".",","),
				//'footer'=>"$".number_format($dataProviderDebeHaber[0]['total_debe'],2,".",","),
				//'footerHtmlOptions'=>array('colspan'=>2 ,'style'=>'text-align:center;font-weight:bold;'),
			),
						
			array(
				//  'name' => 'haber',
				'header'=>'EGRESOS',
				'cssClassExpression' => '$data["haber"] > 0 ? "colorHaber": ""',
				'htmlOptions' => array('width' =>'100px'),
				'value'=>'($data["haber"] !== null && $data["haber"] > 0)?"$".number_format($data["haber"], 2, ".", ","): "-"',
				//'footer'=>"$".number_format($dataProviderDebeHaber[0]['total_haber'],2,".",","),
				
			),
			 array(
			  		'header'=>'SALDO',
			  		//'name' => 'saldo',
					'htmlOptions' => array('width' =>'75px'),
              		//'cssClassExpression' => '$data["haber"] > 0 ? "colorHaber": ""',
			  		'value'=>'"$".number_format($data["saldo"], 2, ".", ",")',
        ),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				 'header'=>'Opciones',
				'template' => ' {view}{update}{updateasiento}',
				'buttons'=>array(
					 'view'=>
	                    array(
	                    	'label'=>'Ver asiento contable',
	                        'url'=>'Yii::app()->createUrl("asiento/update", array("id"=>$data["asiento_idasiento"],"vista"=>1))',
	                       /* 'options'=>array(
	                            'ajax'=>array(
	                                'type'=>'POST',
	                                'url'=>"js:$(this).attr('href')",
	                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
	                            ),
	                        ),*/
	                    ),
	                    'update'=>
	                    array(
	                    	'label'=>'Modificar',
	                    	'visible'=>'$data["asiento_idasiento"] != NULL AND
	                    				$data["desdeasiento"] == NULL',
	                  	),
	                  	'updateasiento'=>
	                    array(
	                    	'label'=>'Modificar asiento',
	                    	'icon'=>TbHtml::ICON_PENCIL,
	                    	'visible'=>'$data["asiento_idasiento"] == NULL AND
	                    				$data["desdeasiento"] != NULL',
	                    	'url'=>'Yii::app()->createUrl("asiento/update", array("id"=>$data["desdeasiento"]))',
	                  )
					),
				'headerHtmlOptions'=>array('colspan'=>2),
	            'htmlOptions' => array('colspan'=>2),
	            'footerHtmlOptions'=>array('colspan'=>2),
				),
));
	$this->widget('yiiwheels.widgets.grid.WhGridView',array(
		'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
		'dataProvider'=>$dataProvider,
		'filter'=>$model,
		'template' => "{items}{pager}",
		'columns'=>$colum,
		//'id'=>$bancoid."-".$anioTab."-".$mesTab,
		
)); 



	