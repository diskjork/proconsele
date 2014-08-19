<?php 
	/*if ($notadebito->formadepago!=99999){
		$contadoTemp="X";
		$ccTemp="";
	}elseif($notadebito->formadepago===99999){
		$contadoTemp="";
		$ccTemp="X";
	}*/
	$ccTemp="X";
	if ($notadebito->clienteIdcliente->tipodecontribuyente_idtipocontribuyente==1){
		$ri="X";
	}else{
		$ri="";
	}
	
	/*if ($notadebito->tipodescrecar==0 AND $notadebito->descrecar!=NULL){
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
	$notadebito->importeIIBB;*/
?>

<div id="apDiv1">
	<div id="fecha"><?php echo $notadebito->fecha;?></div>
  	<div id="nombre"><?php echo $notadebito->clienteIdcliente;?></div>
   	<div id="direccion"><?php echo $notadebito->clienteIdcliente->direccion;?></div>
   	<div id="cuit"><?php echo $notadebito->clienteIdcliente->cuit;?></div>
   	
   	<div id="cc"><?php echo $ccTemp;?></div>
   	<div id="ri"><?php echo $ri;?></div>
   	
  	<div id="descripcion"  style="margin-top:<?php echo $e;?>;"><?php echo $notadebito->descripcion;?></div>
	
  	<div id="total"><?php echo "$ ".($notadebito->importeneto);?></div>
</div>