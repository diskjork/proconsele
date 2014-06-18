<?php
/* @var $this CajaController */
/* @var $model Caja */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'caja-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Los campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

            <div class="row-fluid">
    			<div class="span5">
	            <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>13,'maxlength'=>100)); ?>
				</div>
				
			 </div>
            <?php echo $form->textAreaControlGroup($model,'descripcion', array('span' => 5, 'rows' => 2)); ?>

            <?php //echo $form->textFieldControlGroup($model,'banco_idBanco',array('span'=>5)); ?>
           	<div>
            <?php echo $form->label($model, 'cuenta_idcuenta');?>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'cuenta_idcuenta',
				  'data' => GxHtml::listDataEx(Cuenta::model()->findAllAttributes(array('codigocta,nombre'),true,array('condition'=>'asentable=1','order'=>'codigocta ASC')),'idcuenta','codNombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una cuenta',
					   'allowClear'=>true,
						'width'=> '60%',
					  ),
				)); ?>
				<?php echo $form->error($model,'cuenta_idcuenta',array('style'=>'color:#b94a48')); ?>
			</div>

        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',array(
		    'class'=>'btn btn-primary',
        	'id'=>'boton-submit',
		)); ?>
		<?php 
		    	echo CHtml::link('Cancelar',Yii::app()->createUrl("caja/admin"),
				array('class'=>'btn btn-primary'));
			?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->