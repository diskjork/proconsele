<?php
/* @var $this ProductoController */
/* @var $model Producto */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'producto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,      //-----
    'clientOptions' => array(       // lo que hay q agregar para que te valide ajax en el modal
        'validateOnSubmit' => true,		//
    ),
)); ?>

    <p class="help-block">Campos requeridos <span class="required">*</span>.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'nombre',array('span'=>4,'maxlength'=>45)); ?>
			
			 <?php /*echo $form->label($model, 'unidad');?>	
		            <?php
					   $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
						    'asDropDownList' => true,
						    'model'=>$model,
					   		'language'=>'es',
			    			'attribute' => 'unidad',
					   		'data'=>array('Tonelada','Bolsa'),
				    		'pluginOptions' => array(
						    	'width' => '50%',
					    		'minimumResultsForSearch' => '3',
					   			
					    	),
					    ));
					*/?>
		<div class="row-fluid">
			<div class="span5">
				<?php echo $form->textFieldControlGroup($model,'unidad',array('span'=>8,'maxlength'=>45)); ?>
			</div>
			<div class="span5">
				<?php echo $form->textFieldControlGroup($model,'cantidadventa',array('span'=>3,'maxlength'=>45)); ?>
			</div>
		</div>	
        <?php echo $form->textAreaControlGroup($model,'descripcion',array('rows'=>2,'span'=>5));?>
        <div>
        <?php  echo $form->label($model, 'precio')?>
    					<div class="input-prepend">
						
						<?php $this->widget('yiiwheels.widgets.maskmoney.WhMaskMoney', array(
						'model'=>$model,
						'attribute' => 'precio',
						'htmlOptions' => array(
							'placeholder' => '$',
							'class' => 'input-medium',
							
						),
						));?>
		</div>
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
				<?php  echo $form->error($model,'cuenta_idcuenta',array('style'=>'color:#b94a48')); ?>
             
					
        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_DEFAULT,
        	'confirm'=>'Está seguro que desea guardar los datos?'
		)); ?>
		<?php 
			echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/producto/admin',array ('class'=>'btn btn-primary'));
		?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScript('test',"
				$('div .modal-footer').remove();
				$('div .form-actions').css('background-color','transparent');
				$('#Producto_cantidadventa').keydown(function(event){
					solonumeromod(event);});
				
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
				"); ?> 	