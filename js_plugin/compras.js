$(document).on('ready',function(){
  // para bloquear la tecla enter   
$("input").keypress(function (evt) {
  var charCode = evt.charCode || evt.keyCode;
  if (charCode  == 13) { 
  return false;
    }
  });
$("#boton-submit").attr("disabled","disabled");
//$("#Compras_descrecar").parent().append("<span> %</span>");
//$("#Compras_importeIIBB").attr('readonly','true');
 

$("#Compras_nrodefactura").keydown(function(event){
	solonumeromod(event);});
$("#Compras_importeIIBB").keydown(function(event){
	solonumeromod(event);});
$("#Compras_ivatotal").keydown(function(event){
		solonumeromod(event);});
$("#Compras_importeneto").keydown(function(event){
		solonumeromod(event);});
$("#Compras_importebruto").keydown(function(event){
    solonumeromod(event);});
$("#Compras_descuento").keydown(function(event){
    solonumeromod(event);});
$("#Compras_interes").keydown(function(event){
    solonumeromod(event);});
$("#Compras_importe_per_iva").keydown(function(event){
    solonumeromod(event);});
$("#Compras_impuestointerno").keydown(function(event){
    solonumeromod(event);});
sumatotal();
//botonsubmit();
if($("#Compras_tipofactura").val() == 3){
  $(".facturaA").css('display', 'none');
  $("#facturac").show();
  $("#block-totaliva").css('display', 'none');
}
$("#Compras_tipofactura").change(function(event){
    var value = $('option:selected', this).attr('value');
    resetInput();
    if(value == 3){
      $(".facturaA").css('display', 'none');
      $("#facturac").show();
      $("#block-totaliva").css('display', 'none');
    }else {
      $(".facturaA").show();
      $("#facturac").css('display', 'none');
      $("#block-totaliva").show();
      $("#ivablock").text("");
    }
});
$("#Compras_importeIIBB").attr('readonly','true');
$("#Compras_importe_per_iva").attr('readonly','true');
$("#Compras_impuestointerno").attr('readonly','true');
$("#Compras_descuento").attr('readonly','true');
$("#Compras_interes").attr('readonly','true');
$("#blockiibb").css('display','none');
$("#Compras_desc").click(function() { 
        
        if($("#Compras_desc").is(':checked')) {  
          $("#Compras_descuento").removeAttr('readonly');
           
        } else {  
            $("#Compras_descuento").attr('readonly', 'true');
            $("#Compras_descuento").val("");
            
        }  
        sumatotal(); 
    });
$("#Compras_inte").click(function() {  
      
        if($("#Compras_inte").is(':checked')) {  
          $("#Compras_interes").removeAttr('readonly');
           
        } else {  
            $("#Compras_interes").attr('readonly', 'true');
            $("#Compras_interes").val("");
            
        } 
        sumatotal();  
    });
$("#Compras_iibb").click(function() { 
       
        if($("#Compras_iibb").is(':checked')) {  
          $("#Compras_importeIIBB").removeAttr('readonly');
          $("#blockiibb").show();
        } else {  
            $("#Compras_importeIIBB").attr('readonly', 'true');
            $("#Compras_importeIIBB").val("");
            $("#blockiibb").css('display','none');
            $("#totaiibbblock").text("");
        }
        sumatotal();   
    });   
$("#Compras_perciva").click(function() { 
        
        if($("#Compras_perciva").is(':checked')) {  
          $("#Compras_importe_per_iva").removeAttr('readonly');
          $("#blockperciva").show();
        } else {  
            $("#Compras_importe_per_iva").attr('readonly', 'true');
            $("#Compras_importe_per_iva").val("");
            $("#blockperciva").css('display','none');
            $("#totalperciva").text("");
        } 
        sumatotal();  
    });   
$("#Compras_impint").click(function() { 
        
        if($("#Compras_impint").is(':checked')) {  
          $("#Compras_impuestointerno").removeAttr('readonly');
          $("#blockpercimpinter").show();
        } else {  
            $("#Compras_impuestointerno").attr('readonly', 'true');
            $("#Compras_impuestointerno").val("");
            $("#blockpercimpinter").css('display','none');
             $("#totalpercimpinter").text("");
        } 
        sumatotal();  
    });      
$("#Compras_iva").on('change',function() {  
      sumatotal(); 
});
var valor=$('option:selected', '#Compras_tipofactura').attr('value');
if( valor == 3){
      $("#Compras_ivatotal").val("");
      $("#Compras_ivatotal").attr('readonly',true);
}

 
});

function botonsubmit(){
 
  if($("#Compras_importeneto").val() == "") {
    //alert("style:"+tr+"---columnas: "+columnas);
    $("#boton-submit").attr("disabled","disabled");
    //$("#boton-submit").removeAttr("disabled"); }
   }else {
    //$("#boton-submit").attr("disabled","disabled");
    $("#boton-submit").removeAttr("disabled");
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
function blockiva(){
  var totaliva=parseFloat($("#Compras_ivatotal").val());
  totalIvaTrasfor = $.number(totaliva, 2);
   $("#ivablock").text(totalIvaTrasfor);
}
function sumatotal(){
  
  var totalpercepcionIIBB=$("#Compras_importeIIBB").val();
  if(totalpercepcionIIBB == ""){
    totalpercepcionIIBB=0;
  } else {
    totalpercepcionIIBB=parseFloat(totalpercepcionIIBB);
  }
  var totalpercepcion_iva=$("#Compras_importe_per_iva").val();
  if(totalpercepcion_iva == ""){
    totalpercepcion_iva=0;
  }else {
    totalpercepcion_iva=parseFloat(totalpercepcion_iva);
  }
  var descuento=$("#Compras_descuento").val();
  if(descuento == ""){
    descuento=0;
  }else {
    descuento=parseFloat(descuento);
  }
  var interes=$("#Compras_interes").val();
  if(interes == ""){
    interes=0;
  }else {
    interes=parseFloat(interes);
  }
  var impinter=$("#Compras_impuestointerno").val();
  if(impinter == ""){
    impinter=0;
  }else {
    impinter=parseFloat(impinter);
  }
  //var totaliva=parseFloat($("#Compras_ivatotal").val());
  //precio neto gravado
  var netogravado=parseFloat($("#Compras_importebruto").val());
  var cofiva=parseFloat($("#Compras_iva").val());
  var seleccion=$('option:selected', "#Compras_tipofactura").attr('value');
  /*if((seleccion == 1) && (isNaN(totaliva)) && (!isNaN(netogravado))){
    alert('Complete "Importe IVA" No puede ser nulo ');
     $("#Compras_importebruto").val("");
  }*/
if(seleccion == 1){
    if(isNaN(netogravado)){
      $("#Compras_ivatotal").val("");
      totaliva=0;
    }else {
      if((descuento == 0) && (interes == 0) ){
        totaliva=netogravado * (cofiva - 1);
        $("#Compras_ivatotal").val(totaliva.toFixed(2));
         totalIvaTrasfor = $.number(totaliva, 2);
        $("#ivablock").text(totalIvaTrasfor);
      } else  {
        
        netogravado=netogravado - descuento + interes ;
        totaliva=netogravado * (cofiva - 1);
        $("#Compras_ivatotal").val(totaliva.toFixed(2));
         totalIvaTrasfor = $.number(totaliva, 2);
        $("#ivablock").text(totalIvaTrasfor);
      }
  }
  precioTOTAL=netogravado + totaliva + totalpercepcionIIBB + totalpercepcion_iva + impinter;
  if(totalpercepcionIIBB != ""){
    totalpercepcionIIBB=totalpercepcionIIBB.toFixed(2);
    $("#totaiibbblock").text($.number(totalpercepcionIIBB,2));
  }
  if(totalpercepcion_iva != ""){
    totalpercepcion_iva=totalpercepcion_iva.toFixed(2);
    $("#totalperciva").text($.number(totalpercepcion_iva,2));
  }
  if(impinter != ""){
    impinter=impinter.toFixed(2);
    $("#totalpercimpinter").text($.number(impinter,2));
  }
  if(!isNaN(precioTOTAL)){
     $("#totalnetoblock").text(precioTOTAL.toFixed(2));
  }
  $("#Compras_importeneto").val(precioTOTAL.toFixed(2));
} else {
  preciototal=parseFloat($("#Compras_importeneto").val());
  $("#Compras_importeneto").val(preciototal.toFixed(2));
     $("#totalnetoblock").text(preciototal.toFixed(2));

}
  botonsubmit();
}
function resetInput(){
  $("#Compras_importebruto").val(null);
  $("#Compras_ivatotal").val(null);
  $("#Compras_importe_per_iva").val(null);
  $("#Compras_importeIIBB").val(null);
  $("#Compras_descuento").val(null);
  $("#Compras_interes").val(null);
  $("#Compras_importeneto").val(null);
}