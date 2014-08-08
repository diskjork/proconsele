$(document).on('ready',function(){
	// para bloquear la tecla enter 	
$("input").keypress(function (evt) {
	var charCode = evt.charCode || evt.keyCode;
	if (charCode  == 13) { 
	return false;
		}
	});
$("table.table.mmf_table > thead > tr:eq(0)").css("display","none");
$("table.table.mmf_table > tbody").addClass("well");
$("#cobranza-form").removeClass("well");

$.datepicker.setDefaults( $.datepicker.regional[ "es" ] );
sumatotal();
elementosnovalidados();
botonsubmit();
$("#id_member").click(function(){
	newElem();
	botonsubmit();
	
});
var ctacte=$("#Cobranza_ctactecliente_idctactecliente").val();
if(ctacte != ""){
	ajaxCiente(ctacte);
	$("#Cobranza_ctactecliente_idctactecliente").attr('readonly','true');
}
$("#Cobranza_ctactecliente_idctactecliente").change(function(event){
	ajaxCiente(this.value);

});
});
function ajaxCiente(id){
	var idctacte=id;
		
		$.ajax({ 
		  type: "POST",
		  url: "/proconsele/cobranza/envioctactecliente",
		  data: {data:idctacte},
		  success: function (data){
		  $("#saldoblock").text($.number(data.saldo,2));
		  if(data.saldo < 0 ){
		  	$("#blocksaldo")
		  	.popover({ 
    		placement:'top'	,
    		title: 'Saldo', content: "El cliente tiene saldo a favor." })
       		.popover('show');
		  } else if(data.saldo > 0){
		  	$("#blocksaldo")
		  	.popover({ 
    		placement:'top'	,
    		title: 'Saldo', content: "El cliente tiene saldo deudor." })
       		.popover('show');
		  } else {
		  	$("#blocksaldo").popover('hide');
		  }
		  $("#titulo").text("COBRANZA  - "+data.nombre);
		  $("#Cobranza_descripcion").val("Cobranza - "+data.nombre);
		  },
		   dataType: "json",

		});
}
function newElem(idinput){
	if(idinput == null){
		
	var cTR=$("table.table.mmf_table > tbody > tr").size();
	
		var n=1+ 19*(cTR-1);
		var id_input=$("td.mmf_cell:eq("+n+") > select").attr("id");

		if(id_input == null){
			var id_input=$("td.mmf_cell:eq("+n+") > input").attr("id");
		}
		var id=id_input;
		var tipo=viewid(0,0,id,1);
		var caja=viewid(0,0,id,12);
		var bancoT=viewid(0,0,id,2);
		var banco=viewid(0,0,id,3);
		var fechaI=viewid(0,0,id,4);
		var fechaC=viewid(0,0,id,5);
		var nroC=viewid(0,0,id,6);
		var id_impor=viewid(0,0,id,7);
		var chequetitular=viewid(0,0,id,10);
		var chequecuittitular=viewid(0,0,id,11);
		var iibbnrocomp=viewid(0,0,id,13);
		var iibbfecha=viewid(0,0,id,14);
		var iibbcomprelac=viewid(0,0,id,15);
		var iibbtasa=viewid(0,0,id,16);
		var ivanrocomp=viewid(0,0,id,17);
		var ivafecha=viewid(0,0,id,18);
		var ivacomprelac=viewid(0,0,id,19);
		var ivatasa=viewid(0,0,id,20);
	} else {
		var id_input=idinput;
		//alert(id_input);
		var id=id_input;
		var tipo=viewid(1,1,id,1);
		var caja=viewid(1,1,id,12);
		var bancoT=viewid(1,1,id,2);
		var banco=viewid(1,1,id,3);
		var fechaI=viewid(1,1,id,4);
		var fechaC=viewid(1,1,id,5);
		var nroC=viewid(1,1,id,6);
		var id_impor=viewid(1,1,id,7);
		var chequetitular=viewid(1,1,id,10);
		var chequecuittitular=viewid(1,1,id,11);
		var iibbnrocomp=viewid(1,1,id,13);
		var iibbfecha=viewid(1,1,id,14);
		var iibbcomprelac=viewid(1,1,id,15);
		var iibbtasa=viewid(1,1,id,16);
		var ivanrocomp=viewid(1,1,id,17);
		var ivafecha=viewid(1,1,id,18);
		var ivacomprelac=viewid(1,1,id,19);
		var ivatasa=viewid(1,1,id,20);
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
		

		$("#"+fechaI).parent().removeAttr("style");
		$("#"+fechaI).parent().css("display","none");
		//console.log(fechaI);

		$("#"+fechaC).parent().removeAttr("style");
		$("#"+fechaC).parent().css("display","none");
		

		$("#"+nroC).parent().removeAttr("style");
		$("#"+nroC).parent().css("display","none");
		
		$("#"+id_impor).parent().removeAttr("style");
		$("#"+id_impor).parent().css("display","none");
		
		$("#"+caja).parent().removeAttr("style");
		$("#"+caja).parent().css("display","none");
				
		$("#"+chequetitular).parent().removeAttr("style");
		$("#"+chequetitular).parent().css("display","none");
		
		$("#"+chequecuittitular).parent().removeAttr("style");
		$("#"+chequecuittitular).parent().css("display","none");

		$("#"+iibbnrocomp).parent().removeAttr("style");
		$("#"+iibbnrocomp).parent().css("display","none");

		$("#"+iibbfecha).parent().removeAttr("style");
		$("#"+iibbfecha).parent().css("display","none");

		$("#"+iibbcomprelac).parent().removeAttr("style");
		$("#"+iibbcomprelac).parent().css("display","none");

		$("#"+iibbtasa).parent().removeAttr("style");
		$("#"+iibbtasa).parent().css("display","none");

		$("#"+ivanrocomp).parent().removeAttr("style");
		$("#"+ivanrocomp).parent().css("display","none");

		$("#"+ivafecha).parent().removeAttr("style");
		$("#"+ivafecha).parent().css("display","none");

		$("#"+ivacomprelac).parent().removeAttr("style");
		$("#"+ivacomprelac).parent().css("display","none");

		$("#"+ivatasa).parent().removeAttr("style");
		$("#"+ivatasa).parent().css("display","none");
		
}

function seleccion(obj){
	var id=obj.id;
	var valor=obj.val;
	var bancoT=viewid(1,1,id,2);
	var caja=viewid(1,1,id,12);
	var banco=viewid(1,1,id,3);
	var fechaI=viewid(1,1,id,4);
	var fechaC=viewid(1,1,id,5);
	var nroC=viewid(1,1,id,6);
	var id_impor=viewid(1,1,id,7);
	var chequetitular=viewid(1,1,id,10);
	var chequecuittitular=viewid(1,1,id,11);
	var iibbnrocomp=viewid(1,1,id,13);
	var iibbfecha=viewid(1,1,id,14);
	var iibbcomprelac=viewid(1,1,id,15);
	var iibbtasa=viewid(1,1,id,16);
	var ivanrocomp=viewid(1,1,id,17);
	var ivafecha=viewid(1,1,id,18);
	var ivacomprelac=viewid(1,1,id,19);
	var ivatasa=viewid(1,1,id,20);
	valor=parseInt(valor);
	switch(valor){
		case (0): //efectivo

		newElem(id);
			$("#"+banco).parent().find('label').html("Banco").remove();
			$("#"+fechaI).parent().find('label').html("F.Emision").remove();
			$("#"+fechaC).parent().find('label').html("Fecha Cobro").remove();
			$("#"+nroC).parent().find('label').html("Nro Cheque").remove();
			$("#"+caja).parent().removeAttr("style");
			$("#"+caja).parent().find('label').html("Caja").remove();
			$("#"+caja).parent().prepend("<label>Caja</label>");
			$("#"+caja).parent().css("text-align","left");
			$("#"+id_impor).parent().removeAttr("style");
			$("#"+id_impor).parent().find('label').html("Importe").remove();
			$("#"+id_impor).parent().prepend("<label>Importe</label>");
			$("#"+id_impor).parent().css("text-align","left");
			break;
		case (1): //cheque
		newElem(id);
			$("#"+banco).parent().removeAttr("style");
			$("#"+banco).parent().find('label').html("Banco").remove();
			$("#"+banco).parent().find('input').css("width","90%");
			$("#"+banco).parent().prepend("<label>Banco</label>");
			$("#"+banco).parent().css("text-align","left");
			
			$("#"+fechaI).parent().removeAttr("style");
			$("#"+fechaI).parent().find('label').html("F.Emision").remove();
			$("#"+fechaI).parent().css("width","90px");
			$("#"+fechaI).parent().find('input').css("width","90%");
			$("#"+fechaI).parent().prepend("<label>F.Emision</label>");
			$("#"+fechaI).parent().find('label').css("width","70px");
			$("#"+fechaI).parent().css("text-align","left");
			
			$("#"+fechaC).parent().removeAttr("style");
			$("#"+fechaC).parent().find('label').html("F.Cobro").remove();
			$("#"+fechaC).parent().css("width","90px");
			$("#"+fechaC).parent().find('input').css("width","90%");
			$("#"+fechaC).parent().prepend("<label>F.Cobro</label>");
			$("#"+fechaC).parent().find('label').css("width","70px");
			$("#"+fechaC).parent().css("text-align","left");

			$("#"+chequetitular).parent().removeAttr("style");
			$("#"+chequetitular).parent().find('label').html("Titular").remove();
			$("#"+chequetitular).parent().css("width","90px");
			$("#"+chequetitular).parent().find('input').css("width","90%");
			$("#"+chequetitular).parent().prepend("<label>Titular</label>");
			$("#"+chequetitular).parent().find('label').css("width","70px");
			$("#"+chequetitular).parent().css("text-align","left");
			
			$("#"+chequecuittitular).parent().removeAttr("style");
			$("#"+chequecuittitular).parent().find('label').html("CUIT").remove();
			$("#"+chequecuittitular).parent().css("width","90px");
			$("#"+chequecuittitular).parent().find('input').css("width","90%");
			$("#"+chequecuittitular).parent().prepend("<label>CUIT</label>");
			$("#"+chequecuittitular).parent().find('label').css("width","70px");
			$("#"+chequecuittitular).parent().css("text-align","left");
			
			$("#"+nroC).parent().removeAttr("style");
			$("#"+nroC).parent().find('label').html("N°.Cheque").remove();
			$("#"+nroC).parent().prepend("<label>N°.Cheque</label>");
			$("#"+nroC).parent().css("text-align","left");
			
			$("#"+id_impor).parent().removeAttr("style");
			$("#"+id_impor).parent().find('label').html("Importe").remove();
			$("#"+id_impor).parent().prepend("<label>Importe</label>");
			$("#"+id_impor).parent().css("text-align","left");
			break;
		case (2): //transferencia
			newElem(id);
			$("#"+bancoT).parent().removeAttr("style");
			$("#"+bancoT).parent().find('label').html("C. Bancaria").remove();
			$("#"+bancoT).parent().prepend("<label>C. Bancaria</label>");
			$("#"+bancoT).parent().css("text-align","left");

			$("#"+fechaI).parent().find('label').html("Fecha Emision").remove();
			$("#"+fechaC).parent().find('label').html("Fecha Cobro").remove();
			$("#"+nroC).parent().find('label').html("Nro Cheque").remove();
			$("#"+id_impor).parent().removeAttr("style");
			$("#"+id_impor).parent().find('label').html("Importe").remove();
			$("#"+id_impor).parent().prepend("<label>Importe</label>");
			$("#"+id_impor).parent().css("text-align","left");
			break;

		case (3): //IIBB
			newElem(id);
			$("#"+iibbnrocomp).parent().removeAttr("style");
			$("#"+iibbnrocomp).parent().find('label').html("Nro.Compr.R.IIBB").remove();
			$("#"+iibbnrocomp).parent().prepend("<label>Nro.Compr.R.IIBB</label>");
			$("#"+iibbnrocomp).parent().css("text-align","left");

			$("#"+iibbfecha).parent().removeAttr("style");
			$("#"+iibbfecha).parent().find('label').html("Fecha").remove();
			$("#"+iibbfecha).parent().css("width","70px");
			$("#"+iibbfecha).parent().find('input').css("width","90%");
			$("#"+iibbfecha).parent().prepend("<label>Fecha</label>");
			$("#"+iibbfecha).parent().find('label').css("width","70px");
			$("#"+iibbfecha).parent().css("text-align","left");
			
			$("#"+iibbcomprelac).parent().removeAttr("style");
			$("#"+iibbcomprelac).parent().find('label').html("Compr.Relac.").remove();
			$("#"+iibbcomprelac).parent().prepend("<label>Compr.Relac.</label>");
			$("#"+iibbcomprelac).parent().css("text-align","left");

			$("#"+iibbtasa).parent().removeAttr("style");
			$("#"+iibbtasa).parent().find('label').html("Tasa %").remove();
			$("#"+iibbtasa).parent().prepend("<label>Tasa %</label>");
			$("#"+iibbtasa).parent().css("text-align","left");

			$("#"+id_impor).parent().removeAttr("style");
			$("#"+id_impor).parent().find('label').html("Importe").remove();
			$("#"+id_impor).parent().prepend("<label>Importe</label>");
			$("#"+id_impor).parent().css("text-align","left");
			
			break;
		case (4): //IVA
			newElem(id);
			$("#"+ivanrocomp).parent().removeAttr("style");
			$("#"+ivanrocomp).parent().find('label').html("Nro.Compr.R.IVA").remove();
			$("#"+ivanrocomp).parent().prepend("<label>Nro.Compr.R.IVA</label>");
			$("#"+ivanrocomp).parent().css("text-align","left");

			$("#"+ivafecha).parent().removeAttr("style");
			$("#"+ivafecha).parent().find('label').html("Fecha").remove();
			$("#"+ivafecha).parent().css("width","70px");
			$("#"+ivafecha).parent().find('input').css("width","90%");
			$("#"+ivafecha).parent().prepend("<label>Fecha</label>");
			$("#"+ivafecha).parent().find('label').css("width","70px");
			$("#"+ivafecha).parent().css("text-align","left");
			
			$("#"+ivacomprelac).parent().removeAttr("style");
			$("#"+ivacomprelac).parent().find('label').html("Compr.Relac.").remove();
			$("#"+ivacomprelac).parent().prepend("<label>Compr.Relac.</label>");
			$("#"+ivacomprelac).parent().css("text-align","left");

			$("#"+ivatasa).parent().removeAttr("style");
			$("#"+ivatasa).parent().find('label').html("Tasa %").remove();
			$("#"+ivatasa).parent().prepend("<label>Tasa %</label>");
			$("#"+ivatasa).parent().css("text-align","left");

			$("#"+id_impor).parent().removeAttr("style");
			$("#"+id_impor).parent().find('label').html("Importe").remove();
			$("#"+id_impor).parent().prepend("<label>Importe</label>");
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
		var n=17;
		n=n+(19*i);
		var subtotal=parseFloat($( "td.mmf_cell:eq("+n+") > input" ).val());
		if($.isNumeric(subtotal))
		total=total+subtotal;
		}
	
	$("#Cobranza_importe").val(total.toFixed(2));
	$("#totalnetoblock").html(total.toFixed(2));
	botonsubmit();
	}
}

function elementosnovalidados(){
	var cTR=$("table.table.mmf_table > tbody > tr").size();
		
		for(i=0;i < cTR-1;i++){
		var n=0;
		n=n+(19*i);
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
	
	var a=id_input.substring(15,20);
	switch(cantidad1){
		case (0): //input transferenciabanco
			var cant1=18;
			break;
		case (1): //input tipocobranza
			var cant1=12;
			break;
		
		}
	switch(cantidad2){
	case (0): //input Detallecobranza_transferenciabanco
		var cant2=34;
		break;
	case (1): //input Detallecobranza_tipocobranza
		var cant2=28;
		break;
	
	}
 if( a == novalidado || a == update){
	 //alert("si");
		var strlargo= id_input.length;
		//alert(strlargo);
		var strfincadena= strlargo - cant1;
		indexid=id_input.substring(15,strfincadena);
		
		switch(atributo){
			case (1): //Tipo de cobranza
				var id_nombre_tipocobranza="Detallecobranza"+indexid+"tipocobranza";
				return id_nombre_tipocobranza;
				break;
			case (2): //nombre del banco
				var id_nombre_transbanco="Detallecobranza"+indexid+"transferenciabanco";
				return id_nombre_transbanco;
				break;
			case (3): //nombre del banco
				var id_nombre_banco="Detallecobranza"+indexid+"chequebanco";
				return id_nombre_banco;
				break;
			case (4): //fecha de emision del cheque
				var id_nombre_fechaingreso="Detallecobranza"+indexid+"chequefechaingreso";
				return id_nombre_fechaingreso;
				break;
			case (5): //fecha de cobro
				var id_nombre_fechacobro="Detallecobranza"+indexid+"chequefechacobro";
				return id_nombre_fechacobro;
				break;
			case (6): //nrocheque
				var id_nombre_nrocheque="Detallecobranza"+indexid+"nrocheque";
				return id_nombre_nrocheque;
				break;
			case (7): //importe
				var id_nombre_importe="Detallecobranza"+indexid+"importe";
				return id_nombre_importe;
				break;
			case (8):
				return indexid;
				break;
			case (10): //cheque titular
				var id_nombre_chequetitular="Detallecobranza"+indexid+"chequetitular";
				return id_nombre_chequetitular;
				break;
			case (11): //cheque cuit titular
				var id_nombre_chequecuittitular="Detallecobranza"+indexid+"chequecuittitular";
				return id_nombre_chequecuittitular;
				break;
			case (12): //caja
				var id_nombrecaja="Detallecobranza"+indexid+"caja_idcaja";
				return id_nombrecaja;
				console.log(id_nombrecaja);
				break;
			case (13): //iibb número de comprobante
				var id_iibbnrocomp="Detallecobranza"+indexid+"iibbnrocomp";
				return id_iibbnrocomp;
				console.log(id_iibbnrocomp);
				break;
			case (14): //iibb fecha del comprobante
				var id_iibbfecha="Detallecobranza"+indexid+"iibbfecha";
				return id_iibbfecha;
				//console.log(iibbfecha);
				break;
			case (15): //iibb número de comprobante
				var id_iibbcomprelac="Detallecobranza"+indexid+"iibbcomprelac";
				return id_iibbcomprelac;
				//console.log(iibbfecha);
				break;
			case (16): //iibb tasa de retencion
				var id_iibbtasa="Detallecobranza"+indexid+"iibbtasa";
				return id_iibbtasa;
				//console.log(iibbfecha);
				break;
			case (17): //iva número de comprobante
				var id_ivanrocomp="Detallecobranza"+indexid+"ivanrocomp";
				return id_ivanrocomp;
				//console.log(id_ivanrocomp);
				break;
			case (18): //iva fecha del comprobante
				var id_ivafecha="Detallecobranza"+indexid+"ivafecha";
				return id_ivafecha;
				//console.log(ivafecha);
				break;
			case (19): //iva número de comprobante
				var id_ivacomprelac="Detallecobranza"+indexid+"ivacomprelac";
				return id_ivacomprelac;
				//console.log(ivafecha);
				break;
			case (20): //iva tasa de retencion
				var id_ivatasa="Detallecobranza"+indexid+"ivatasa";
				return id_ivatasa;
				//console.log(ivafecha);
				break;
			} 
	}else {
		indexid = id_input.substring(cant2,id_input.length);
		switch(atributo){
		case (1): //cantidad del producto
			var id_nombre_tipocobranza="Detallecobranza_tipocobranza"+indexid;
			return id_nombre_tipocobranza;
			break;
		case (2): //nombre del banco
				var id_nombre_transbanco="Detallecobranza_transferenciabanco"+indexid;
				return id_nombre_transbanco;
				break;
		case (3): //código del producto
			var id_nombre_chequebanco="Detallecobranza_chequebanco"+indexid;
			return id_nombre_chequebanco;
			break;
		case (4): //nombre del producto
			var id_nombre_chequefechaingreso="Detallecobranza_chequefechaingreso"+indexid;
			return id_nombre_chequefechaingreso;
			break;
		case (5): //precio del producto
			var id_nombre_chequefechacobro="Detallecobranza_chequefechacobro"+indexid;
			return id_nombre_chequefechacobro;
			break;
		case (6): //subtotal del producto
			var id_nombre_nrocheque="Detallecobranza_nrocheque"+indexid;
			return id_nombre_nrocheque;
			break;	
		case (7): //importe
				var id_nombre_importe="Detallecobranza_importe"+indexid;
				return id_nombre_importe;
				break;
		case(8):
			return indexid;
			break;
		case (10): //cheque titular
				var id_nombre_chequetitular="Detallecobranza_chequetitular"+indexid;
				return id_nombre_chequetitular;
				break;
		case (11): //cheque cuittitular
				var id_nombre_chequecuittitular="Detallecobranza_chequecuittitular"+indexid;
				return id_nombre_chequecuittitular;
				break;
		case (12): //caja
				var id_nombre_caja="Detallecobranza_caja_idcaja"+indexid;
				return id_nombre_caja;
				break;
		case (13): //iibb número de comprobante
				var id_iibbnrocomp="Detallecobranza_iibbnrocomp"+indexid;
				return id_iibbnrocomp;
				console.log(id_iibbnrocomp);
				break;
		case (14): //iibb fecha del comprobante
			var id_iibbfecha="Detallecobranza_iibbfecha"+indexid;
			return id_iibbfecha;
			//console.log(iibbfecha);
			break;
		case (15): //iibb número de comprobante
			var id_iibbcomprelac="Detallecobranza_iibbcomprelac"+indexid;
			return id_iibbcomprelac;
			//console.log(iibbfecha);
			break;
		case (16): //iibb tasa de retencion
			var id_iibbtasa="Detallecobranza_iibbtasa"+indexid;
			return id_iibbtasa;
			//console.log(iibbfecha);
			break;
		case (17): //iva número de comprobante
			var id_ivanrocomp="Detallecobranza_ivanrocomp"+indexid;
			return id_ivanrocomp;
			//console.log(id_ivanrocomp);
			break;
		case (18): //iva fecha del comprobante
			var id_ivafecha="Detallecobranza_ivafecha"+indexid;
			return id_ivafecha;
			//console.log(ivafecha);
			break;
		case (19): //iva número de comprobante
			var id_ivacomprelac="Detallecobranza_ivacomprelac"+indexid;
			return id_ivacomprelac;
			//console.log(ivafecha);
			break;
		case (20): //iva tasa de retencion
			var id_ivatasa="Detallecobranza_ivatasa"+indexid;
			return id_ivatasa;
			//console.log(ivafecha);
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
	var iibbnrocomp=viewid(1,1,id,13);
	var iibbfecha=viewid(1,1,id,14);
	var iibbcomprelac=viewid(1,1,id,15);
	var iibbtasa=viewid(1,1,id,16);
	var ivanrocomp=viewid(1,1,id,17);
	var ivafecha=viewid(1,1,id,18);
	var ivacomprelac=viewid(1,1,id,19);
	var ivatasa=viewid(1,1,id,20);

	$("#"+bancoT).val("");
	$("#"+banco).val("");
	$("#"+fechaI).val("");
	$("#"+fechaC).val("");
	$("#"+nroC).val("");
	$("#"+id_impor).val("");
	$("#"+idcheque).val("");
	$("#"+chequetitular).val("");
	$("#"+chequecuittitular).val("");
	$("#"+iibbnrocomp).val("");
	$("#"+iibbfecha).val("");
	$("#"+iibbcomprelac).val("");
	$("#"+iibbtasa).val("");
	$("#"+ivacomprelac).val("");
	$("#"+ivafecha).val("");
	$("#"+ivacomprelac).val("");
	$("#"+ivatasa).val("");
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