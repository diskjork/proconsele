<?php
/* @var $this MovimientocajaController */
/* @var $model Movimientocaja */
/* @var $form TbActiveForm */
?>
<script type="text/javascript">
function justNumbers(e)
{
var keynum = window.event ? window.event.keyCode : e.which;
if ((keynum == 8) || (keynum == 46))
return true;
 
return /\d/.test(String.fromCharCode(keynum));
}
</script>
<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'movimientocaja-form',
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
	
    <div id="msg" class="alert hide"></div>
    
    <p class="help-block">Los campos con <span class="required">*</span> son requeridos.</p>
    		
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
			
			<?php echo $form->hiddenField($model,'caja_idcaja', array('value'=>'1')); ?>
			
            <?php echo $form->label($model, 'rubro_idrubro');?>
            <?php
			    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				    'asDropDownList' => true,
				    'model'=>$model,
	    			'attribute' => 'rubro_idrubro',
		    		'data' => GxHtml::listDataEx(Rubro::model()->findAllAttributes(null,true)),
				    'pluginOptions' => array(
			    		'placeholder' => 'Rubro',
				    	'width' => '50%',
			    		'minimumResultsForSearch' => '3',
			    	),
			    ));
			?>
			
         <?php echo $form->hiddenField($model,'formadepago_idformadepago', array('value'=>'1')); ?>
          
		<?php echo $form->errorSummary($model); ?>
        <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    
		)); ?>
		<?php 
				echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/movimientocaja/admin',array ('class'=>'btn btn-primary'));
		?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->