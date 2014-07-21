<?php 

$colum=array(
			array(	'name' => 'idproducto',
					'header'=>'Código',
					'htmlOptions' => array('width' =>'50px'),
						),
			
			array('name' => 'nombre',
					'header'=>'Nombre Producto',
						'htmlOptions' => array('width' =>'400px'),
						// 'filter' => CHtml::activeTextField($modelproducto, 'nombre'),
						),
			
			array('name' => 'precio',
					'header'=>'Precio',
					'filter'=>false,
					'htmlOptions' => array('width' =>'50px'),
					'value'=>'($data->precio !== null)?number_format($data->precio, 2, ".", ","): ""',
						
						),
			
			
			array('name' => 'unidaddeventa',
					'header'=>'Unidad venta',
						'htmlOptions' => array('width' =>'100px'),
						'filter'=>false,
						),
			
		);
		$dataProvider=$modelproducto->search($modelproducto->estado= 1);
		$dataProvider->setPagination(array('pageSize'=>20)); 
	$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'productogrid',
		'filter'=>$modelproducto,
    	//'fixedHeader' => true,
    	//'headerOffset' => 40, // 40px is the height of the main navigation at bootstrap
    	'type'=>'striped bordered',
    	'dataProvider' => $dataProvider,
		'columns'=>$colum,
		'selectionChanged'=>'cargardatos',
		'type' => array(TbHtml::GRID_TYPE_CONDENSED,TbHtml::GRID_TYPE_BORDERED,TbHtml::GRID_TYPE_HOVER),
		
)); 
		?>
<script type="text/javascript">
<!-- para cargar los datos en la factura
//-->
function cargardatos(target_id){
	var id=$.fn.yiiGridView.getSelection(target_id);
	//var idselec=objetoseleccionado.id;
	//indexid = idselec.substring(25,idselec.length);
	$.ajax({
		  type: "POST",
		  url: '<?php echo $this->createUrl('envio');?>',
		  data: {data:id},
		  success: function (data){
			  
			  var cantidad=parseFloat($('#Factura_cantidadproducto').val());
			  var precio= parseFloat(data.precio);
			  var subtotal=cantidad*precio;
			 
			  $('#Factura_nombreproducto').val(data.nombre+" (x "+data.venta+")");
			  $('#Factura_producto_idproducto').val(data.idp);
			  $('#Factura_precioproducto').val(data.precio);
			  $('#Factura_stbruto_Producto').val(subtotal.toFixed(2));
			  $('#ModalProducto').modal('hide');
			  var idcantidad="Factura_cantidadproducto";
			  	sumaSubtotal(idcantidad);
			  	sumatotal();
				botonsubmit();
			  },
		  dataType: "json"
		  });
}
</script>		

		