$(document).on('ready',function(){
$("table.table.mmf_table > thead > tr:eq(0)").css("display","none");


$.datepicker.setDefaults( $.datepicker.regional[ "es" ] );
sumatotal();
elementosnovalidados();
$("#id_member").click(function(){
	newElem();
	botonsubmit();
	
});
});

function newElem(idinput){
	if(idinput == null){
		
	var cTR=$("table.table.mmf_table > tbody > tr").size();
	
		var n=1+ 13*(cTR-1);
		var id_input=$("td.mmf_cell:eq("+n+") > select").attr("id");

		if(id_input == null){
			var id_input=$("td.mmf_cell:eq("+n+") > input").attr("id");
		}
		var id=id_input;
		var tipo=viewid(0,0,id,1);
		var bancoT=viewid(0,0,id,2);
		var banco=viewid(0,0,id,3);
		var fechaI=viewid(0,0,id,4);
		var fechaC=viewid(0,0,id,5);
		var nroC=viewid(0,0,id,6);
		var id_impor=viewid(0,0,id,7);
		var idcheque=viewid(0,0,id,9);
		var chequetitular=viewid(0,0,id,10);
		var chequecuittitular=viewid(0,0,id,11);
		var caja_idcaja=viewid(0,0,id,12);
		var chequera=viewid(0,0,id,13);

	} else {
		var id_input=idinput;
		//alert(id_input);
		var id=id_input;
		var tipo=viewid(1,1,id,1);
		var bancoT=viewid(1,1,id,2);
		var banco=viewid(1,1,id,3);
		var fechaI=viewid(1,1,id,4);
		var fechaC=viewid(1,1,id,5);
		var nroC=viewid(1,1,id,6);
		var id_impor=viewid(1,1,id,7);
		var idcheque=viewid(1,1,id,9);
		var chequetitular=viewid(1,1,id,10);
		var chequecuittitular=viewid(1,1,id,11);
		var caja_idcaja=viewid(1,1,id,12);
		var chequera=viewid(1,1,id,13);
	}
		//alert(id_input);
		
		//console.log("Banco: "+banco+" BANCOT: "+bancoT+" FECHAE: "+fechaE+" FECHAC: "+fechaC+" NROC: "+nroC+" IMPORTE: "+id_impor);
		$("#"+tipo).parent().find('label').html("Tipo de Pago").remove();
		$("#"+tipo).parent().prepend("<label>Tipo de Pago</label>");
		$("#"+tipo).parent().css("text-align","left");
		
		$("#"+bancoT).parent().removeAttr("style");
		$("#"+bancoT).parent().css("display","none");
		
		$("#"+banco).parent().removeAttr("style");
		$("#"+banco).parent().css("display","none");
		$("#"+banco).removeAttr('readonly','true');
		
		$("#"+fechaI).parent().removeAttr("style");
		$("#"+fechaI).parent().css("display","none");
		$("#"+fechaI).removeAttr('readonly','true');

		$("#"+fechaC).parent().removeAttr("style");
		$("#"+fechaC).parent().css("display","none");
		$("#"+fechaC).removeAttr('readonly','true');

		$("#"+nroC).parent().removeAttr("style");
		$("#"+nroC).parent().css("display","none");
		$("#"+nroC).removeAttr('readonly','true');

		$("#"+id_impor).parent().removeAttr("style");
		$("#"+id_impor).parent().css("display","none");
		$("#"+id_impor).removeAttr('readonly','true');

		$("#"+idcheque).parent().removeAttr("style");
		$("#"+idcheque).parent().css("display","none");
		$("#"+idcheque).removeAttr('readonly','true');

		$("#"+chequetitular).parent().removeAttr("style");
		$("#"+chequetitular).parent().css("display","none");
		$("#"+chequetitular).removeAttr('readonly','true');

		$("#"+chequecuittitular).parent().removeAttr("style");
		$("#"+chequecuittitular).parent().css("display","none");
		$("#"+chequecuittitular).removeAttr('readonly','true');

		$("#"+chequera).parent().removeAttr("style");
		$("#"+chequera).parent().css("display","none");
		$("#"+chequera).removeAttr('readonly','true');

		$("#"+caja_idcaja).parent().removeAttr("style");
		$("#"+caja_idcaja).parent().css("display","none");
		$("#"+caja_idcaja).removeAttr('readonly','true');


		$("#"+id_impor).removeAttr('readonly','true');

}

function seleccion(obj){
	var id=obj.id;
	var valor=obj.val;
	var bancoT=viewid(1,1,id,2);
	var banco=viewid(1,1,id,3);
	var fechaI=viewid(1,1,id,4);
	var fechaC=viewid(1,1,id,5);
	var nroC=viewid(1,1,id,6);
	var id_impor=viewid(1,1,id,7);
	var idcheque=viewid(1,1,id,9);
	var chequetitular=viewid(1,1,id,10);
	var chequecuittitular=viewid(1,1,id,11);
	var caja_idcaja=viewid(1,1,id,12);
	var chequera=viewid(1,1,id,13);
	valor=parseInt(valor);
	switch(valor){
		case (0): //efectivo

		newElem(id);
			$("#"+banco).parent().find('label').html("Banco").remove();
			$("#"+fechaI).parent().find('label').html("Fecha Ingreso").remove();
			
			$("#"+fechaC).parent().find('label').html("Fecha Cobro").remove();
			$("#"+nroC).parent().find('label').html("Nro Cheque").remove();
			$("#"+caja_idcaja).parent().removeAttr("style");
			$("#"+caja_idcaja).parent().find('label').html("Caja").remove();
			$("#"+caja_idcaja).parent().prepend("<label>Caja</label>");
			$("#"+caja_idcaja).parent().css("text-align","left");

			$("#"+id_impor).parent().removeAttr("style");
			$("#"+id_impor).parent().find('label').html("Importe").remove();
			$("#"+id_impor).parent().prepend("<label>Importe</label>");
			$("#"+id_impor).parent().css("text-align","left");
			break;
		case (1): //cheque propio
		newElem(id);
			
			$("#"+chequera).parent().removeAttr("style");
			$("#"+chequera).parent().find('label').html("Chequera").remove();
			$("#"+chequera).parent().find('input').css("width","90%");
			$("#"+chequera).parent().prepend("<label>Chequera</label>");
			$("#"+chequera).parent().css("text-align","left");
			
			$("#"+fechaI).parent().removeAttr("style");
			$("#"+fechaI).parent().find('label').html("F.Ingreso").remove();
			$("#"+fechaI).parent().css("width","90px");
			$("#"+fechaI).parent().find('input').css("width","90%");
			$("#"+fechaI).parent().prepend("<label>F.Ingreso</label>");
			$("#"+fechaI).parent().find('label').css("width","70px");
			$("#"+fechaI).parent().css("text-align","left");

			$("#"+fechaC).parent().removeAttr("style");
			$("#"+fechaC).parent().find('label').html("F.Cobro").remove();
			$("#"+fechaC).parent().css("width","90px");
			$("#"+fechaC).parent().find('input').css("width","90%");
			$("#"+fechaC).parent().prepend("<label>F.Cobro</label>");
			$("#"+fechaC).parent().find('label').css("width","70px");
			$("#"+fechaC).parent().css("text-align","left");

			$("#"+nroC).parent().removeAttr("style");
			$("#"+nroC).parent().find('label').html("N°.Cheque").remove();
			$("#"+nroC).parent().prepend("<label>N°.Cheque</label>");
			$("#"+nroC).parent().css("text-align","left");

			
			$("#"+id_impor).parent().removeAttr("style");
			$("#"+id_impor).parent().find('label').html("Importe").remove();
			$("#"+id_impor).parent().prepend("<label>Importe</label>");
			$("#"+nroC).parent().css("text-align","left");
			$("#"+chequetitular).val("YVN S.R.L.");
			$("#"+chequecuittitular).val("-");
			break;
		case (2): //transferencia
			newElem(id);
			$("#"+bancoT).parent().removeAttr("style");
			$("#"+bancoT).parent().find('label').html("Cta.Bancaria").remove();
			$("#"+bancoT).parent().prepend("<label>Cta.Bancaria</label>");
			$("#"+bancoT).parent().css("text-align","left");

			$("#"+fechaI).parent().find('label').html("Fecha Ingreso").remove();
			$("#"+fechaC).parent().find('label').html("Fecha Cobro").remove();
			$("#"+nroC).parent().find('label').html("Nro Cheque").remove();
			$("#"+id_impor).parent().removeAttr("style");
			$("#"+id_impor).parent().find('label').html("Importe").remove();
			$("#"+id_impor).parent().prepend("<label>Importe</label>");
			$("#"+id_impor).parent().css("text-align","left");
			break;

		case(3): //cheque endozado	
			newElem(id);
			$("#"+idcheque).parent().removeAttr("style");
			$("#"+idcheque).parent().find('label').html("Id.Cheque").remove();
			$("#"+idcheque).parent().css("width","20px");
			$("#"+idcheque).attr("readonly","true");
			$("#"+idcheque).parent().find('input').css("width","90%");
			$("#"+idcheque).parent().prepend("<label>Id.Cheque</label>");
			$("#"+idcheque).parent().find('label').css("width","70px");
			$("#"+idcheque).parent().css("text-align","left");

						
			$("#"+fechaI).parent().removeAttr("style");
			$("#"+fechaI).parent().find('label').html("F.Ingreso").remove();
			$("#"+fechaI).parent().css("width","90px");
			$("#"+fechaI).attr("readonly","true");
			$("#"+fechaI).parent().find('input').css("width","90%");
			$("#"+fechaI).parent().prepend("<label>F.Ingreso</label>");
			$("#"+fechaI).parent().find('label').css("width","70px");
			$("#"+fechaI).parent().css("text-align","left");
			$("#"+fechaI).removeClass("hasDatepicker");
			$("#"+fechaC).parent().removeAttr("style");
			$("#"+fechaC).parent().find('label').html("F.Cobro").remove();
			$("#"+fechaC).parent().css("width","90px");
			$("#"+fechaC).attr("readonly","true");
			$("#"+fechaC).parent().find('input').css("width","90%");
			$("#"+fechaC).parent().prepend("<label>F.Cobro</label>");
			$("#"+fechaC).parent().find('label').css("width","70px");
			$("#"+fechaC).parent().css("text-align","left");
			$("#"+fechaC).removeClass("hasDatepicker");

			$("#"+chequetitular).parent().removeAttr("style");
			$("#"+chequetitular).parent().find('label').html("Titular").remove();
			$("#"+chequetitular).parent().css("width","90px");
			$("#"+chequetitular).attr("readonly","true");
			$("#"+chequetitular).parent().find('input').css("width","90%");
			$("#"+chequetitular).parent().prepend("<label>Titular</label>");
			$("#"+chequetitular).parent().find('label').css("width","70px");
			$("#"+chequetitular).parent().css("text-align","left");

			
			$("#"+chequecuittitular).parent().removeAttr("style");
			$("#"+chequecuittitular).parent().find('label').html("CUIT").remove();
			$("#"+chequecuittitular).parent().css("width","90px");
			$("#"+chequecuittitular).attr("readonly","true");
			$("#"+chequecuittitular).parent().find('input').css("width","90%");
			$("#"+chequecuittitular).parent().prepend("<label>CUIT</label>");
			$("#"+chequecuittitular).parent().find('label').css("width","70px");
			$("#"+chequecuittitular).parent().css("text-align","left");

			
			$("#"+nroC).parent().removeAttr("style");
			$("#"+nroC).parent().find('label').html("N°.Cheque").remove();
			$("#"+nroC).parent().prepend("<label>N°.Cheque</label>");
			$("#"+nroC).attr("readonly","true");
			$("#"+nroC).parent().css("text-align","left");
			$("#"+id_impor).parent().removeAttr("style");
			$("#"+id_impor).parent().find('label').html("Importe").remove();
			$("#"+id_impor).parent().prepend("<label>Importe</label>");
			$("#"+id_impor).attr("readonly","true");
			$("#"+id_impor).parent().css("text-align","left");

			
			break;
	}

}

function sumatotal(){
	var cTR=$("table.table.mmf_table > tbody > tr").size();
	//alert(cTR);
	if(cTR != 0){
	var total=0;
	for(i=0;i < cTR;i++){
		var n=11; // número de TR o celda donde se encuentra el importe
		n=n+(13*i); //controlador para ubicarse sobre las celdas donde estan los importes
		var subtotal=parseFloat($( "td.mmf_cell:eq("+n+") > input" ).val());
		if($.isNumeric(subtotal))
		total=total+subtotal;
		}
	
	$("#Ordendepago_importe").val(total.toFixed(2));
	$("#totalnetoblock").html(total.toFixed(2));
	}
	botonsubmit();
}

function elementosnovalidados(){
	var cTR=$("table.table.mmf_table > tbody > tr").size();
		
		for(i=0;i < cTR-1;i++){
		var n=0;
		n=n+(13*i);
		var valor=parseFloat($( "td.mmf_cell:eq("+n+") > select" ).val());
		var id=$( "td.mmf_cell:eq("+n+") > select" ).attr("id");
		obj={id:id,val:valor};
		seleccion(obj);
		}
}
function solonumeromod(event) {
    if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
        (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode == 110 || event.keyCode == 190) ) {
            return;
        }
        else {
        
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) ) {
                event.preventDefault();
            }
        }
    }
function viewid(cantidad1,cantidad2, id , atributo){
	//cantidad2: para obtener el indice de los input sin error de validación
	//canitdad1: lo mismo de arriba pero en el caso de error 

	var novalidado="_n___"; //cdo los datos no se validan
	var update="_u___"; //cdo se actualiza la factura
	var id_input=id;
	
	var a=id_input.substring(18,23);
	switch(cantidad1){
		case (0): //input transferenciabanco
			var cant1=18;
			break;
		case (1): //input tipoordendepago
			var cant1=15;
			break;
		
		}
	switch(cantidad2){
	case (0): //input Detalleordendepago_transferenciabanco
		var cant2=37;
		break;
	case (1): //input Detalleordendepago_tipoordendepago
		var cant2=34;
		break;
	
	}
 if( a == novalidado || a == update){
	 //alert("si");
		var strlargo= id_input.length;
		//alert(strlargo);
		var strfincadena= strlargo - cant1;
		indexid=id_input.substring(18,strfincadena);
		
		switch(atributo){
			case (1): //Tipo de orden de pago
				var id_nombre_tipoordendepago="Detalleordendepago"+indexid+"tipoordendepago";
				return id_nombre_tipoordendepago;
				break;
			case (2): //nombre del banco para transferencia
				var id_nombre_transbanco="Detalleordendepago"+indexid+"transferenciabanco";
				return id_nombre_transbanco;
				break;
			case (3): //nombre del banco para el cheque
				var id_nombre_banco="Detalleordendepago"+indexid+"chequebanco";
				return id_nombre_banco;
				break;
			case (4): //fecha de ingreso - emision del cheque
				var id_nombre_fechaingreso="Detalleordendepago"+indexid+"chequefechaingreso";
				return id_nombre_fechaingreso;
				break;
			case (5): //fecha de cobro
				var id_nombre_fechacobro="Detalleordendepago"+indexid+"chequefechacobro";
				return id_nombre_fechacobro;
				break;
			case (6): //nrocheque
				var id_nombre_nrocheque="Detalleordendepago"+indexid+"nrocheque";
				return id_nombre_nrocheque;
				break;
			case (7): //importe
				var id_nombre_importe="Detalleordendepago"+indexid+"importe";
				return id_nombre_importe;
				break;
			case (8):
				return indexid;
				break;
			case (9): //idcheque
				var id_nombre_idcheque="Detalleordendepago"+indexid+"idcheque";
				return id_nombre_idcheque;
				break;
			case (10): //cheque titular
				var id_nombre_chequetitular="Detalleordendepago"+indexid+"chequetitular";
				return id_nombre_chequetitular;
				break;
			case (11): //cheque cuit titular
				var id_nombre_chequecuittitular="Detalleordendepago"+indexid+"chequecuittitular";
				return id_nombre_chequecuittitular;
				break;
			case (12): //caja
				var id_nombrecaja="Detalleordendepago"+indexid+"caja_idcaja";
				return id_nombrecaja;
				console.log(id_nombrecaja);
				break;
			case (13): //chequera
				var id_chequera="Detalleordendepago"+indexid+"chequera";
				return id_chequera;
				break;
			} 
	}else {
		indexid = id_input.substring(cant2,id_input.length);
		switch(atributo){
		case (1): //tipo de pago
			var id_nombre_tipoordendepago="Detalleordendepago_tipoordendepago"+indexid;
			return id_nombre_tipoordendepago;
			break;
		case (2): //nombre del banco
				var id_nombre_transbanco="Detalleordendepago_transferenciabanco"+indexid;
				return id_nombre_transbanco;
				break;
		case (3): //código del producto
			var id_nombre_chequebanco="Detalleordendepago_chequebanco"+indexid;
			return id_nombre_chequebanco;
			break;
		case (4): //nombre del producto
			var id_nombre_chequefechaingreso="Detalleordendepago_chequefechaingreso"+indexid;
			return id_nombre_chequefechaingreso;
			break;
		case (5): //precio del producto
			var id_nombre_chequefechacobro="Detalleordendepago_chequefechacobro"+indexid;
			return id_nombre_chequefechacobro;
			break;
		case (6): //subtotal del producto
			var id_nombre_nrocheque="Detalleordendepago_nrocheque"+indexid;
			return id_nombre_nrocheque;
			break;	
		case (7): //importe
				var id_nombre_importe="Detalleordendepago_importe"+indexid;
				return id_nombre_importe;
				break;
		case(8):
			return indexid;
			break;
		case (9): //idcheque
				var id_nombre_idcheque="Detalleordendepago_idcheque"+indexid;
				return id_nombre_idcheque;
				break;
		case (10): //cheque titular
				var id_nombre_chequetitular="Detalleordendepago_chequetitular"+indexid;
				return id_nombre_chequetitular;
				break;
		case (11): //cheque cuittitular
				var id_nombre_chequecuittitular="Detalleordendepago_chequecuittitular"+indexid;
				return id_nombre_chequecuittitular;
				break;
		case (12): //caja
				var id_nombre_caja="Detalleordendepago_caja_idcaja"+indexid;
				return id_nombre_caja;
				break;
		case (13): //chequera
				var id_chequera="Detalleordendepago_chequera"+indexid;
				return id_chequera;
				break;
		}
		
	}
}

function borradoinputs(id){

	var bancoT=viewid(1,1,id,2);
	var banco=viewid(1,1,id,3);
	var fechaI=viewid(1,1,id,4);
	var fechaC=viewid(1,1,id,5);
	var nroC=viewid(1,1,id,6);
	var id_impor=viewid(1,1,id,7);
	var idcheque=viewid(1,1,id,9);
	var chequetitular=viewid(1,1,id,10);
	var chequecuittitular=viewid(1,1,id,11);

	$("#"+bancoT).val("");
	$("#"+banco).val("");
	$("#"+fechaI).val("");
	$("#"+fechaC).val("");
	$("#"+nroC).val("");
	$("#"+id_impor).val("");
	$("#"+idcheque).val("");
	$("#"+chequetitular).val("");
	$("#"+chequecuittitular).val("");
}

function validaciondecodigo(obj){
	var id_input=obj.id;
	var idcheque=viewid(1,1, id_input, 9); 
	var idtipo=viewid(1,1, id_input, 1);
	var valor_input=obj.val;
	
	var col=$("table.table.mmf_table > tbody > tr").size();
	var error=0;
	for(i=0;i < col;i++){
		
		var n=2;
		n= n + (13*i);
		var valor=$( "td.mmf_cell:eq("+n+") > input" ).val();
		var idinput=$( "td.mmf_cell:eq("+n+") > input" ).attr('id');

		if((id_input != idinput) && (valor === valor_input) )
			error=error + 1;
		
	}
	if( error != 0 ){
		 	
	 	alert("Ya se cargó este cheque.");
	  	$("#"+idtipo).val(null); //para poner el selec en el prompt
	  	newElem(obj.id); //para poner la fila en cero o empty

	 }
}
function botonsubmit(){
	var tr=$("table.table.mmf_table > tbody > tr:eq(0)").css('display');
	
	var columnas=$("table.table.mmf_table > tbody > tr").size();
	
	if(tr == "none" && columnas ==1) {
		//alert("style:"+tr+"---columnas: "+columnas);
		$("#boton-submit").attr("disabled","disabled");
		//$("#boton-submit").removeAttr("disabled"); }
	 }else {
		//$("#boton-submit").attr("disabled","disabled");
		$("#boton-submit").removeAttr("disabled");
	}
	
}
