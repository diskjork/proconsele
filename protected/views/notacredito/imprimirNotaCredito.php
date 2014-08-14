<?php 
	if ($notacredito->formadepago!=99999){
		$contadoTemp="X";
		$ccTemp="";
	}elseif($notacredito->formadepago===99999){
		$contadoTemp="";
		$ccTemp="X";
	}

	if ($notacredito->clienteIdcliente->tipodecontribuyente_idtipocontribuyente==1){
		$ri="X";
	}else{
		$ri="";
	}
	
	if ($notacredito->tipodescrecar==0 AND $notacredito->descrecar!=NULL){
		$descuento=number_format(($notacredito->stbruto_producto)*($notacredito->descrecar/100),2, ".", ",");
		$descuentostr="$ ".$descuento;
		$recargo="";
	}else if ($notacredito->tipodescrecar==1 AND $notacredito->descrecar!=NULL){
		$descuento="";
		$recargo=number_format(($notacredito->stbruto_producto)*($notacredito->descrecar/100),2, ".", ",");
		$recargostr="$ ".$recargo;
	}else{
		$recargostr="";
		$descuentostr="";
		$subtotalRecDes=$notacredito->importebruto;
	}
	$e=0;
	$notacredito->importeIIBB;
?>

<div id="apDiv1">
	<div id="fecha"><?php echo $notacredito->fecha;?></div>
  	<div id="nombre"><?php echo $notacredito->clienteIdcliente;?></div>
   	<div id="direccion"><?php echo $notacredito->clienteIdcliente->direccion;?></div>
   	<div id="cuit"><?php echo $notacredito->clienteIdcliente->cuit;?></div>
   	<div id="contado"><?php echo $contadoTemp;?></div>
   	<div id="cc"><?php echo $ccTemp;?></div>
   	<div id="ri"><?php echo $ri;?></div>
   	<div id="cantidad" style="margin-top:<?php echo $e;?>;"><?php echo $notacredito->cantidadproducto;?></div>
  	<div id="descripcion"  style="margin-top:<?php echo $e;?>;"><?php echo $notacredito->nombreproducto;?></div>
	<div id="preciounitario"  style="margin-top:<?php echo $e;?>;"><?php echo "$ ".$notacredito->precioproducto;?></div>
	<div id="importe"  style="margin-top:<?php echo $e;?>;"><?php echo "$ ".$notacredito->stbruto_producto;?></div>
  	<div id="impuesto"><?php echo $notacredito->importeImpInt;?></div>
  	<div id="descuento"><?php echo $descuentostr;?></div>
  	<div id="recargo"><?php echo $recargostr;?></div>
  	<div id="subtotal"><?php echo "$ ".$notacredito->stbruto_producto;?></div>
  	<div id="iva"><?php echo $notacredito->iva;?></div>
  	<div id="importeiva"><?php echo "$ ".$notacredito->ivatotal;?></div>
  	<div id="subtotaliva"><?php echo "$ ".$notacredito->importebruto;//($subtotalRecDes);?></div>
  	<div id="total"><?php echo "$ ".($notacredito->importeneto);?></div>
</div>