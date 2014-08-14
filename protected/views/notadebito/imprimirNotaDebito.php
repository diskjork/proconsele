<?php 
	if ($notadebito->formadepago!=99999){
		$contadoTemp="X";
		$ccTemp="";
	}elseif($notadebito->formadepago===99999){
		$contadoTemp="";
		$ccTemp="X";
	}

	if ($notadebito->clienteIdcliente->tipodecontribuyente_idtipocontribuyente==1){
		$ri="X";
	}else{
		$ri="";
	}
	
	if ($notadebito->tipodescrecar==0 AND $notadebito->descrecar!=NULL){
		$descuento=number_format(($notadebito->stbruto_producto)*($notadebito->descrecar/100),2, ".", ",");
		$descuentostr="$ ".$descuento;
		$recargo="";
	}else if ($notadebito->tipodescrecar==1 AND $notadebito->descrecar!=NULL){
		$descuento="";
		$recargo=number_format(($notadebito->stbruto_producto)*($notadebito->descrecar/100),2, ".", ",");
		$recargostr="$ ".$recargo;
	}else{
		$recargostr="";
		$descuentostr="";
		$subtotalRecDes=$notadebito->importebruto;
	}
	$e=0;
	$notadebito->importeIIBB;
?>

<div id="apDiv1">
	<div id="fecha"><?php echo $notadebito->fecha;?></div>
  	<div id="nombre"><?php echo $notadebito->clienteIdcliente;?></div>
   	<div id="direccion"><?php echo $notadebito->clienteIdcliente->direccion;?></div>
   	<div id="cuit"><?php echo $notadebito->clienteIdcliente->cuit;?></div>
   	<div id="contado"><?php echo $contadoTemp;?></div>
   	<div id="cc"><?php echo $ccTemp;?></div>
   	<div id="ri"><?php echo $ri;?></div>
   	<div id="cantidad" style="margin-top:<?php echo $e;?>;"><?php echo $notadebito->cantidadproducto;?></div>
  	<div id="descripcion"  style="margin-top:<?php echo $e;?>;"><?php echo $notadebito->nombreproducto;?></div>
	<div id="preciounitario"  style="margin-top:<?php echo $e;?>;"><?php echo "$ ".$notadebito->precioproducto;?></div>
	<div id="importe"  style="margin-top:<?php echo $e;?>;"><?php echo "$ ".$notadebito->stbruto_producto;?></div>
  	<div id="impuesto"><?php echo $notadebito->importeImpInt;?></div>
  	<div id="descuento"><?php echo $descuentostr;?></div>
  	<div id="recargo"><?php echo $recargostr;?></div>
  	<div id="subtotal"><?php echo "$ ".$notadebito->stbruto_producto;?></div>
  	<div id="iva"><?php echo $notadebito->iva;?></div>
  	<div id="importeiva"><?php echo "$ ".$notadebito->ivatotal;?></div>
  	<div id="subtotaliva"><?php echo "$ ".$notadebito->importebruto;//($subtotalRecDes);?></div>
  	<div id="total"><?php echo "$ ".($notadebito->importeneto);?></div>
</div>