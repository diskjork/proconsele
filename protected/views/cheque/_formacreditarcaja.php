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
	'enableClientValidation'=>false,
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
			<?php echo $form->hiddenField($modelCaja,'descripcion', array('value'=>'Cobro de cheque-'.$model->clienteIdcliente)); ?>
			<?php echo $form->hiddenField($modelCaja,'debeohaber', array('value'=>$model->debeohaber)); ?>
			<?php echo $form->hiddenField($modelCaja,'debe', array('value'=>$model->debe)); ?>
			<?php echo $form->hiddenField($modelCaja,'rubro_idrubro', array('value'=>'3')); ?>
			
			<?php echo $form->hiddenField($modelCaja,'formadepago_idformadepago', array('value'=>'1')); ?>
			<?php echo $form->hiddenField($modelCaja,'caja_idcaja', array('value'=>'1')); ?>
			<?php echo $form->hiddenField($modelCaja,'fechacobro', array('value'=>$model->fechacobro)); ?>
			
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
				echo CHtml::link('Volver', Yii::app()->request->baseUrl.'/cheque/admin',array ('class'=>'btn btn-primary'));
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
          window.location = "<?php echo Yii::app()->createUrl("cheque/admin"); ?>"; 
      }else{
          $("#error-div").show();
          $("#error-div").html("La <strong>fecha</strong> ingresada es menor a la <strong>fecha de cobro.");
          }
    }
  });
 }
 
</script>