<?php
/* @var $this ChequeController */
/* @var $model Cheque */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'cheque-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	
)); 

?>
<p class="help-block">Los campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
    			<div class="span5">
    			 <?php  echo $form->label($model, 'fecharechazado')?>
	            <div class="input-append">
		            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
		        		'model' => $model,
		            	'attribute' => 'fecharechazado',
		            	'pluginOptions' => array(
		         				'format' => 'dd/mm/yyyy',
		         				'width' => '40',
		            			),
		            	'htmlOptions' => array(
								            'placeholder' => 'Seleccionar fecha',
								        	'class' => 'input-medium',
								        ),
		  			  ));
					?>
					 <span class="add-on"><icon class="icon-calendar"></icon></span>
				</div>
				</div>
				<div class="span5">
				 <?php echo $form->textFieldControlGroup($model,'comentario',array('span'=>13,'maxlength'=>255)); ?>
				</div>
	 </div>


<div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',array(
		    'class'=>'btn btn-primary',
        	'id'=>'boton-submit',
        	'confirm'=>'Está seguro que desea guardar los datos?'
		)); ?>
		<?php 
		    	echo CHtml::link('Cancelar',Yii::app()->createUrl("cheque/recibido"),
				array('class'=>'btn btn-primary'));
			?>
</div>

    <?php $this->endWidget(); ?>

</div><!-- form -->