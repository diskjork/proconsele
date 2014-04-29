
<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,      //-----
    'clientOptions' => array(       // lo que hay q agregar para que te valide ajax en el modal
        'validateOnSubmit' => true,		//
    ),
    'htmlOptions'=>array('class'=>'well'),	
)); ?>

    <p class="help-block">Campos obligatorios<span class="required">*</span></p>
   
    <?php
//////////////ALERT TEMPORIZADO////////////////////
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".info").delay(2000).fadeOut("slow");',
   	CClientScript::POS_READY
);
?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div id="bloqueAlert">
	    <div id="myAlert" class="alert alert-success fade in info estiloAlert" data-alert="alert">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
    </div>
<?php endif; 
///////////////////////////////////////////////////
?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldControlGroup($model,'username',array('class'=>'span3','maxlength'=>45,'disabled'=>true)); ?>
	
	<?php	
		/*if ($model->clave!="" && !($model->isNewRecord)){
			echo $form->checkBoxRow($model,'actualizaClave');
		}*/
	?>
	<?php echo $form->passwordFieldControlGroup($model,'clavere',array('class'=>'span3','maxlength'=>45)); ?>
	
	<?php echo $form->passwordFieldControlGroup($model,'reclave',array('class'=>'span3','maxlength'=>45)); ?>

	 <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar cambios',array(
		    'class'=>'btn btn-primary',
		   )); ?>
		
    </div>

<?php $this->endWidget(); ?>
</div>
</div>