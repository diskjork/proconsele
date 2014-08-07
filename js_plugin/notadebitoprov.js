$(document).on('ready',function(){
$("input").keypress(function (evt) {
  var charCode = evt.charCode || evt.keyCode;
  if (charCode  == 13) { 
  return false;
    }
  });
  
$("#boton-submit").attr("disabled","disabled");
$("#Notadebitoprov_nrodefactura").keydown(function(event){
	solonumeromod(event);});
$("#Notadebitoprov_importeneto").keydown(function(event){
		solonumeromod(event);});
$("#Notadebitoprov_importeneto")
.popover({ 
            placement:'left'  ,
            title: 'Importe Nota débito', content: "Ingrese el total de la nota de débito" })
            .popover('show');
sumatotal();
//botonsubmit();


$("#Notadebitoprov_iva").on('change',function() {  
       var value = $('option:selected', this).attr('value');
      if(value == 1){
        $("#Notadebitoprov_ivatotal").attr('readonly',true);
      } else {
        $("#Notadebitoprov_ivatotal").removeAttr('readonly');
      }
});


 
});

function botonsubmit(){
 
  if($("#Notadebitoprov_importeneto").val() == "") {
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
  var totaliva=parseFloat($("#Notadebitoprov_ivatotal").val());
  totalIvaTrasfor = $.number(totaliva, 2);
   $("#ivablock").text(totalIvaTrasfor);
}
function sumatotal(){

  var totaliva=parseFloat($("#Notadebitoprov_iva").val());
  var totalneto=parseFloat($("#Notadebitoprov_importeneto").val());
  var subtotal=totalneto/totaliva;
      totaliva=totalneto-subtotal;

  
  
  totalnetotransfor = $.number( totalneto, 2 );
  totalIvaTrasfor = $.number(totaliva, 2);
  SubtotalTrasfor = $.number(subtotal, 2);
  $("#Notadebitoprov_ivatotal").val(totaliva.toFixed(2));
  $("#Notadebitoprov_importebruto").val(subtotal.toFixed(2));
  $("#totalnetoblock").text(totalnetotransfor);
  $("#subtotalblock").text(SubtotalTrasfor);
  $("#ivablock").text(totalIvaTrasfor);
  botonsubmit();
  }