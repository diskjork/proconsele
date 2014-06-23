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
sumatotal();
botonsubmit();
$("#Factura_desRec").click(function() {  
        if($("#Factura_desRec").is(':checked')) {  
          $("#radiobutton-descRec").show();
          //$("#totaldiv-iibb").show();
          $("#Factura_descrecar").val("");
          //$("#total-iibb").text("");
          $("#Factura_descrecar").parent().append("<span> %</span>");
          sumatotal();
        } else {  
            $("#radiobutton-descRec").css('display','none');

            //$("#totaldiv-iibb").css('display','none');

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
          $("#Factura_impuestointerno").parent().append("<span> %</span>");
          sumatotal();
        } else {  
            $("#Factura_impuestointerno").css('display','none');

            $("#totaldiv-impint").css('display','none');

            $("#Factura_impuestointerno").parent().find("span").remove();
            sumatotal();
        }  
    });   
});

function sumatotal(){
	
	
	var subtotalpro=parseFloat($("#Factura_stbruto_producto").val());
	var checkdescRec=$("input[name='Factura[desRec]']:checked", "#factura-form").val();
	var checkiibb=$("input[name='Factura[iibb]']:checked", "#factura-form").val();

	var coficienteiibb=parseFloat($("#Factura_retencionIIBB").val());
	var checkimpint=$("input[name='Factura[impInt]']:checked", "#factura-form").val();
	var coficienteimpint=parseFloat($("#Factura_impuestointerno").val());
	var e=$("#Factura_iva").val();
	var ei=parseFloat(e);
	var cofIVA=ei - 1;
//	var subtotalbruto=subtotalpro*ei;
	var subtotalbruto=subtotalpro;
	
//----------------descuento-Recargo--------------
	var descRecar=1;
	var deReBloc=parseFloat($("#Factura_descrecar").val());
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
			descRecar=descRecar/100;
			var tem= 1 - descRecar;
			var desc = subtotalbruto * descRecar;			
			subtotalbruto= subtotalbruto * tem;
			
			
			
			var desc_impor= $.number( desc, 2 ); 
			$("#descuento_recargo_importe").text(desc_impor);
			$("#descuento_recargo").text("Descuento");
			$("#desc_recar").show();
			//totalneto=totalneto * descRecar;
			}
		if(e == 1){ //recargo
			var deReBloc=$("#Factura_descrecar").val();
			descRecar=parseFloat(deReBloc);
			descRecar=descRecar/100;
			var tem=descRecar + 1;
			var recar= subtotalbruto * descRecar;
			subtotalbruto=subtotalbruto * tem;
			
			var rec_impote= $.number(recar, 2 ); 
			$("#descuento_recargo_importe").text(rec_impote);
			$("#descuento_recargo").text("Recargo");
			$("#desc_recar").show();
			
		}

	} else	{
		$("#desc_recar").css("display","none");
		//$("input[name='Factura[tipodescrecar]']:unchecked", "#factura-form");

		}

//---------------------------------------------------
	var totalneto=subtotalbruto * ei;
	var totaliva=subtotalbruto * cofIVA;
	
//----------------------IIBB---------------------------
//console.log("checkiibb="+checkiibb+" coficienteiibb="+coficienteiibb);
	if((checkiibb == 1) && (!isNaN(coficienteiibb)))
	{
		coficienteiibb= coficienteiibb/100;
		var temCoif= coficienteiibb + 1;
		importeRetenIIBB=coficienteiibb * totalneto;
		totalneto=totalneto * temCoif;
		
		importeRetenIIBB=$.number(importeRetenIIBB, 2);
		$("#total-iibb").text(importeRetenIIBB);

	}
//----------------------IMPUESTO INTERNO---------------------------
console.log("checkimpint="+checkiibb+" coficienteimpint="+coficienteiibb);
	if((checkimpint == 1) && (!isNaN(coficienteimpint)))
	{
		coficienteimpint= coficienteimpint/100;
		var temCofimpint= coficienteimpint + 1;
		importeIMPINT=coficienteimpint * totalneto;
		totalneto=totalneto * temCofimpint;
		
		importeIMPINT=$.number(importeIMPINT, 2);
		$("#total-impint").text(importeIMPINT);

	}
	
//--------------------------------------------
	//$("#Factura_importe").val(totalneto.toFixed(2));
	//$("#Factura_subtotal").val(total.toFixed(2));
	totaltransfor= $.number( subtotalbruto, 2 ); 
	totalnetotransfor = $.number( totalneto, 2 );
	totalIvaTrasfor = $.number(totaliva, 2);
	$("#subtotalblock").text(totaltransfor);
	$("#totalnetoblock").text(totalnetotransfor);
	$("#ivablock").text(totalIvaTrasfor);

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
	console.log(codprod);
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