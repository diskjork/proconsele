$(document).on('ready',function(){
$("#boton-submit").attr("disabled","disabled");
$("input").keypress(function (evt) {
	//Deterime where our character code is coming from within the event
	var charCode = evt.charCode || evt.keyCode;
	if (charCode  == 13) { //Enter key's keycode
	return false;
		}
	});
//$("#Factura_descrecar").parent().append("<span> %</span>");
$("#Factura_retencionIIBB").css('display','none');
$("#Factura_percepcion_iva").css('display','none');
$("#Factura_impuestointerno").css('display','none');
$("#Factura_impuestointerno").css('display','none');
$("#Factura_nrodefactura").keydown(function(event){
	solonumeromod(event);});
$("#Factura_retencionIIBB").keydown(function(event){
	solonumeromod(event);});
$("#Factura_descrecar").keydown(function(event){
		solonumeromod(event);});
$("#Factura_cantidadproducto").keydown(function(event){
		solonumeromod(event);});
$("#Factura_producto_idproducto").keydown(function(event){
		solonumeromod(event);});
$("#Factura_producto_idproducto").tooltip({
				title: "Tab para cambiar el precio automáticamente"
			});
$("#Factura_precioproducto").keydown(function(event){
		solonumeromod(event);});
$("#Factura_precioproducto").attr('readonly',true).tooltip({
				title: "Doble click para cambiar el precio manualmente"
			});

$("#Factura_impuestointerno").keydown(function(event){
		solonumeromod(event);});
$("#Factura_descrecar").keydown(function(event){
		solonumeromod(event);});
$("#Factura_tipofactura").change(function(event){
		resetValores();
		sumatotal();


	});
$("#Factura_tipodescrecar_0").change(function(event){
	sumatotal();
});
$("#Factura_tipodescrecar_1").change(function(event){
	sumatotal();
});
$("#Factura_iva").change(function(event){
	var valor=$("#Factura_producto_idproducto").val();
	var idinp="Factura_producto_idproducto";
	var obj={id:idinp, val:valor};
	codigo(obj);
});
sumatotal();
botonsubmit();

$("#Factura_desRec").click(function() {  
        if($("#Factura_desRec").is(':checked')) {  
          $("#radiobutton-descRec").show();
          //$("#totaldiv-iibb").show();
          $("#Factura_descrecar").val();
          //$("#total-iibb").text("");
          $("#Factura_descrecar").parent().append("<span> %</span>");
          sumatotal();
        } else {  
            $("#radiobutton-descRec").css('display','none');
            $("#Factura_descrecar").val(null);
            $("#Factura_tipodescrecar_0").attr('checked',false);
            $("#Factura_tipodescrecar_1").attr('checked',false);


            $("#Factura_descrecar").parent().find("span").remove();
            sumatotal();
        }  
    }); 
$("#Factura_iibb").click(function() {  
        if($("#Factura_iibb").is(':checked')) {  
          $("#Factura_retencionIIBB").show();
          $("#totaldiv-iibb").show();
          $("#Factura_retencionIIBB").val("");
          $("#total-iibb").text("");
          $("#Factura_retencionIIBB").parent().append("<span> %</span>");
          sumatotal();
        } else {  
            $("#Factura_retencionIIBB").css('display','none');
            $("#Factura_retencionIIBB").val("");
            //$("#Factura_importeIIBB").val();
            $("#totaldiv-iibb").css('display','none');

            $("#Factura_retencionIIBB").parent().find("span").remove();
            sumatotal();
        }  
    }); 
$("#Factura_perciva").click(function() {  
        if($("#Factura_perciva").is(':checked')) {  
          $("#Factura_percepcion_iva").show();
          $("#totaldiv-perciva").show();
          $("#Factura_percepcion_iva").val("");
          $("#total-perciva").text("");
          $("#Factura_percepcion_iva").parent().append("<span> %</span>");
          sumatotal();
        } else {  
            $("#Factura_percepcion_iva").css('display','none');
            $("#Factura_percepcion_iva").val("");
            //$("#Factura_importeIIBB").val();
            $("#totaldiv-perciva").css('display','none');

            $("#Factura_percepcion_iva").parent().find("span").remove();
            sumatotal();
        }  
    }); 
$("#Factura_impInt").click(function() {  
     if($("#Factura_impInt").is(':checked')) {  
          $("#Factura_impuestointerno").show();
          $("#totaldiv-impint").show();
          $("#Factura_impuestointerno").val("");
          $("#total-impint").text("");
          $("#descripcionimpint").show();
          $("#Factura_impuestointerno").parent().append("<span> %</span>");
          sumatotal();
        } else {  
            $("#Factura_impuestointerno").css('display','none');
            $("#Factura_impuestointerno").val("");
            $("#Factura_importeImpInt").val("");
            $("#descripcionimpint").css('display','none');
            $("#totaldiv-impint").css('display','none');
            $("#Factura_desc_imp_interno").val(null);
           // $("#Factura_importeImpInt").val();
            $("#Factura_impuestointerno").parent().find("span").remove();
            sumatotal();
        }  
    });   
});

function sumatotal(){
	
	
	var subtotalbruto=parseFloat($("#Factura_stbruto_producto").val()); // sin impuestos

	var netogravado=subtotalbruto; //neto sin impuesto ni descuentos ni recargos
	
	var tipofactura=$("#Factura_tipofactura").val(); // A o B
	
	var checkdescRec=$("input[name='Factura[desRec]']:checked", "#factura-form").val();//hay descuento o recargo?
	var deReBloc=parseFloat($("#Factura_descrecar").val()); // % de descuento o recargo

	var checkiibb=$("input[name='Factura[iibb]']:checked", "#factura-form").val(); // existe IIBB?
	var coficienteiibb=parseFloat($("#Factura_retencionIIBB").val()); // % de ingreso bruto

	var checkperciva=$("input[name='Factura[perciva]']:checked", "#factura-form").val(); // existe Per.IVA?
	var coficienteperciva=parseFloat($("#Factura_percepcion_iva").val()); // % de percepcion iva

	var checkimpint=$("input[name='Factura[impInt]']:checked", "#factura-form").val(); // existe impuesto interno?
	var coficienteimpint=parseFloat($("#Factura_impuestointerno").val());//% impuesto interno
	
	var e=$("#Factura_iva").val(); // % IVA
	var IVA=parseFloat(e); //coeficiente iva por ej: 1,21 o 1,105
	//console.log("suma: "+subtotalbruto);
	var subtotalbruto_B=0;
	
	// para el caso de factura "B"
	if(tipofactura == 2){ 
		subtotalbruto_B= subtotalbruto; // con IVA traido desde ajax
		netogravado=(subtotalbruto / IVA);// sin iva
		
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
		var e=$("input[name='Factura[tipodescrecar]']:checked", "#factura-form").val();
		if(e === undefined){
			alert("Debe Seleccionar Descuento o Recargo");
			return false;
		}
		if(e == 0){ //descuento
			descRecar=parseFloat(deReBloc);
			Descuento=descRecar/100;
				
			$("#descuento_recargo").text("Descuento");
			$("#desc_recar").show();
			
		}
		if(e == 1){ //recargo
			var deReBloc=$("#Factura_descrecar").val();
			descRecar=parseFloat(deReBloc);
			Recargo=descRecar/100;
						
			$("#descuento_recargo").text("Recargo");
			$("#desc_recar").show();
		}

	} else	{
		$("#desc_recar").css("display","none");
	}
// para hacer efecto el descuento o el recargo
	if(Descuento != 1){
		if(tipofactura == 2){  //factura B
			TOTALdes_rec= subtotalbruto_B * Descuento;
			subtotalbruto_B=subtotalbruto_B - TOTALdes_rec;
			
			var importe_des= $.number( TOTALdes_rec, 2 );
			$("#descuento_recargo_importe").text("-"+importe_des);
			
		} else {
		// para el caso de una factura A
		TOTALdes_rec=subtotalbruto * Descuento;

		var importe_des= $.number( TOTALdes_rec, 2 );
		$("#descuento_recargo_importe").text("-"+importe_des);
		subtotalbruto=subtotalbruto - TOTALdes_rec;
		}
	} 
	if(Recargo != 1){
		if(tipofactura == 2){  //factura B
			TOTALdes_rec= subtotalbruto_B * Recargo;

			subtotalbruto_B=subtotalbruto_B + TOTALdes_rec;
			
			var rec_impote= $.number(TOTALdes_rec, 2 ); 
			$("#descuento_recargo_importe").text(rec_impote);
		} else { 
		// para el caso de una factura A
		TOTALdes_rec= subtotalbruto * Recargo;
		subtotalbruto=subtotalbruto + TOTALdes_rec;
		var rec_impote= $.number(TOTALdes_rec, 2 ); 
		$("#descuento_recargo_importe").text(rec_impote);
	}
	}
	
//----------------------IMPUESTO INTERNO-RELACIONADO A LA ACTIVIDAD-------------------------
//console.log("checkimpint="+checkiibb+" coficienteimpint="+coficienteiibb);
	var TOTALimpint=0;
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

		$("#total-impint").text(importeint);
		$("#Factura_impuestointerno").show();
		$("#descripcionimpint").show();
		$("#Factura_importeImpInt").val(TOTALimpint);

	}
	console.log(TOTALimpint);
	//-----------------------IVA----------------------------
	if(tipofactura == 1){
		subtotalbruto=subtotalbruto;
		TOTALiva= subtotalbruto * cofIVA;
	} else {
		subtotalbruto_B= subtotalbruto_B ;
		//subtotalbruto_B_con_iva= netogravado * IVA;
	}
	//console.log(subtotalbruto_B);
	//----------------CALCULO TOTALNETO--------------------
		if(tipofactura == 2){  //factura B
			
			SUBtotal=subtotalbruto_B;
			TOTALiva=subtotalbruto_B - (subtotalbruto_B / IVA);
			TOTALNETO=subtotalbruto_B + TOTALimpint;
		} else {
		 SUBtotal=subtotalbruto;
		 TOTALNETO=subtotalbruto+TOTALiva+TOTALimpint ;
	}
		 
//----------------------IIBB---------------------------
	//console.log("checkiibb="+checkiibb+" coficienteiibb="+coficienteiibb);
	var TOTALiibb=0;
	
	if((checkiibb == 1) && (!isNaN(coficienteiibb)))
	{
		coficienteiibb= coficienteiibb/100;
		$("#Factura_retencionIIBB").show();
	}

//----------------------Perc. IVA--------------------------
	//console.log("checkiibb="+checkiibb+" coficienteiibb="+coficienteiibb);
	var TOTALperciva=0;
	
	if((checkperciva == 1) && (!isNaN(coficienteperciva)))
	{
		coficienteperciva= coficienteperciva/100;
		$("#Factura_percepcion_iva").show();
	}
	
//------------------FINAL--------------------------
	//$("#Factura_importe").val(totalneto.toFixed(2));
	//$("#Factura_subtotal").val(total.toFixed(2));
	
	if(!isNaN(coficienteiibb)){
	
		if(tipofactura == 2){
			TOTALiibb=SUBtotal * coficienteiibb;
			TOTALNETO=TOTALNETO + TOTALiibb;
		} else {
			TOTALiibb=coficienteiibb * SUBtotal;
			TOTALNETO=TOTALNETO + TOTALiibb;
		}
		var importeiibb=$.number(TOTALiibb, 2);
		$("#total-iibb").text(importeiibb);
		$("#Factura_importeIIBB").val(TOTALiibb);
	} 
	if(!isNaN(coficienteperciva)){
	
		if(tipofactura == 2){
			TOTALperciva=SUBtotal * coficienteperciva;
			TOTALNETO=TOTALNETO + TOTALperciva;
		} else {
			TOTALperciva=coficienteperciva * SUBtotal;
			TOTALNETO=TOTALNETO + TOTALperciva;
		}
		var importeperciva=$.number(TOTALperciva, 2);
		$("#total-perciva").text(importeperciva);
		$("#Factura_importe_per_iva").val(TOTALperciva);
	} 
	
	totaltransfor= $.number( SUBtotal, 2 ); 
	totalnetotransfor = $.number( TOTALNETO, 2 );
	
	$("#subtotalblock").text(totaltransfor);
	
	$("#Factura_importebruto").val(SUBtotal.toFixed(2));// subtotal

	$("#totalnetoblock").text(totalnetotransfor);
	$("#Factura_importeneto").val(TOTALNETO.toFixed(2)); // total d la factura
	$("#Factura_netogravado").val(netogravado.toFixed(2)); //neto gravado sin impuesto
	totalIvaTrasfor = $.number(TOTALiva, 2);
	if(tipofactura == 1){
		$("#ivablock").text(totalIvaTrasfor);
		$("#totalivadiv").show();
	} else {
		$("#totalivadiv").css('display','none');
	}
		
		if(TOTALiva == 0){
			$("#Factura_ivatotal").val(null);
		} else {
			
			$("#Factura_ivatotal").val(TOTALiva.toFixed(2));
			
			
		}

	if(TOTALimpint == 0){
		$("#Factura_impuestointerno").val(null);
	} else {
		$("#Factura_importeImpInt").val(TOTALimpint.toFixed(2));
	}
	if(TOTALiibb == 0){
		$("#Factura_importeIIBB").val(null);
	} else {
	$("#Factura_importeIIBB").val(TOTALiibb.toFixed(2));
	}
	if(TOTALperciva == 0){
		$("#Factura_importe_per_iva").val(null);
	} else {
	$("#Factura_importe_per_iva").val(TOTALperciva.toFixed(2));
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
function codigo(obj){ 
var id_input=obj.id;
		
	var codprod=obj.val;
	//console.log(codprod);
	$.ajax({ 
		  type: "POST",
		  url: "/proconsele/factura/envio",
		  data: {data:codprod},
		  success: function (data){
			  
			  	var cantidad=$('#Factura_cantidadproducto').val();
				
				if(cantidad == ""){
				alert("Debe ingresar una cantidad");
				return false;
			} 
				
			  var cantidad=parseFloat(cantidad);
			  var precio= parseFloat(data.precio);
			  	  
			  $('#Factura_nombreproducto').val(data.nombre+" (x "+data.venta+")");
			  
			  
			  var tipofactura=$('#Factura_tipofactura').val();
			  var cofiva=parseFloat($('#Factura_iva').val());
			  if(tipofactura == 2){
			  		precio=precio * cofiva;
					var subtotal= cantidad * precio;
					$('#Factura_precioproducto').val(precio.toFixed(2));
					
				} else if(tipofactura == 1){
					var subtotal=cantidad * precio;
					$('#Factura_precioproducto').val(data.precio);
				}

			 $('#Factura_stbruto_producto').val(subtotal.toFixed(2));
			  	sumatotal();
			    botonsubmit();
			  },
			error: function(data){
					alert("Ingrese un código valido.");
					$("#Factura_cantidadproducto").val(null);
					$("#Factura_nombreproducto").val(null);
					$("#Factura_precioproducto").val(null);
					$("#Factura_stbruto_producto").val(null);
					$("#Factura_cantidadproducto").select();
					$("#total-iibb").text("");
					$("#total-impint").text("");
					$("#totalnetoblock").text("");
					$("#ivablock").text("");
					$("#subtotalblock").text("");
					return false;
			  },
		  dataType: "json"
		  });
	botonsubmit();
}

function blurcantidad(obj){
	var id_input=obj.id;
	//var idinputcodigo= viewid(3,3,id_input,2);
	var c=$('#Factura_producto_idproducto').val();
	if( c != ""){
		
		sumatotal();
		}
}

function sumaSubtotal(obj){
	$('#Factura_precioproducto').removeAttr('readonly');
	var id_input=obj.id;
	var codigo=$('#Factura_producto_idproducto').val();
	var cantidad=$('#Factura_cantidadproducto').val();
	
	if((cantidad == "") || (codigo == "")){
			alert("Debe ingresar un producto");
			return false;
			} 
	var cantidad=parseFloat(cantidad);
	var precio=parseFloat($('#Factura_precioproducto').val());
					
	var subtotal= cantidad * precio;
	$("#Factura_precioproducto").val(precio.toFixed(2));

	$('#Factura_stbruto_producto').val(subtotal.toFixed(2));
	$('#Factura_precioproducto').attr('readonly','true');
}

function botonsubmit(){
	var td=$("#Factura_stbruto_producto").val();
	
	//var columnas=$("table.table.mmf_table > tbody > tr").size();
	
	if(td == "") {
		//alert("style:"+tr+"---columnas: "+columnas);
		$("#boton-submit").attr("disabled","disabled");
		//$("#boton-submit").removeAttr("disabled"); }
	 }else {
		//$("#boton-submit").attr("disabled","disabled");
		$("#boton-submit").removeAttr("disabled");
	}
	
}

function resetValores(){
	$("#Factura_cantidadproducto").val(null);
	$("#Factura_producto_idproducto").val(null);
	$("#Factura_nombreproducto").val("");
	$("#Factura_stbruto_producto").val('0.00');
	$("#Factura_precioproducto").val(null);

	$("#Factura_iibb").removeAttr('checked');
 	$("#Factura_retencionIIBB").css('display','none');
    $("#Factura_retencionIIBB").val("");
    $("#totaldiv-iibb").css('display','none');

    $("#Factura_perciva").removeAttr('checked');
 	$("#Factura_percepcion_iva").css('display','none');
    $("#Factura_importe_per_iva").val("");
    $("#totaldiv-perciva").css('display','none');
	
	$("#Factura_impInt").removeAttr('checked');
    $("#Factura_impuestointerno").css('display','none');
    $("#Factura_impuestointerno").val("");
    $("#Factura_importeImpInt").val("");

    $("#descripcionimpint").css('display','none');
    $("#totaldiv-impint").css('display','none');
    $("#Factura_desc_imp_interno").val(null);
	 $("#Factura_desRec").removeAttr('checked');
	 $("#radiobutton-descRec").css('display','none');
	 $("#Factura_descrecar").val(null);
	 $("#Factura_tipodescrecar_0").attr('checked',false);
	 $("#Factura_tipodescrecar_1").attr('checked',false);
	 $("#Factura_descrecar").parent().find("span").remove();
	 $("#desc_recar").css('display','none');

}