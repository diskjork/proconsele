<?php
/* @var $this ChequeController */
/* @var $model Cheque */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'acreditarbanco-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>true,
	//'enableAjaxValidation'=>true,
	//'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
    'htmlOptions'=>array(
                               'onsubmit'=>"return false;",
                               'onkeypress'=>" if(event.keyCode == 13){ send(); } "
                             ),
)); ?>
    <?php echo $form->errorSummary($modelBanco); ?>
    
	<div class="container-fluid">
    	<div class="row-fluid">
	    	<div class="well">
  			<?php echo "<strong>Banco: </strong>".$model->bancoIdBanco."<br>";?>	
    		<?php echo "<strong>Cheque Nro.: </strong>".$model->nrocheque."<br>";?>
    		<?php echo "<strong>Titular: </strong>".$model->titular."<br>";?>
            <?php //echo $form->textFieldControlGroup($model,'concepto',array('span'=>5,'maxlength'=>45,'disabled'=>true)); ?>
			<?php echo "<strong>Fecha de Recepción: </strong>".$model->fechaingreso."<br>";?>
			<?php echo "<strong>Fecha de Cobro: </strong>".$model->fechacobro."<br>";?>
			<?php echo "<strong>Relacionado a la Entidad: </strong>".$model->clienteIdcliente."<br>";?>
			</div>
			<!-- Definici�n de los valores para el nuevo movimiento de banco -->
			<?php echo $form->hiddenField($modelBanco,'descripcion', array('value'=>'Cobro de cheque -'.$model->clienteIdcliente)); ?>
			<?php echo $form->hiddenField($modelBanco,'debeohaber', array('value'=>0)); ?>
			<?php echo $form->hiddenField($modelBanco,'debe', array('value'=>$model->debe)); ?>
			<?php echo $form->hiddenField($modelBanco,'cheque_idcheque', array('value'=>$model->idcheque)); ?>
			<?php echo $form->hiddenField($modelBanco, 'fechacobro',array('value'=>$model->fechacobro));?>
			<?php echo $form->hiddenField($modelBanco, 'cuenta_idcuenta',array('value'=>5));?>
			
			<!--  Cambio de estado del cheque -->
			<?php echo $form->hiddenField($model,'estado', array('value'=>'5')); ?>
			<?php echo $form->hiddenField($model,'importe',array('value'=>$model->debe)); ?>
			
			<div>
			<h5>Cuenta Bancaria en que se deposita: </h5>
			</div>
			
           <div>
			
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$modelBanco,
				 'attribute'=>'ctabancaria_idctabancaria',
				  'data' => GxHtml::listDataEx(Ctabancaria::model()->findAllAttributes(array('nombre'),true,array('condition'=>'estado=1','order'=>'nombre ASC')),'idctabancaria','nombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una Cta. Bancaria',
					   'allowClear'=>true,
						'width'=> '60%',
					  ),
				)); ?>
				
		</div><br>
			
			<p><b>Importe</b></p>
            <div class="input-prepend">
            
				<span class="add-on">$</span>
				<?php $this->widget('yiiwheels.widgets.maskmoney.WhMaskMoney', array(
				'model'=>$model,
				'attribute' => 'debe',
				'htmlOptions'=>array('disabled' => true)
				));?>
				</div>
			<br>
			<div>	
			<?php $this->widget('bootstrap.widgets.TbAlert'); ?>	
			</div>
			<?php  echo "<strong>Fecha de Depósito:</strong>"?>
            <div class="input-append">
            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
        		'model' => $modelBanco,
            	'attribute' => 'fecha',
            	'pluginOptions' => array(
         				'format' => 'dd/mm/yyyy',
         				//'width' => '30',
            			)
  			  ));
			
  			  ?>
			
		 <span class="add-on"><icon class="icon-calendar"></icon></span>
			</div>
			<div id="error-div-Banco" class="alert alert-block alert-error" style="display:none;">
   			</div>
		</div>
	</div>
	
        <div class="form-actions" align="center">
        
        <?php echo TbHtml::submitButton('Depositar',array('onclick'=>'send();',
        			 'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        			 'confirm'=>'Está seguro que desea guardar los datos?')); ?>
			
            <?php 
			if(!$model->isNewRecord){
				echo CHtml::link('Volver', Yii::app()->request->baseUrl.'/cheque/recibido',array ('class'=>'btn btn-primary'));
				//echo TbHtml::button('Primary',Yii::app()->request->baseUrl.'/movimientobanco/admin', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
			}?>
    </div>
	
    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">


function send()
{

  var data=$("#acreditarbanco-form").serialize();


 $.ajax({
  type: 'POST',
   
  data: data,
  success:	function(data){
     var obj = $.parseJSON(data);
     if(obj.check=="success"){
         window.location = "<?php echo Yii::app()->createUrl("cheque/recibido"); ?>"; 
     }
     if(obj.Movimientobanco_ctabancaria_idctabancaria == "Cta. bancaria no puede ser nulo."){
			$("#error-div-Banco").show();
			$("#error-div-Banco").html("<strong>Cuenta Bancaria</strong> no puede ser nulo.");
   }
   if(obj.Movimientobanco_fecha == "Fecha no puede ser nulo."){
			$("#error-div-Banco").show();
			$("#error-div-Banco").append("<br><strong>Fecha de cobro</strong> no puede ser nulo.");
   }	
   
   if(obj.Movimientobanco_fechacobro == "La fecha ingresada debe ser mayor a la fecha de cobro"){
			$("#error-div-Banco").show();
			$("#error-div-Banco").append("<br>La <strong>fecha ingresada</strong> debe ser mayor a la fecha de cobro");
	 }
   }
 });
}
 
</script>