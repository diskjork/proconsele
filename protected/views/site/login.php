<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div id="anchoFormLogin">
<h4 class="well well-small">Ingresar</h4>
<br>
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

	<p class="note">Ingresar usuario y contraseña.</p>
	
	<?php //echo $form->errorSummary($model); ?>
	
	
	<?php echo $form->textFieldControlGroup($model,'username',array('class'=>'span3','maxlength'=>45)); ?>
	
	<?php echo $form->passwordFieldControlGroup($model,'password',array('class'=>'span3','maxlength'=>45)); ?>
		
	 <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton('Aceptar',array('color'=>TbHtml::BUTTON_COLOR_PRIMARY,)); ?>
    </div>
    

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>