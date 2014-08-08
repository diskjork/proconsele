$(document).on('ready',function(){
// para bloquear la tecla enter 	
$("input").keypress(function (evt) {
	var charCode = evt.charCode || evt.keyCode;
	if (charCode  == 13) { 
	return false;
		}
	});
$("#Notacreditoprov_nrodenotacredito").keydown(function(event){
	solonumeromod(event);});
$("#Notacreditoprov_importeIIBB").keydown(function(event){
	solonumeromod(event);});
$("#Notacreditoprov_importeneto").keydown(function(event){
	solonumeromod(event);});

$("#Notacreditoprov_ivatotal").keydown(function(event){
	solonumeromod(event);});
$("#Notacreditoprov_importeIIBB").keydown(function(event){
	solonumeromod(event);});

$("#Notacreditoprov_cantidadproducto").keydown(function(event){
		solonumeromod(event);});
$("#Notacreditoprov_importebruto").keydown(function(event){
    solonumeromod(event);});
$("#Notacreditoprov_descuento").keydown(function(event){
    solonumeromod(event);});
$("#Notacreditoprov_interes").keydown(function(event){
    solonumeromod(event);});
$("#Notacreditoprov_importe_per_iva").keydown(function(event){
    solonumeromod(event);});


$("#totalesfactura").css("display","none");
botonsubmit('0');
var tipo=$("#Notacreditoprov_tipofactura").val();
if(tipo == 3){
	$("#Notacreditoprov_ivatotal").val('');
	$("#Notacreditoprov_ivatotal").attr('readonly','true');
} 

var factura=$("#Notacreditoprov_compras_idcompras").val();
if(factura != ""){
	ajaxFactura(factura, '0');

} else {
	$("#totalesfactura").css('display','none');
	$("#Notacreditoprov_nrodefactura").attr('readonly','true');
}


$("#Notacreditoprov_compras_idcompras").change(function(event){
		var factura=$("#Notacreditoprov_compras_idcompras").val();
		if(factura == ""){
			$("#totalesfactura").css('display','none');
			$("#Notacreditoprov_iibb").removeAttr('checked');
		 	$("#Notacreditoprov_iibb").removeAttr('disabled');
		 	$("#totaldiv-iibb").css('display','none');
			$("#total-iibbNC").text('');
         	
         	$("#Notacreditoprov_importeIIBB").val(null);
         	$("#Notacreditoprov_proveedor_idproveedor").select2('readonly', false);
         	$("#Notacreditoprov_iva").select2('readonly', false);
         	$("#Notacreditoprov_tipofactura").select2('readonly', false);
         	$("#Notacreditoprov_proveedor_idproveedor").select2('val', '');
         	$("#Notacreditoprov_nrodefactura").val(null);
         	$("#Notacreditoprov_importeneto").val(null);

         	$("#Notacreditoprov_descuento").val(null);
         	$("#Notacreditoprov_interes").val(null);
         	$("#Notacreditoprov_importe_per_iva").val(null);
         	$("#Notacreditoprov_importebruto").val(null);
         	$("#total-netogravadoNC").text('');
         	$("#totalnetoblockNC").text('$0.00');
         	
         	$("#totaldiv-netogravadoNC").css('display','none');
         	$("#total-descuentoNC").text('');
         	$("#totaldiv-descuentoNC").css('display','none');
         	$("#totaldiv-iibbNC").css('display','none');
         	$("#Notacreditoprov_importebruto").popover('hide');
         	$("#Notacreditoprov_importeneto").popover('hide');
		}
		resetInputs();
		ajaxFactura(this.value,'1');

	});
	
});
var totalneto_ajax=null; //total de la factura seleccionada
var totalnetogravado_ajax=null; //netogravado es igual al importebruto traido desde la factura
var totaliva_ajax=null; //total de la notacredito
var totaliibb_ajax=null; // ingreso brutos
var totalperciva_ajax=null; // percepción iva
var descuento_ajax=null;
var interes_ajax=null;
var cofiva_ajax=null;
var tipofactura_ajax=null;

function ajaxFactura(id, estado){

	var idfactura=id;

	$.ajax({ 
		  type: "POST",
		  url: "/proconsele/notacreditoprov/enviofactura",
		  data: {data:idfactura},
		  success: function (data){
		  	
			totalneto_ajax=data.importeneto; //importe de la factura enviada por ajax
			tipofactura_ajax=data.tipofactura;
			$("#totalesfactura").show();
			$("#boton-submit").attr("disabled","disabled");
 
			 $("#Notacreditoprov_proveedor_idproveedor").select2("val", data.proveedor_idproveedor).select2('readonly', "true");
			 $("#Notacreditoprov_formadepago").select2("val", data.formadepago).select2('readonly', "true");
			 $("#Notacreditoprov_nrodefactura").val(data.nrodefactura).attr('readonly',true);
			 $("#Notacreditoprov_tipofactura").select2("val", data.tipofactura).select2('readonly', "true");
			
			
				if(data.tipofactura == 1){
				$("#ivablockNC").show();
				$("#ivablockNC").text("$0.00");
				$("#totalnetoblockNC").text("$0.00");
				$("#totaldiv-netogravado").show();
				$(".facturaA").show();
  				$("#facturac").css('display','none');
				$("#total-netogravado").text("$"+ $.number(data.importebruto,2));
				totalnetogravado_ajax=parseFloat(data.importebruto);
				totalneto_ajax=parseFloat(data.importeneto);
				totaliva_ajax=parseFloat(data.ivatotal);
				cofiva_ajax=parseFloat(data.iva);
				$("#totalivadiv").show();
				$("#ivablock").text('$'+$.number(data.ivatotal,2));
				
				$("#Notacreditoprov_importebruto")
					.popover({ 
	        		placement:'right'	,
	        		title: 'Neto Gravado', content: "Ingrese un importe menor o igual al Neto Gravado de la factura seleccionada." })
		       		.popover('show');
				$("#Notacreditoprov_iva").select2('val',data.iva).select2('readonly','true');
				
					if(data.importeIIBB !== null){
					 	$("#Notacreditoprov_iibb").attr('checked',':checked').attr('disabled','disabled');
					 	$("#total-iibb").text('$'+$.number(data.importeIIBB,2));
			          	$("#Notacreditoprov_importeIIBB").removeAttr('readonly');
			          	$("#totaldiv-iibbNC").show();
			          	$("#total-iibbNC").text("$0.00");
			          	$("#totaldiv-iibb").show();
			          	totaliibb_ajax=data.importeIIBB;
			        } else {
					 	$("#Notacreditoprov_iibb").removeAttr('checked').attr('disabled','disabled');
					 	$("#totaldiv-iibb").css('display','none');
						if(estado == 1){
			           		$("#total-iibbNC").text("$0.00");
				         	$("#Notacreditoprov_importeIIBB").val(null);
				         	$("#Notacreditoprov_importeIIBB").attr('readonly','true');
						  	$("#totaldiv-iibbNC").css('display','none');
						  	$("#totaldiv-iibbNC").css('display','none');
						  	totaliibb_ajax=0;
					  }
					} 
					 if(data.importe_per_iva !== null){
					 	$("#Notacreditoprov_perciva").attr('checked',':checked').attr('disabled','disabled');
					 	$("#total-perciva").text('$'+$.number(data.importe_per_iva,2));
			          	$("#Notacreditoprov_importe_per_iva").removeAttr('readonly');
			          	$("#totaldiv-percivaNC").show();
			          	$("#total-percivaNC").text("$0.00");
			          	$("#totaldiv-perciva").show();
			          	totalperciva_ajax=data.importe_per_iva;
			         } else {
					 	$("#Notacreditoprov_perciva").removeAttr('checked').attr('disabled','disabled');
					 	$("#totaldiv-perciva").css('display','none');
						if(estado == 1){
			           		$("#total-percivaNC").text("$0.00");
				         	$("#Notacreditoprov_importe_per_iva").val(null);
				         	$("#Notacreditoprov_importe_per_iva").css('display','none');
						  	$("#totaldiv-perciva").css('display','none');
						  	$("#totaldiv-percivaNC").css('display','none');
						  	totalperciva_ajax=0;
					  }
					 }  
						
					 if(data.descuento != null){
					 	$("#Notacreditoprov_desc").attr('checked',':checked').attr('disabled','disabled');
					 	$("#Notacreditoprov_descuento").removeAttr('readonly');
					 	$("#total-descuento").text('-$'+$.number(data.descuento,2));
					 	$("#totaldiv-descuentoNC").show();
					 	$("#total-descuentoNC").text("$0.00");
			          	$("#totaldiv-descuento").show();
			          	descuento_ajax=data.descuento;
			         } else {
					 	$("#Notacreditoprov_desc").removeAttr('checked').attr('disabled','disabled');
					 	if(estado == 1){
			           		$("#total-descuentoNC").text("$0.00");
				         	$("#Notacreditoprov_descuento").val(null);
				         	$("#Notacreditoprov_descuento").css('display','none');
						  	$("#totaldiv-descuento").css('display','none');
						  	$("#totaldiv-descuentoNC").css('display','none');
						  	descuento_ajax=0;
					  	} 
					 }
					 if(data.interes !== null){
					 	$("#Notacreditoprov_inter").attr('checked',':checked').attr('disabled','disabled');
					 	$("#Notacreditoprov_interes").removeAttr('readonly');
					 	$("#total-interes").text('$'+$.number(data.interes,2));
					 	$("#totaldiv-interesNC").show();
					 	$("#total-interesNC").text("$0.00");
			          	$("#totaldiv-interes").show();
			          	interes_ajax=data.interes;
			         } else {
					 	$("#Notacreditoprov_inter").removeAttr('checked').attr('disabled','disabled');
					 	if(estado == 1){
			           		$("#total-interesNC").text("$0.00");
				         	$("#Notacreditoprov_interes").val(null);
				         	$("#Notacreditoprov_interes").css('display','none');
						  	$("#totaldiv-interes").css('display','none');
						  	$("#totaldiv-interesNC").css('display','none');
						  	interes_ajax=0;
					  	} 
					 }
				
			} else {
				 
				 $(".facturaA").css('display', 'none');
  				 $("#facturac").show();
  				 $("#Notacreditoprov_importeneto")
  				 	.popover({ 
	        		placement:'right',
	        		title: 'TOTAL', 
	        		content: "Ingrese un importe menor o igual al Total de la factura seleccionada." })
		       		.popover('show');
  				 $("#totalivadiv").css('display','none');
  				 $("#totaldiv-netogravado").css('display','none');
  				 
				 $("#totalivadivNC").css('display','none');
				 $("#totaldiv-iibb").css('display','none');
				 $("#totaldiv-perciva").css('display','none');
				 $("#totaldiv-descuento").css('display','none');
				 $("#totaldiv-interes").css('display','none');
				 $("#totaldiv-iibbNC").css('display','none');
				 $("#totaldiv-percivaNC").css('display','none');
				 $("#totaldiv-descuentoNC").css('display','none');
				 $("#totaldiv-interesNC").css('display','none');
				 totalnetogravado_ajax=data.importeneto;
				}
			
			
			$("#totalnetoblock").text('$'+$.number(data.importeneto,2));
			
			
				//sumatotal();
			  },
		  dataType:"json"
			});
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

function sumatotal(){
var netogravado=parseFloat($("#Notacreditoprov_importebruto").val());
if((!isNaN(netogravado)) && (netogravado > totalnetogravado_ajax)){
	alert("Debe ingresar un valor menor o igual al Neto gravado de la compra seleccionada.");
	$("#Notacreditoprov_importebruto").val("");
	return false;
}
var input_netogravado=netogravado;

	if(tipofactura_ajax == 1){
		if(totalperciva_ajax != 0){
			var cof_per_iva= totalperciva_ajax/totalnetogravado_ajax;
		} else {
			var cof_per_iva=0;
		}
		if(descuento_ajax != 0){
			var cof_descuento= descuento_ajax/totalnetogravado_ajax;
		} else {
			var cof_descuento=0;
		}
		if(interes_ajax != 0){
			var cof_interes= interes_ajax/totalnetogravado_ajax;
		} else {
			var cof_interes=0;
		}
		if(totaliibb_ajax != 0){
			var cof_iibb= totaliibb_ajax/totalnetogravado_ajax;
		} else {
			var cof_iibb=0;
		}
	var totalpercepcionIIBB= cof_iibb * netogravado;
	var totalpercepcion_iva= cof_per_iva * netogravado;
	}

	if(tipofactura_ajax == 1){
	
	
		//console.log(netogravado);
	    if(isNaN(netogravado)){
	    	
	      $("#Notacreditoprov_ivatotal").val("");
	      $("#totalnetoblockNC").text('$0.00');
	      totaliva=0;
	    } else {

	      if((descuento_ajax == 0) && (interes_ajax == 0) ){
	        totaliva=netogravado * (cofiva_ajax - 1);
	        $("#Notacreditoprov_ivatotal").val(totaliva.toFixed(2));
	         totalIvaTrasfor = $.number(totaliva, 2);
	        $("#ivablockNC").text(totalIvaTrasfor);
	        

	      } else  {
	      	console.log(" interes:");
	        descuento= cof_descuento * netogravado;
	        interes= cof_interes * netogravado;
	        
	        if(descuento !== 0 ){
	        	$("#total-descuentoNC").text("-$"+$.number(descuento,2));
	        	$("#Notacreditoprov_descuento").val(descuento.toFixed(2));
	        } else {
	        	$("#total-descuentoNC").text("$0.00");
	        }
	         if(interes !== 0 ){
	        	$("#total-interesNC").text("$"+$.number(interes,2));
	        	$("#Notacreditoprov_interes").val(interes.toFixed(2));
	        } else  {
	        	$("#total-interesNC").text("$0.00");
	        	
	        }
	        netogravado=netogravado - descuento + interes ;
	        totaliva = netogravado * (cofiva_ajax - 1);
	        $("#Notacreditoprov_ivatotal").val(totaliva.toFixed(2));
	         totalIvaTrasfor = $.number(totaliva, 2);
	        $("#ivablockNC").text(totalIvaTrasfor);

	        
	      }
	  }
	 //console.log(totalpercepcionIIBB);
	 precioTOTAL=netogravado + totaliva + totalpercepcionIIBB + totalpercepcion_iva;
	  
	  if(totalpercepcionIIBB != 0){
	    totalpercepcionIIBB=totalpercepcionIIBB.toFixed(2);
	    $("#total-iibbNC").text($.number(totalpercepcionIIBB,2));
	  }
	  if(totalpercepcion_iva != 0){
	    totalpercepcion_iva=totalpercepcion_iva.toFixed(2);
	    $("#total-percivaNC").text($.number(totalpercepcion_iva,2));
	  }
	  if(!isNaN(precioTOTAL)){
	     $("#totalnetoblockNC").text(precioTOTAL.toFixed(2));
	     $("#Notacreditoprov_importeneto").val(precioTOTAL.toFixed(2));
	     botonsubmit('1');
	  }
	  
	  $("#totaldiv-netogravadoNC").show();
	  $("#total-netogravadoNC").text("$"+ $.number(input_netogravado,2));
	  if(isNaN(input_netogravado.toFixed(2))){
	  		valor=0.00;
	  }else {
	  		valor=input_netogravado;
	  		$("#Notacreditoprov_importebruto").val(parseFloat(valor));
	  }
	  
	
} else {
 	
 	preciototal=parseFloat($("#Notacreditoprov_importeneto").val());
 	if((!isNaN(preciototal)) && (preciototal > totalneto_ajax)){
 		alert("Debe ingresar un valor menor o igual al Importe Total de la compra seleccionada.");
		$("#Notacreditoprov_importeneto").val("");
		return false;
 	}
 	if(isNaN(preciototal)){
 		$("#totalnetoblockNC").text('$0.00');
  	} else {
 		$("#Notacreditoprov_importeneto").val(preciototal.toFixed(2));
 		$("#Notacreditoprov_importebruto").val(preciototal.toFixed(2));
  		$("#totalnetoblockNC").text("$"+$.number(preciototal.toFixed(2),2));
  		botonsubmit('1');
	}
 		
  }
} 
  function botonsubmit(estado){
	
	if(estado  == 0) {
		$("#boton-submit").attr("disabled","disabled");
	}else {
		$("#boton-submit").removeAttr("disabled");
	}
	
}
function resetInputs(){
	$("#Notacreditoprov_importeIIBB").val("");
	$("#Notacreditoprov_descuento").val("");
	$("#Notacreditoprov_interes").val("");
	$("#Notacreditoprov_importe_per_iva").val("");
	$("#Notacreditoprov_importebruto").val("");
	$("#Notacreditoprov_importeneto").val("");
	$("#Notacreditoprov_ivatotal").val("");
}