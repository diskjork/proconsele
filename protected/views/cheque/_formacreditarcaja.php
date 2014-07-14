<?php
/* @var $this ChequeController */
/* @var $model Cheque */
/* @var $modelCaja Movimientocaja */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'acreditarcaja-form',
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
    <?php echo $form->errorSummary($modelCaja); ?>
     
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
			<!-- Definici�n de los valores para el nuevo movimiento de caja -->
			<?php echo $form->hiddenField($modelCaja,'descripcion', array('value'=>'Cobro de cheque- N°'.$model->nrocheque." de: ".$model->clienteIdcliente)); ?>
			<?php echo $form->hiddenField($modelCaja,'debeohaber', array('value'=>$model->debeohaber)); ?>
			<?php echo $form->hiddenField($modelCaja,'debe', array('value'=>$model->debe)); ?>
			
			<div>
			<h5>Caja : </h5>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$modelCaja,
				 'attribute'=>'caja_idcaja',
				  'data' => GxHtml::listDataEx(Caja::model()->findAllAttributes(array('nombre'),true,array('condition'=>'estado=1','order'=>'nombre ASC')),'idcaja','nombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una caja',
					   'allowClear'=>true,
						'width'=> '60%',
					  ),
				)); ?>
				<?php  echo $form->error($modelCaja,'caja_idcaja',array('style'=>'background-color: rgb(253, 147, 147);color: #090808;')); ?>
		</div><br>
			<?php echo $form->hiddenField($modelCaja,'fechacobro', array('value'=>$model->fechacobro)); ?>
			<?php echo $form->hiddenField($modelCaja,'cuenta_idcuenta', array('value'=>5)); ?>
			
			<!--  Cambio de estado del cheque -->
			<?php echo $form->hiddenField($model,'estado', array('value'=>'3')); ?>
			<?php echo $form->hiddenField($model,'importe',array('value'=>$model->debe)); ?>
			<div>
			
			</div>
			
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
			<?php  echo "<strong>Fecha de Cobro:</strong>"?>
            <div class="input-append">
            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
        		'model' => $modelCaja,
            	'attribute' => 'fecha',
            	'pluginOptions' => array(
         				'format' => 'dd/mm/yyyy',
         				//'width' => '30',
            			)
  			  ));
			
  			  ?>
			
		 <span class="add-on"><icon class="icon-calendar"></icon></span>
			</div>
			<div id="error-div" class="alert alert-block alert-error" style="display:none;">
   			</div> 
		</div>
	</div>
	
        <div class="form-actions" align="center">
        
        <?php echo TbHtml::submitButton('Acreditar',array('onclick'=>'send();',
        			'color'=>TbHtml::BUTTON_COLOR_PRIMARY)); ?>
			
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
 
   var data=$("#acreditarcaja-form").serialize();
 
 
  $.ajax({
   type: 'POST',
    
   data: data,
   success:	function(data){
      var obj = $.parseJSON(data);
      if(obj.check=="success"){
          window.location = "<?php echo Yii::app()->createUrl("cheque/recibido"); ?>"; 
      }
      
      if(obj.Movimientocaja_caja_idcaja == "Caja no puede ser nulo."){
			$("#error-div").show();
			$("#error-div").html("<strong>Caja</strong> no puede ser nulo.");
      }
      if(obj.Movimientocaja_fecha == "Fecha no puede ser nulo."){
			$("#error-div").show();
			$("#error-div").append("<br><strong>Fecha de cobro</strong> no puede ser nulo.");
      }	
      
      if(obj.Movimientocaja_fechacobro == "La fecha ingresada debe ser mayor a la fecha de cobro"){
			$("#error-div").show();
			$("#error-div").append("<br>La <strong>fecha ingresada</strong> debe ser mayor a la fecha de cobro");
 	 }	
          
    }
  });
 }
 
</script>