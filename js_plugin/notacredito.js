$(document).on('ready',function(){
// para bloquear la tecla enter 	
$("input").keypress(function (evt) {
	var charCode = evt.charCode || evt.keyCode;
	if (charCode  == 13) { 
	return false;
		}
	});
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
botonsubmit('0');
});
var totalajax=null; //total de la factura seleccionada
var TOTALNETO=0.00; //total de la notacredito


function sumatotal(){
	var subtotalbruto=parseFloat($("#Notacredito_stbruto_producto").val());
	var checkdescRec=$("input[name='Notacredito[desRec]']:checked", "#Notacredito-form").val();
	var deReBloc=parseFloat($("#Notacredito_descrecar").val());
	var checkiibb=$("input[name='Notacredito[iibb]']:checked", "#Notacredito-form").val();

	var coficienteiibb=parseFloat($("#Notacredito_retencionIIBB").val());
	var checkimpint=$("input[name='Notacredito[impInt]']:checked", "#Notacredito-form").val();
	var coficienteimpint=parseFloat($("#Notacredito_impuestointerno").val());
	var e=$("#Notacredito_iva").val(); // % IVA
	var IVA=parseFloat(e); //coeficiente iva por ej: 1,21 o 1,105
	
	var subtotalbruto_B=0;
	var tipofactura=$("#Notacredito_tipofactura").val(); // A o B
	// para el caso de factura "B"
	if(tipofactura == 2){ 
		subtotalbruto_B= subtotalbruto / IVA;// sin iva
	}
	
	var cofIVA=IVA - 1;
	var descRecar=1;
	var SUBtotal=0.00;
	var TOTALNETO=0.00; // total general 
	var TOTALiva=0;
	var TOTALdes_rec=0;
	
//----------------descuento-Recargo--------------
	Descuento=1;
	Recargo=1;

	if((checkdescRec == 1) && (!isNaN(deReBloc)))
	{
		var e=$("input[name='Notacredito[tipodescrecar]']:checked", "#Notacredito-form").val();

		if(e == 0){ //descuento
			
			descRecar=parseFloat(deReBloc);
			Descuento=descRecar/100;
						
			$("#descuento_recargoNC").text("Descuento");
			$("#desc_recarNC").show();
			
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
		if(tipofactura == 2){  //factura B
			TOTALdes_rec=subtotalbruto_B * Descuento;
			var importe_des= $.number( TOTALdes_rec, 2 );
			$("#descuento_recargo_importeNC").text("-"+importe_des);
			subtotalbruto_B=subtotalbruto_B - TOTALdes_rec;
		} else {
		// para el caso de una factura A
		TOTALdes_rec=subtotalbruto * Descuento;
		var importe_des= $.number( TOTALdes_rec, 2 );
		$("#descuento_recargo_importeNC").text("-"+importe_des);
		subtotalbruto=subtotalbruto - TOTALdes_rec;
		}
		
	} 
	if(Recargo != 1){
	//factura B
		if(tipofactura == 2){  
			TOTALdes_rec= subtotalbruto_B * Recargo;
			subtotalbruto_B=subtotalbruto_B + TOTALdes_rec;
			var rec_impote= $.number(TOTALdes_rec, 2 ); 
			$("#descuento_recargo_importeNC").text(rec_impote);
		} else { 
	// para el caso de una factura A
		TOTALdes_rec= subtotalbruto * Recargo;
		subtotalbruto=subtotalbruto + TOTALdes_rec;
		var rec_impote= $.number(TOTALdes_rec, 2 ); 
		$("#descuento_recargo_importeNC").text(rec_impote);
	}
	}
	
//----------------------IMPUESTO INTERNO---------------------------

	TOTALimpint=0;
	if((checkimpint == 1) && (!isNaN(coficienteimpint)))
	{
		coficienteimpint= coficienteimpint/100;
		//factura B
		if(tipofactura == 2){  
			TOTALimpint=coficienteimpint * subtotalbruto_B;
		} else {
			TOTALimpint=coficienteimpint * subtotalbruto;
		}

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
	if(tipofactura == 1){
		subtotalbruto=subtotalbruto + TOTALimpint;
		TOTALiva= subtotalbruto * cofIVA;
	} else {
		subtotalbruto_B= subtotalbruto_B + TOTALimpint;
		subtotalbruto_B_con_iva= subtotalbruto_B * IVA;
	}
	
	//----------------CALCULO TOTALNETO--------------------

		 if(tipofactura == 2){  //factura B
			
			SUBtotal=subtotalbruto_B_con_iva;
			TOTALiva=subtotalbruto_B * cofIVA;
			TOTALNETO=subtotalbruto_B_con_iva;
		} else {
		 SUBtotal= subtotalbruto;
		 TOTALNETO= subtotalbruto + TOTALiva;
	}

//----------------------IIBB---------------------------
	
	var TOTALiibb=0;
	
	if((checkiibb == 1) && (!isNaN(coficienteiibb)))
	{
		coficienteiibb= coficienteiibb/100;
	
	}
	
//------------------FINAL--------------------------
	
	if(!isNaN(coficienteiibb)){
		if(tipofactura == 2){
			TOTALiibb=subtotalbruto_B_con_iva * coficienteiibb;
			TOTALNETO=TOTALNETO + TOTALiibb;
		} else {
			TOTALiibb=coficienteiibb * SUBtotal;
			TOTALNETO=TOTALNETO + TOTALiibb;
		}
		
		var importeiibb=$.number(TOTALiibb, 2);
		$("#total-iibbNC").text(importeiibb);

		$("#Notacredito_importeIIBB").val(TOTALiibb);
		$("#totaldiv-iibbNC").show();
	} 

	totaltransfor= $.number( SUBtotal, 2 ); 
	totalnetotransfor = $.number( TOTALNETO, 2 );
	

	$("#subtotalblockNC").text(totaltransfor);
	$("#Notacredito_importebruto").val(SUBtotal.toFixed(2));
	$("#totalnetoblockNC").text(totalnetotransfor);
	$("#Notacredito_importeneto").val(TOTALNETO.toFixed(2));
	
	totalIvaTrasfor = $.number(TOTALiva, 2);
	
	if(tipofactura == 1){
		$("#ivablockNC").text(totalIvaTrasfor);
		$("#totalivadivNC").show();
		$("#totalivadiv").show();
	} else {
		$("#totalivadivNC").css('display','none');
		$("#totalivadiv").css('display','none');
	}
	
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
	
	var codigo=$('#Notacredito_producto_idproducto').val();
	var cantidad=$('#Notacredito_cantidadproducto').val();
	
		if((cantidad == "") || (codigo == "")){
			alert("Debe ingresar un producto");
			return false;
			} 
	var cantidad=parseFloat(cantidad);
	var precio=parseFloat($('#Notacredito_precioproducto').val());
	var tipofactura=$('#Notacredito_tipofactura').val();
	var cofiva=parseFloat($('#Notacredito_iva').val());
	if(tipofactura == 2){
					var subtotal= cantidad * precio;
					var subtotal= subtotal * cofiva;
					
				} else if(tipofactura == 1){
					var subtotal=cantidad * precio;
				}
	
	$('#Notacredito_stbruto_producto').val(subtotal.toFixed(2));
	
}

function botonsubmit(estado){
	
	if(estado  == 0) {
		$("#boton-submit").attr("disabled","disabled");
	}else {
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
        		title: 'Cantidad Producto', content: "Debe ingresar una cantidad menor a la especificada cuando recibe mercadería en devolución. En el caso de anular la factura completa deje la cantidad especificada. TOCAR PARA CARGAR" })
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
			
			 var tipofactura=data.tipofactura;
			  var cofiva=parseFloat(data.iva);
			  var precio=data.precioproducto;

			  if(tipofactura == 2){
					var subtotal= cant_ajax * precio;
					var subtotal= cant_ajax * cofiva;
					
				} else if(tipofactura == 1){
					var subtotal=cant_ajax * precio;
				}
			 $("#Notacredito_stbruto_producto").val(subtotal.toFixed(2));
			 $("#Notacredito_iva").select2('val',data.iva).select2('readonly','true');
			 
			 $("#subtotalblock").text('$'+$.number(data.importebruto,2));
			 $("#totalnetoblock").text('$'+$.number(data.importeneto,2));
			 $("#ivablock").text('$'+$.number(data.ivatotal,2));
			 
			 sumaSubtotal();

			 if(data.importeIIBB !== null){
			 	$("#Notacredito_iibb").attr('checked',':checked').attr('disabled','disabled');
			 	$("#Notacredito_retencionIIBB").show();
	          	$("#totaldiv-iibb").show();
	          	$("#Notacredito_retencionIIBB").val(data.retencionIIBB).attr('readonly',true);
	          	$("#total-iibb").text($.number(data.importeIIBB,2));
	         } else {
			 	$("#Notacredito_iibb").removeAttr('checked').attr('disabled','disabled');
			 	$("#Notacredito_retencionIIBB").css('display','none');
	            $("#Notacredito_retencionIIBB").val("");
	            $("#totaldiv-iibb").css('display','none');
				
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
		           
		        } else {  
		        	$("#Notacredito_impInt").removeAttr('checked').attr('disabled','disabled');
		            $("#Notacredito_impuestointerno").css('display','none');
		            $("#Notacredito_impuestointerno").val("");
		            $("#descripcionimpint").css('display','none');
		            $("#totaldiv-impint").css('display','none');
		            $("#Notacredito_desc_imp_interno").val(null);
		         
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