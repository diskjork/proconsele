$(document).on('ready',function(){

$("#Notacredito_retencionIIBB").css('display','none');
$("#Notacredito_impuestointerno").css('display','none');
$("#Notacredito_nrodenotacredito").keydown(function(event){
	solonumeromod(event);});
$("#Notacredito_retencionIIBB").keydown(function(event){
	solonumeromod(event);});
$("#Notacredito_descrecar").keydown(function(event){
		solonumeromod(event);});
$("#Notacredito_cantidadproducto").keydown(function(event){
		solonumeromod(event);});
$("#Notacredito_producto_idproducto").keydown(function(event){
		solonumeromod(event);});
$("#Notacredito_precioproducto").keydown(function(event){
		solonumeromod(event);});
$("#Notacredito_impuestointerno").keydown(function(event){
		solonumeromod(event);});
$("#Notacredito_descrecar").keydown(function(event){
		solonumeromod(event);});
var factura=$("#Notacredito_factura_idfactura").val();

if(factura != null){
ajaxFactura(factura, '0');
}
$("#Notacredito_factura_idfactura").change(function(event){
		ajaxFactura(this.value,'1');
	});

});
var totalajax=null; //total de la factura seleccionada
var TOTALNETO=0.00; //total de la notacredito


function sumatotal(){
	
	
	var subtotalbruto=parseFloat($("#Notacredito_stbruto_producto").val());
	var checkdescRec=$("input[name='Notacredito[desRec]']:checked", "#Notacredito-form").val();
	var checkiibb=$("input[name='Notacredito[iibb]']:checked", "#Notacredito-form").val();

	var coficienteiibb=parseFloat($("#Notacredito_retencionIIBB").val());
	var checkimpint=$("input[name='Notacredito[impInt]']:checked", "#Notacredito-form").val();
	var coficienteimpint=parseFloat($("#Notacredito_impuestointerno").val());
	var e=$("#Notacredito_iva").val();
	var ei=parseFloat(e); //coeficiente iva por ej: 1,21 o 1,105
	var cofIVA=ei - 1;
	var descRecar=1;
	var deReBloc=parseFloat($("#Notacredito_descrecar").val());
	var SUBtotal;
	//var TOTALNETO=0.00;
	var TOTALimpint=0;
	
	var TOTALiva=0;
	var TOTALdes_rec=0;
//----------------descuento-Recargo--------------
	Descuento=1;
	Recargo=1;
	if((checkdescRec == 1) && (!isNaN(deReBloc)))
	{
	
	
		var e=$("input[name='Notacredito[tipodescrecar]']:checked", "#Notacredito-form").val();

			
		if(e == 0){ //descuento
			//if( deReBloc == "")$("#desc_recar").css("display","none"); 
			descRecar=parseFloat(deReBloc);
			Descuento=descRecar/100;
						
			$("#descuento_recargoNC").text("Descuento");
			$("#desc_recarNC").show();
			//totalneto=totalneto * descRecar;
			}
		if(e == 1){ //recargo
			var deReBloc=$("#Notacredito_descrecar").val();
			descRecar=parseFloat(deReBloc);
			Recargo=descRecar/100;
			
			
			$("#descuento_recargoNC").text("Recargo");
			$("#desc_recarNC").show();
			
		}

	} else	{
		$("#desc_recarNC").css("display","none");
		//$("input[name='Notacredito[tipodescrecar]']:unchecked", "#Notacredito-form");

		}
	if(Descuento != 1){
		console.log(Descuento);
		TOTALdes_rec=subtotalbruto * Descuento;
		var importe_des= $.number( TOTALdes_rec, 2 );
		$("#descuento_recargo_importeNC").text("-"+importe_des);
		subtotalbruto=subtotalbruto - TOTALdes_rec;
	} 
	if(Recargo != 1){
		console.log(Recargo);
		TOTALdes_rec= subtotalbruto * Recargo;
		subtotalbruto=subtotalbruto + TOTALdes_rec;
		var rec_impote= $.number(TOTALdes_rec, 2 ); 
		$("#descuento_recargo_importeNC").text(rec_impote);
	}
	
//----------------------IMPUESTO INTERNO---------------------------
//console.log("checkimpint="+checkiibb+" coficienteimpint="+coficienteiibb);
	
	if((checkimpint == 1) && (!isNaN(coficienteimpint)))
	{
		coficienteimpint= coficienteimpint/100;
		TOTALimpint=coficienteimpint * subtotalbruto;

		var impint=TOTALimpint.toFixed(2);
		var importeint=$.number(impint, 2);

		$("#total-impintNC").text(importeint);
		$("#Notacredito_impuestointerno").show();
		$("#descripcionimpintNC").show();
		$("#Notacredito_importeImpInt").val(TOTALimpint);
		$("#totaldiv-impintNC").show();
		console.log("si se corre"+"checkimpint: "+checkimpint+" coficienteimpint"+coficienteimpint);
	}

	//-----------------------IVA----------------------------
	TOTALiva=subtotalbruto * cofIVA;
	
	//----------------CALCULO TOTALNETO--------------------

		 TOTALNETO=subtotalbruto+TOTALiva+TOTALimpint;
		 SUBtotal=subtotalbruto;
		 //console.log("suma: "+coficienteiibb);
		//SUBtotal=TOTALNETO;

	//----------------------IIBB---------------------------
	//console.log("checkiibb="+checkiibb+" coficienteiibb="+coficienteiibb);
	var TOTALiibb=0;
	
	if((checkiibb == 1) && (!isNaN(coficienteiibb)))
	{
		coficienteiibb= coficienteiibb/100;
		
		

	}
	
//------------------FINAL--------------------------
	//$("#Notacredito_importe").val(totalneto.toFixed(2));
	//$("#Notacredito_subtotal").val(total.toFixed(2));
	

	if(!isNaN(coficienteiibb)){
		TOTALiibb=coficienteiibb * TOTALNETO;
		SUBtotal=TOTALNETO;
		TOTALNETO=TOTALNETO + TOTALiibb;
		var importeiibb=$.number(TOTALiibb, 2);
		$("#total-iibbNC").text(importeiibb);

		$("#Notacredito_importeIIBB").val(TOTALiibb);
		$("#totaldiv-iibbNC").show();
	} 
	totaltransfor= $.number( SUBtotal, 2 ); 
	totalnetotransfor = $.number( TOTALNETO, 2 );
	totalIvaTrasfor = $.number(TOTALiva, 2);
	
	/*
	if(totalajax != null){
	var res=totalajax - TOTALNETO.toFixed(2);
	console.log("res"+res);
	if(res < 0){

		alert("Debe ingresar una cantidad de productos igual o menor a la ingresada en la factura seleccionada ('"+cantidadproductoajax+"').");
		$("#Notacredito_cantidadproducto").val(cantidadprod);
		botonsubmit('0');
		return false;
		//var es=0;
		
		

	}else {

		botonsubmit('1');
	}
	}*/

	$("#subtotalblockNC").text(totaltransfor);
	$("#Notacredito_importebruto").val(SUBtotal.toFixed(2));
	$("#totalnetoblockNC").text(totalnetotransfor);
	$("#Notacredito_importeneto").val(TOTALNETO.toFixed(2));
	$("#ivablockNC").text(totalIvaTrasfor);
	if(TOTALiva == 0){
		$("#Notacredito_ivatotal").val(null);
	} else {
		$("#Notacredito_ivatotal").val(TOTALiva.toFixed(2));
	}
	
	if(TOTALimpint == 0){
		$("#Notacredito_impuestointerno").val(null);
	} else {
		$("#Notacredito_importeImpInt").val(TOTALimpint.toFixed(2));
	}
	if(TOTALiibb == 0){
		$("#Notacredito_importeIIBB").val(null);
	} else {
	$("#Notacredito_importeIIBB").val(TOTALiibb.toFixed(2));
	}
	
	
	//console.log("iva: "+totalIvaTrasfor+" tbruto: "+totaltransfor+" neto: "+totalnetotransfor);
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


function blurcantidad(obj){
	var id_input=obj.id;
	cant=parseFloat(cant_ajax); //enviado por la factura
	valor=parseFloat(obj.val); //lo seleccionado del input cantidadproducto
	console.log("cantidad PR:"+cant_ajax+ "  obj:"+obj.val);
	if(cant < valor){
		
		alert("Debe ingresar una cantidad de productos igual o menor a la ingresada en la factura seleccionada ('"+cant_ajax+"').");
		$("#Notacredito_cantidadproducto").val(cantidadprod_seleccionado);
		botonsubmit('0');
		return false;
	}
	var c=$('#Notacredito_producto_idproducto').val();
	if( c != ""){
		sumaSubtotal();
		sumatotal();
		botonsubmit('1');
		}
}

function sumaSubtotal(){
	
	
	//var n = id_input.search("cantidad"); //para saber si lo ejecuta el input cantidad o el de precio
	//alert(n);
	
	var codigo=$('#Notacredito_producto_idproducto').val();
	var cantidad=$('#Notacredito_cantidadproducto').val();
	
		if((cantidad == "") || (codigo == "")){
			alert("Debe ingresar un producto");
			return false;
			} 
	var cantidad=parseFloat(cantidad);
	var precio=parseFloat($('#Notacredito_precioproducto').val());
	
	var subtotal=cantidad * precio;
	$('#Notacredito_stbruto_producto').val(subtotal.toFixed(2));
	
}

function botonsubmit(estado){
	
	if(estado  == 0) {
		//alert("style:"+tr+"---columnas: "+columnas);
		$("#boton-submit").attr("disabled","disabled");
		//$("#boton-submit").removeAttr("disabled"); }
	 }else {
		//$("#boton-submit").attr("disabled","disabled");
		$("#boton-submit").removeAttr("disabled");
	}
	
}
var cantidadprod_seleccionado;
var cant_ajax;
function ajaxFactura(id, estado){

	var idfactura=id;

	$.ajax({ 
		  type: "POST",
		  url: "/proconsele/notacredito/enviofactura",
		  data: {data:idfactura},
		  success: function (data){

			 totalajax=data.importeneto; //importe de la factura enviada por ajax

			 $("#boton-submit").attr("disabled","disabled");
			 
    			$("#Notacredito_cantidadproducto")
        		.popover({ 
        		placement:'left'	,
        		title: 'Cantidad Producto', content: "Debe ingresar una cantidad menor a la especificada cuando recive mercadería en devolución. En el caso de anular la factura completa deje la cantidad especificada. TOCAR PARA CARGAR" })
	       		.popover('show');
	       	
	       	 if(estado == 0){ // sin change
	       	 		cantidadprod_seleccionado=$("#Notacredito_cantidadproducto").val();
	       	 		cant_ajax=data.cantidadproducto;
	       	 
	       	 } else if(estado == 1){ // con change
	       	 		cantidadprod_seleccionado=data.cantidadproducto;
	       	 		cant_ajax=data.cantidadproducto;
	       	 		$("#Notacredito_cantidadproducto").val(data.cantidadproducto);
	       	 }
	       	 console.log(cant_ajax);
	       	 
			 $("#Notacredito_cliente_idcliente").select2("val", data.cliente_idcliente).select2('readonly', "true");
			 $("#Notacredito_formadepago").select2("val", data.formadepago).select2('readonly', "true");
			 $("#Notacredito_nrodefactura").val(data.nrodefactura).attr('readonly',true);
			 $("#Notacredito_tipofactura").select2("val", data.tipofactura).select2('readonly', "true");
			 $("#Notacredito_precioproducto").val(data.precioproducto).attr('readonly',true);
			 $("#Notacredito_nombreproducto").val(data.nombreproducto).attr('readonly',true);
			 $("#Notacredito_producto_idproducto").val(data.producto_idproducto).attr('readonly',true);
			 //$("#Notacredito_importebruto").val(data.importebruto);
			 $("#Notacredito_stbruto_producto").val(data.stbruto_producto);
			 $("#Notacredito_iva").select2('val',data.iva).select2('readonly','true');
			 //$("#Notacredito_ivatotal").val(data.iva);
			 $("#subtotalblock").text('$'+data.importebruto);
			 $("#totalnetoblock").text('$'+data.importeneto);
			 $("#ivablock").text('$'+data.ivatotal);
			 
			 sumaSubtotal();

			 if(data.importeIIBB !== null){
			 	$("#Notacredito_iibb").attr('checked',':checked').attr('disabled','disabled');
			 	$("#Notacredito_retencionIIBB").show();
	          	$("#totaldiv-iibb").show();
	          	$("#Notacredito_retencionIIBB").val(data.retencionIIBB).attr('readonly',true);
	          	$("#total-iibb").text(data.importeIIBB);
	          //$("#Notacredito_retencionIIBB").parent().append("<span> %</span>");
	          
        
			 } else {
			 	$("#Notacredito_iibb").removeAttr('checked').attr('disabled','disabled');;
			 	$("#Notacredito_retencionIIBB").css('display','none');
	            $("#Notacredito_retencionIIBB").val("");
	            $("#totaldiv-iibb").css('display','none');
				//$("#Notacredito_retencionIIBB").parent().find("span").remove();
           		if(estado == 1){
           		$("#total-iibbNC").text('');
	         	$("#Notacredito_importeIIBB").val(null);
			  	$("#totaldiv-iibbNC").css('display','none');
			  }
			 }
			
		     if(data.importeImpInt != null) {  
		     	$("#Notacredito_impInt").attr('checked',':checked').attr('disabled','disabled');
		          $("#Notacredito_impuestointerno").show();
		          $("#totaldiv-impint").show();
		          $("#Notacredito_impuestointerno").val(data.impuestointerno).attr('readonly',true);
		          $("#total-impint").text($.number(data.importeImpInt,2));
		          $("#descripcionimpint").show();
		          $("#Notacredito_desc_imp_interno").val(data.descripcionimpint).attr('readonly',true);
		         // $("#Notacredito_impuestointerno").parent().append("<span> %</span>");

		         
		          
		        } else {  
		        	$("#Notacredito_impInt").removeAttr('checked').attr('disabled','disabled');
		            $("#Notacredito_impuestointerno").css('display','none');
		            $("#Notacredito_impuestointerno").val("");
		            $("#descripcionimpint").css('display','none');
		            $("#totaldiv-impint").css('display','none');
		            $("#Notacredito_desc_imp_interno").val(null);
		           // $("#Notacredito_importeImpInt").val();
		            //$("#Notacredito_impuestointerno").parent().find("span").remove();
		          if(estado == 1){
		            $("#total-impintNC").text("");
					$("#Notacredito_impuestointerno").css('display','none');
					$("#Notacredito_impuestointerno").val(null);
					$("#descripcionimpintNC").css('display','none');
					$("#Notacredito_importeImpInt").val(null);
					$("#totaldiv-impintNC").css('display','none');
					}
        		}
        		
		        if(data.descrecar != null) {  
		          $("#Notacredito_desRec").attr('checked',':checked').attr('disabled','disabled');
		          $("#radiobutton-descRec").show();
		          if(data.tipodescrecar == 0){
		          	
		          	$("#Notacredito_tipodescrecar_0").attr('checked',':checked').attr('disabled','disabled');
		          	$("#descuento_recargo").text("Descuento");
					$("#desc_recar").show();
		          	var res=data.stbruto_producto * (data.descrecar /100);
		          	$("#descuento_recargo_importe").text('-'+$.number(res,2))
		          	
		          

		          } else if(data.tipodescrecar == 0){
		          	$("#Notacredito_tipodescrecar_1").attr('checked',':checked').attr('disabled','disabled');
		          	$("#descuento_recargo").text("Recargo");
					$("#desc_recar").show();
					var res=data.stbruto_producto * (1 + (data.descrecar /100));
		          	$("#descuento_recargo_importe").text($.number(res,2));
		          		          
		          }
		          $("#Notacredito_descrecar").val(data.descrecar).attr('readonly',true);
		          //$("#total-iibb").text("");
		         // $("#Notacredito_descrecar").parent().append("<span> %</span>");
		         
		        } else {  
		        	 $("#Notacredito_desRec").removeAttr('checked').attr('disabled','disabled');
		             $("#radiobutton-descRec").css('display','none');
		             $("#Notacredito_descrecar").val(null);
		             $("#Notacredito_tipodescrecar_0").attr('checked',false);
		             $("#Notacredito_tipodescrecar_1").attr('checked',false);
		             $("#Notacredito_descrecar").parent().find("span").remove();
		             $("#desc_recar").css('display','none');
		             
					 if(estado == 1){
			             $("#descuento_recargoNC").text('');
						 $("#desc_recarNC").css('display','none');
						 $("#descuento_recargo_importeNC").text('');
					 }
       				 }  
   

       			sumatotal();
			  },
		  dataType:"json"
			});
}