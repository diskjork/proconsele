<?php
/* @var $this BancoController */
/* @var $model Banco */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	//'id'=>'bancocheque-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
        'clientOptions' => array(
        'validateOnSubmit' => true,
        ),
    
)); ?>

    <p class="help-block">Los campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>5,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'telefono',array('span'=>5,'maxlength'=>20)); ?>

            <?php echo $form->textFieldControlGroup($model,'direccion',array('span'=>5,'maxlength'=>45)); ?>

        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton('Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    
		)); ?>
		
		<?php 
			echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/cheque/admin',array ('class'=>'btn btn-primary'));
				//echo TbHtml::button('Primary',Yii::app()->request->baseUrl.'/movimientobanco/admin', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
			?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->