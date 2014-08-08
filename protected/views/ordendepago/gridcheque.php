<?php 
$colum=array(
	array(
					'header' => '#',
                    'value'=>'$this->grid->dataProvider->pagination->currentPage*
              	    $this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
       				),
		array('name' => 'nrocheque',
					'header' => 'NRO. CHEQUE',
					),
		array('name' => 'fechacobro',
					'header' => 'F. COBRO',
					),
		array(
			'header'=>'LIBERADO POR:',
			'value'=>'$data->cliente_idcliente != NULL ? $data->clienteIdcliente : "YVN S.R.L."',
			'htmlOptions' => array('width' =>'150px','style'=>'text-align:center'),
		),
		array(
			'header'=>'TITULAR:',
			'value'=>'$data->cliente_idcliente != NULL ? $data->titular : "YVN S.R.L."',
			'htmlOptions' => array('width' =>'150px','style'=>'text-align:center'),
		),
		array(
			'header'=>'CUIT TITULAR',
			'value'=>'$data->cliente_idcliente != NULL ? $data->cuittitular : "-"',
			'htmlOptions' => array('width' =>'150px','style'=>'text-align:center'),
		),
		array('name' => 'Banco_idBanco',
					'header' => 'BANCO',
					'value'=> '$data->bancoIdBanco',
					'htmlOptions' => array('width' =>'150px'),
			'filter' => CHtml::activeDropDownList($modelchequecargado, 'Banco_idBanco', CHtml::listData(Banco::model()->findAll(), 'idBanco', 'nombre'), array('prompt' => ' ')),
		),	
		array(	
			'name' => 'debe',
			'header' => 'IMPORTE',
			//'htmlOptions' => array('width' =>'30px'),
			'value'=>'($data->debe !== null)?number_format($data->debe, 2, ".", ","): ""',			
					
		),
		
		
	);
		
		$dataProvider=$modelchequecargado->search($modelchequecargado->estado= 2);
		$dataProvider->setPagination(array('pageSize'=>20)); 
	$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'chequeparaendozar',
		'filter'=>$modelchequecargado,
    	//'fixedHeader' => true,
    	//'headerOffset' => 40, // 40px is the height of the main navigation at bootstrap
    	'type'=>'striped bordered',
    	'dataProvider' => $dataProvider,
		'columns'=>$colum,
		'selectionChanged'=>'cargardatos',
		'template' => "{items}{pager}",
		'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
		
)); 
		?>
<script type="text/javascript">
<!-- para cargar los datos en la factura
//-->

function cargardatos(target_id){
	var id=$.fn.yiiGridView.getSelection(target_id);
	var idselec=objetoseleccionado.id;
	
	$.ajax({
		  type: "POST",
		  url: '<?php echo $this->createUrl('envio');?>',
		  data: {data:id},
		  success: function (data){
			  
			  var idcheque=viewid(1,1,idselec,9);
			  var idchequebanco=viewid(1,1,idselec,3);
			  var idtitular=viewid(1,1,idselec,10);
			  var idcuittitular=viewid(1,1,idselec,11);
			  var idfeingreso=viewid(1,1,idselec,4);
			  var idfecobro=viewid(1,1,idselec,5);
			  var idnrocheque=viewid(1,1,idselec,6);
			  var idimporte=viewid(1,1,idselec,7);
			  var idchequebanco=viewid(1,1,idselec,3);
			  obj={id:idselec, val:data.idcheque};//paso el id del obj seleccionado y el valor que traigo de la DB
			  validaciondecodigo(obj); //para validar si el cheque ya está cargado o no
			  $('#'+idcheque).val(data.idcheque);
			  $('#'+idchequebanco).val(data.banco);
			  $('#'+idtitular).val(data.titular);
			  $('#'+idcuittitular).val(data.cuittitular);
			  $('#'+idfeingreso).val(data.feingreso);
			  $('#'+idfecobro).val(data.fecobro);
			  $('#'+idnrocheque).val(data.nrocheque);
			  $('#'+idimporte).val(data.importe);
			  //$('#'+idimporte).attr('readonly','true');
			  $('#ModalChequecargados').modal('hide');
			  sumatotal();
			  },
		  dataType: "json"
		  });
}
</script>		

		