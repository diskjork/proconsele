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
var checked=$("#Notacreditoprov_iibb").attr('checked');
if(!(checked == "checked")){
   $("#Notacreditoprov_importeIIBB").attr('readonly','true');
  // $("#Notacreditoprov_importeIIBB").val("");
}

$("#Notacreditoprov_iibb").click(function() {  
        if($("#Notacreditoprov_iibb").is(':checked')) {  
          $("#Notacreditoprov_importeIIBB").removeAttr('readonly');
          $("#Notacreditoprov_importeIIBB").val("");
          $("#Notacreditoprov_importeIIBB").show();
          $("#totaldiv-iibbNC").show();
        } else {  
            $("#Notacreditoprov_importeIIBB").attr('readonly','true');
            $("#Notacreditoprov_importeIIBB").val("");
            $("#totaldiv-iibbNC").css('display','none');
       	}  
    }); 

$("#totalesfactura").css("display","none");
botonsubmit('0');
var tipo=$("#Notacreditoprov_tipofactura").val();
if(tipo == 2){
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
$("#Notacreditoprov_tipofactura").change(function(event){
	tiposelec=$("#Notacreditoprov_tipofactura").val();
	if(tiposelec == 1){
		$("#Notacreditoprov_ivatotal").val('');
		$("#Notacreditoprov_ivatotal").removeAttr('readonly');
		$("#ivablockNC").show();

	} else {
		$("#Notacreditoprov_ivatotal").val('');
		$("#Notacreditoprov_ivatotal").attr('readonly','true');
		$("#ivablockNC").text('');
	}
});
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
         	//$("#Notacreditoprov_nrodefactura").removeAttr('readonly');
         	
		  	$("#totaldiv-iibbNC").css('display','none');
		}
		sumatotal();
		ajaxFactura(this.value,'1');

	});
	sumatotal();
});
var totalneto_ajax=null; //total de la factura seleccionada
var totaliva_ajax=null; //total de la notacredito
var totaliibb_ajax=null; // ingreso brutos
function ajaxFactura(id, estado){

	var idfactura=id;

	$.ajax({ 
		  type: "POST",
		  url: "/proconsele/notacreditoprov/enviofactura",
		  data: {data:idfactura},
		  success: function (data){
		  	
			 totalajax=data.importeneto; //importe de la factura enviada por ajax
			$("#totalesfactura").show();
			$("#boton-submit").attr("disabled","disabled");
 
			 $("#Notacreditoprov_proveedor_idproveedor").select2("val", data.proveedor_idproveedor).select2('readonly', "true");
			 $("#Notacreditoprov_formadepago").select2("val", data.formadepago).select2('readonly', "true");
			 $("#Notacreditoprov_nrodefactura").val(data.nrodefactura).attr('readonly',true);
			 $("#Notacreditoprov_tipofactura").select2("val", data.tipofactura).select2('readonly', "true");
			
			if(estado == 1) {
			if(data.tipofactura == 1){
				$("#Notacreditoprov_ivatotal").val('');
				$("#Notacreditoprov_ivatotal").removeAttr('readonly');
				$("#ivablockNC").show();

			} else {
				$("#Notacreditoprov_ivatotal").val('');
				$("#Notacreditoprov_ivatotal").attr('readonly','true');
				$("#ivablockNC").text('');
				$("#ivablock").text('');
			}
			}
			 var tipofactura=data.tipofactura;
			 var importeIIBB=data.importeIIBB;
			  
			$("#totalnetoblock").text('$'+$.number(data.importeneto,2));
			if(data.ivatotal == null){
				$("#ivablock").text('');
			} else {
				$("#ivablock").text('$'+$.number(data.ivatotal,2));
			}
			$("#Notacreditoprov_iva").select2('val',data.iva).select2('readonly','true');
			totalneto_ajax=data.importeneto;
			totaliva_ajax=data.ivatotal;
			//sumaSubtotal();

			 if(data.importeIIBB !== null){
			 	$("#Notacreditoprov_iibb").attr('checked',':checked').attr('disabled','disabled');
			 	$("#totaldiv-iibb").show();
	          	$("#total-iibb").text($.number(data.importeIIBB,2));
	          	$("#Notacreditoprov_importeIIBB").show();
	          	$("#Notacreditoprov_importeIIBB").removeAttr('readonly');
	          	$("#totaldiv-iibbNC").show();
	          	totaliibb_ajax=data.importeIIBB;
	         } else {
			 	$("#Notacreditoprov_iibb").removeAttr('checked').attr('disabled','disabled');
			 	$("#totaldiv-iibb").css('display','none');
				if(estado == 1){
           		$("#total-iibbNC").text('');
	         	$("#Notacreditoprov_importeIIBB").val(null);
	         	$("#Notacreditoprov_importeIIBB").css('display','none');
			  	$("#totaldiv-iibbNC").css('display','none');
			  	$("#totaldiv-iibbNC").css('display','none');
			  	totaliibb_ajax=0;
			  } 
			 }
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

  var totalpercepcionIIBB=parseFloat($("#Notacreditoprov_importeIIBB").val());
  var totaliva=parseFloat($("#Notacreditoprov_ivatotal").val());
  var totalneto=parseFloat($("#Notacreditoprov_importeneto").val());
  //console.log("ajax:"+totalneto_ajax+" importe:"+totalneto);
  if((totalneto_ajax != null) && (totalneto_ajax < totalneto)){
  	alert("El Importe Neto ingresado es mayor al Importe Neto de la factura seleccionada.");
  	$("#Notacreditoprov_importeneto").val("");
  	botonsubmit('0');
  }
  if((totaliva_ajax != null) && (totaliva_ajax < totaliva)){
  	alert("El Importe IVA total es mayor al  IVA de la factura seleccionada.");
  	$("#Notacreditoprov_ivatotal").val(null);
  	botonsubmit('0');
  }
  if(totalpercepcionIIBB >= totalneto || totaliva >= totalneto){
    alert("Importe IVA o Importe IIBB no pueden ser mayores que Importe Neto.")
    $("#Notacreditoprov_ivatotal").val("");
    $("#Notacreditoprov_importeneto").val("");
    botonsubmit('0');
  }
  var seleccion=$('option:selected', "#Notacreditoprov_tipofactura").attr('value');
  console.log(totaliva);
  
  if((seleccion == 1) && (isNaN(totaliva)) && (!isNaN(totalneto))){
     alert('Complete "Importe IVA" No puede ser nulo ');
     $("#Notacreditoprov_importeneto").val("");
     botonsubmit('0');

  }
  if(totalpercepcionIIBB != null){
    totalpercepcionIIBB=totalpercepcionIIBB.toFixed(2);
    $("#total-iibbNC").text($.number(totalpercepcionIIBB,2));
  }
  totalnetotransfor = $.number( totalneto, 2 );

  
  totalIvaTrasfor = $.number(totaliva, 2);
  $("#totalnetoblockNC").text(totalnetotransfor);
  tipofac=$("#Notacreditoprov_tipofactura").val();
  if(tipofac == 2){
	  	$("#ivablockNC").text('');
	  }else { 
	    $("#ivablockNC").text(totalIvaTrasfor);
  }
	 if(($("#Notacreditoprov_importeneto").val()) != ""){
	  	botonsubmit('1');
	  } else {
	  		botonsubmit('0');
	  }
  
  }
  function botonsubmit(estado){
	
	if(estado  == 0) {
		$("#boton-submit").attr("disabled","disabled");
	}else {
		$("#boton-submit").removeAttr("disabled");
	}
	
}