<?php 
	if ($factura->formadepago==1){
		$contadoTemp="X";
		$ccTemp="";
	}else if ($factura->formadepago==4){
		$contadoTemp="";
		$ccTemp="X";
	}

	if ($factura->clienteIdcliente->tipodecontribuyente_idtipocontribuyente==1){
		$ri="X";
	}else{
		$ri="";
	}
	
	$e=0;
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

</div>