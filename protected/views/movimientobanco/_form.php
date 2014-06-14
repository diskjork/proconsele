<?php
/* @var $this MovimientobancoController */
/* @var $model Movimientobanco */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'movimientobanco-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
        'clientOptions' => array(
        'validateOnSubmit' => true,
        ),
)); ?>

    <p class="help-block">Los campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
			
    		<?php echo $form->inlineRadioButtonListControlGroup($model, 'debeohaber', array(
				'Ingreso',
				'Egreso')
			 ); ?>
            
            <div class="row-fluid">
    				<div class="span5">
    				<?php  echo $form->label($model, 'fecha')?>
			            <div class="input-append">
				            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
				        		'model' => $model,
				            	'attribute' => 'fecha',
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
    					<?php  echo $form->label($model, 'importe')?>
    					<div class="input-prepend">
						<span class="add-on">$</span>
						<?php $this->widget('yiiwheels.widgets.maskmoney.WhMaskMoney', array(
						'model'=>$model,
						'attribute' => 'importe',
						'htmlOptions' => array(
							'placeholder' => '$',
							'class' => 'input-medium',
						),
						));?>
						</div>
    				</div>
            </div>
			 <?php echo $form->textFieldControlGroup($model,'descripcion',array('span'=>5,'maxlength'=>45)); ?>
            
			
            <?php // echo $form->textFieldControlGroup($model,'Banco_idBanco',array('span'=>5)); ?>
			<?php //echo $form->label($model, 'ctabancaria_idctabancaria');?>
            <?php /*
			    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				    'asDropDownList' => true,
				    'model'=>$model,
	    			'attribute' => 'ctabancaria_idctabancaria',
		    		'data' => GxHtml::listDataEx(Banco::model()->findAllAttributes(array('nombre'),true,array('condition'=>'propio=1','order'=>'nombre ASC')),'idBanco','nombre'),
				    'pluginOptions' => array(
			    		'placeholder' => 'Banco',
				    	'width' => '50%',
			    		'minimumResultsForSearch' => '3',
			    	),
			    )); */
			?>
            <?php //echo  $form->textFieldControlGroup($model,'formadepago_idformadepago',array('span'=>5)); ?>
			 <?php //echo $form->label($model, 'formadepago_idformadepago');?>
            <?php //echo $form->hiddenField($model,'formadepago_idformadepago', array('value'=>'3')); ?>
			 <?php //echo $form->label($model, 'formadepago_idformadepago');?>
			 <?php /*
			    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				    'asDropDownList' => true,
				    'model'=>$model,
	    			'attribute' => 'formadepago_idformadepago',
		    		'data' => GxHtml::listDataEx(Formadepago::model()->findAllAttributes(array('nombre'),true,array('order'=>'nombre ASC')),'idformadepago','nombre'),
				    'pluginOptions' => array(
			    		'placeholder' => 'Forma de Pago',
				    	'width' => '50%',
			    		'minimumResultsForSearch' => '3',
			    	),
			    )); */
			?>
            <?php //echo $form->textFieldControlGroup($model,'cheque_idcheque',array('span'=>5)); ?>

        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    
		)); ?>
		
		<?php 
			if($model->isNewRecord){
				echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/movimientobanco/admin',array ('class'=>'btn btn-primary'));
				//echo TbHtml::button('Primary',Yii::app()->request->baseUrl.'/movimientobanco/admin', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));
			}?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->