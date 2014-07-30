<?php
/* @var $this MovimientocajaController */
/* @var $model Movimientocaja */
/* @var $form TbActiveForm */
if(isset($_GET['vista'])){
		$vista=$_GET['vista'];
		
	}
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
			
			<div>
			<?php echo $form->label($model, 'caja_idcaja');?>
       		<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'caja_idcaja',
				  'data' => GxHtml::listDataEx(Caja::model()->findAllAttributes(array('nombre'),true,array('condition'=>'estado=1','order'=>'nombre ASC')),'idcaja','nombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una caja',
					   'allowClear'=>true,
						'width'=> '60%',
					  ),
				)); ?>
				<?php  echo $form->error($model,'caja_idcaja',array('style'=>'color:#b94a48')); ?>
				</div><br>
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
				<?php  echo $form->error($model,'cuenta_idcuenta',array('style'=>'color:#b94a48')); ?>
			</div>
       
          
		<?php echo $form->errorSummary($model); ?>
   		<?php echo $form->hiddenField($model, 'vista', array());?>     
        
   <div class="form-actions" align="center">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar cambios',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        	'confirm'=>'Está seguro que desea guardar los datos?'
		    
		)); ?>
		<?php 
				echo CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/movimientocaja/admin',array ('class'=>'btn btn-primary'));
		?>
    </div>

    <?php $this->endWidget(); ?>
<?php if(isset($vista)){
	 Yii::app()->clientScript->registerScript('vista',"
$('#Movimientocaja_vista').val('".$vista."');");
}?>
</div><!-- form -->
<?php Yii::app()->clientScript->registerScript('test',"
				$('div .modal-footer').remove();
				$('div .form-actions').css('background-color','transparent');
				"); ?> 	