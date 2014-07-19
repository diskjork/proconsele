$(document).on('ready',function(){
$("#boton-submit").attr("disabled","disabled");
//$("#Factura_descrecar").parent().append("<span> %</span>");
$("#Factura_retencionIIBB").css('display','none');
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
$("#Factura_precioproducto").keydown(function(event){
		solonumeromod(event);});
$("#Factura_impuestointerno").keydown(function(event){
		solonumeromod(event);});
$("#Factura_descrecar").keydown(function(event){
		solonumeromod(event);});
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
	
	
	var subtotalbruto=parseFloat($("#Factura_stbruto_producto").val());
	var checkdescRec=$("input[name='Factura[desRec]']:checked", "#factura-form").val();
	var checkiibb=$("input[name='Factura[iibb]']:checked", "#factura-form").val();

	var coficienteiibb=parseFloat($("#Factura_retencionIIBB").val());
	var checkimpint=$("input[name='Factura[impInt]']:checked", "#factura-form").val();
	var coficienteimpint=parseFloat($("#Factura_impuestointerno").val());
	var e=$("#Factura_iva").val();
	var ei=parseFloat(e); //coeficiente iva por ej: 1,21 o 1,105
	var cofIVA=ei - 1;
	var descRecar=1;
	var deReBloc=parseFloat($("#Factura_descrecar").val());
	var SUBtotal;
	var TOTALNETO=0.00;
	var TOTALimpint=0;
	
	var TOTALiva=0;
	var TOTALdes_rec=0;
//-----------------------IVA----------------------------
	TOTALiva=subtotalbruto * cofIVA;
	//TOTALiva=TOTALiva.toFixed(2);
	
//----------------------IMPUESTO INTERNO---------------------------
//console.log("checkimpint="+checkiibb+" coficienteimpint="+coficienteiibb);
	
	if((checkimpint == 1) && (!isNaN(coficienteimpint)))
	{
		coficienteimpint= coficienteimpint/100;
		TOTALimpint=coficienteimpint * subtotalbruto;

		var impint=TOTALimpint.toFixed(2);
		var importeint=$.number(impint, 2);

		$("#total-impint").text(importeint);
		$("#Factura_impuestointerno").show();
		$("#descripcionimpint").show();
		$("#Factura_importeImpInt").val(TOTALimpint);

	}
	//----------------CALCULO TOTALNETO--------------------

		 TOTALNETO=subtotalbruto+TOTALiva+TOTALimpint;
		 SUBtotal=subtotalbruto;
		 console.log("suma: "+coficienteiibb);
		//SUBtotal=TOTALNETO;

	//----------------------IIBB---------------------------
	//console.log("checkiibb="+checkiibb+" coficienteiibb="+coficienteiibb);
	var TOTALiibb=0;
	
	if((checkiibb == 1) && (!isNaN(coficienteiibb)))
	{
		coficienteiibb= coficienteiibb/100;
		
		

	}
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
			//if( deReBloc == "")$("#desc_recar").css("display","none"); 
			descRecar=parseFloat(deReBloc);
			Descuento=descRecar/100;
						
			$("#descuento_recargo").text("Descuento");
			$("#desc_recar").show();
			//totalneto=totalneto * descRecar;
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
		//$("input[name='Factura[tipodescrecar]']:unchecked", "#factura-form");

		}
//------------------FINAL--------------------------
	//$("#Factura_importe").val(totalneto.toFixed(2));
	//$("#Factura_subtotal").val(total.toFixed(2));
	if(Descuento != 1){

		TOTALdes_rec=TOTALNETO * Descuento;
		var importe_des= $.number( TOTALdes_rec, 2 );
		$("#descuento_recargo_importe").text("-"+importe_des);
		TOTALNETO=TOTALNETO - TOTALdes_rec;
	} 
	if(Recargo != 1){
		TOTALdes_rec= TOTALNETO * Recargo;
		TOTALNETO=TOTALNETO + TOTALdes_rec;
		var rec_impote= $.number(TOTALdes_rec, 2 ); 
		$("#descuento_recargo_importe").text(rec_impote);
	}

	if(!isNaN(coficienteiibb)){
		TOTALiibb=coficienteiibb * TOTALNETO;
		SUBtotal=TOTALNETO;
		TOTALNETO=TOTALNETO + TOTALiibb;
		var importeiibb=$.number(TOTALiibb, 2);
		$("#total-iibb").text(importeiibb);

		$("#Factura_importeIIBB").val(TOTALiibb);
	} 
	totaltransfor= $.number( SUBtotal, 2 ); 
	totalnetotransfor = $.number( TOTALNETO, 2 );
	totalIvaTrasfor = $.number(TOTALiva, 2);

	

	$("#subtotalblock").text(totaltransfor);
	$("#Factura_importebruto").val(SUBtotal.toFixed(2));
	$("#totalnetoblock").text(totalnetotransfor);
	$("#Factura_importeneto").val(TOTALNETO.toFixed(2));
	$("#ivablock").text(totalIvaTrasfor);
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
			  var subtotal=cantidad * precio;
			  //alert(id_nombre_precio);
			  $('#Factura_nombreproducto').val(data.nombre+" (x "+data.venta+")");
			  $('#Factura_precioproducto').val(data.precio);
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
		sumaSubtotal(obj);
		sumatotal();
		}
}

function sumaSubtotal(obj){
	
	var id_input=obj.id;
	//var n = id_input.search("cantidad"); //para saber si lo ejecuta el input cantidad o el de precio
	//alert(n);
	
	var codigo=$('#Factura_producto_idproducto').val();
	var cantidad=$('#Factura_cantidadproducto').val();
	
		if((cantidad == "") || (codigo == "")){
			alert("Debe ingresar un producto");
			return false;
			} 
	var cantidad=parseFloat(cantidad);
	var precio=parseFloat($('#Factura_precioproducto').val());
	
	var subtotal=cantidad * precio;
	$('#Factura_stbruto_producto').val(subtotal.toFixed(2));
	
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