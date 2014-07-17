<?php 
	if ($factura->formadepago!=99999){
		$contadoTemp="X";
		$ccTemp="";
	}elseif($factura->formadepago===99999){
		$contadoTemp="";
		$ccTemp="X";
	}

	if ($factura->clienteIdcliente->tipodecontribuyente_idtipocontribuyente==1){
		$ri="X";
	}else{
		$ri="";
	}

	if ($factura->tipodescrecar==0 AND $factura->descrecar!=NULL){
		$descuento="$ ".number_format(($factura->importebruto+$factura->ivatotal)*($factura->descrecar/100),2, ".", ",");
		$subtotalRecDes=$factura->importebruto-$descuento;
		$recargo="";
	}else if ($factura->tipodescrecar==1 AND $factura->descrecar!=NULL){
		$descuento="";
		$recargo="$ ".number_format(($factura->importebruto+$factura->ivatotal)*($factura->descrecar/100),2, ".", ",");
		$subtotalRecDes=$factura->importebruto+$recargo;
	}else{
		$recargo="";
		$descuento="";
		$subtotalRecDes=$factura->importebruto;
	}
	$e=0;
	$factura->importeIIBB;
?>

<div id="apDiv1">
	<div id="fecha"><?php echo $factura->fecha;?></div>
  	<div id="nombre"><?php echo $factura->clienteIdcliente;?></div>
   	<div id="direccion"><?php echo $factura->clienteIdcliente->direccion;?></div>
   	<div id="cuit"><?php echo $factura->clienteIdcliente->cuit;?></div>
   	<div id="remito"><?php echo $factura->nroremito;?></div>
   	<div id="contado"><?php echo $contadoTemp;?></div>
   	<div id="cc"><?php echo $ccTemp;?></div>
   	<div id="ri"><?php echo $ri;?></div>
   	<div id="cantidad" style="margin-top:<?php echo $e;?>;"><?php echo $factura->cantidadproducto;?></div>
  	<div id="descripcion"  style="margin-top:<?php echo $e;?>;"><?php echo $factura->nombreproducto;?></div>
	<div id="preciounitario"  style="margin-top:<?php echo $e;?>;"><?php echo "$ ".$factura->precioproducto;?></div>
	<div id="importe"  style="margin-top:<?php echo $e;?>;"><?php echo "$ ".$factura->stbruto_producto;?></div>
  	<div id="impuesto"><?php echo $factura->importeImpInt;?></div>
  	<div id="descuento"><?php echo $descuento;?></div>
  	<div id="recargo"><?php echo $recargo;?></div>
  	<div id="subtotal"><?php echo "$ ".$factura->importebruto;?></div>
  	<div id="iva"><?php echo $factura->iva;?></div>
  	<div id="importeiva"><?php echo "$ ".$factura->ivatotal;?></div>
  	<div id="subtotaliva"><?php echo "$ ".($subtotalRecDes+$factura->ivatotal);?></div>
  	<div id="total"><?php echo "$ ".($factura->importeIIBB+$subtotalRecDes+$factura->ivatotal);?></div>
</div>