<?php 
/* @var $this CuentaController */
/* @var $model Cuenta */

$this->menu=array(
	
	array('label'=>'Volver', 'url'=>Yii::app()->request->Urlreferrer)
);



?>
<h5 class="well well-small">ADMINISTRACIÓN DE CUENTAS</h5>
<div class="form" >

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'seleccuenta-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<div class="row-fluid">	
		<div class="span4">
		<?php echo $form->label($model, 'nombre');?>
			<?php $this->widget('ext.select2.ESelect2',array(
				  //'name'=>'cuenta_idcuenta',
				 'model'=>$model,
				 'attribute'=>'nombre',
				  'data' => GxHtml::listDataEx(Cuenta::model()->findAllAttributes(array('codigocta,nombre'),true,array('condition'=>'asentable=1','order'=>'codigocta ASC')),'idcuenta','codNombre'),
				  'options'=>array(
					   'placeholder'=>'Seleccione una cuenta',
					   'allowClear'=>true,
						'width'=> '100%',
					  ),
				)); ?>
		<?php  echo $form->error($model,'nombre',array('style'=>'color:#b94a48')); ?>
		<div id="error-div-nombre" class="alert alert-block alert-error" style="display:none;">
		Debe seleccionar una  <strong>cuenta</strong> 
   		</div>
		</div>	
		<div class="span3">		
				<?php echo $form->labelEx($model, 'fecha',array());?>
				 <div class="input-append">
					<?php if (!isset($model->fecha))$fecha=date('d/m/Y'); else $fecha=$model->fecha;?>
			            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
						        'model' => $model,
								'attribute' => 'fecha',
						        'pluginOptions' => array(
						            'format' => 'dd/mm/yyyy',
			            			'language'=>'es'
						        ),
						        'htmlOptions' => array(
						            //'placeholder' => 'Seleccionar fecha',
						        	'class' => 'input-medium',
						        'value'=>$fecha,
						        )
						    ));
						?>
					<span class="add-on"><icon class="icon-calendar"></icon></span>
				</div>
			</div>
		<div class="span3">		
				<?php echo $form->labelEx($model, 'fecha2',array());?>
				 <div class="input-append">
					<?php if (!isset($model->fecha2))$fecha2=date('d/m/Y'); else $fecha2=$model->fecha2;?>
			            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
						        'model' => $model,
								'attribute' => 'fecha2',
						        'pluginOptions' => array(
						            'format' => 'dd/mm/yyyy',
			            			'language'=>'es'
						        ),
						        'htmlOptions' => array(
						            //'placeholder' => 'Seleccionar fecha',
						        	'class' => 'input-medium',
						        'value'=>$fecha2,
						        )
						    ));
						?>
					<span class="add-on"><icon class="icon-calendar"></icon></span>
				</div>
			</div>
		<div class="span2"><br>
		<?php echo TbHtml::ajaxButton('Cargar', CController::createUrl('cuenta/movimientocuenta'), 
										array('update' => '#grillacuenta',
											  'type'=>'post',
											  'data'=>array(
															'nombre'=>'js:$("#Cuenta_nombre").val()',
															'fecha'=>'js:$("#Cuenta_fecha").val()',
															'fecha2'=>'js:$("#Cuenta_fecha2").val()'),
												),  array(
														'id'=>'botonajax',
														'color' => TbHtml::BUTTON_COLOR_PRIMARY))?>
		</div>																	
</div>
<div id="grillacuenta">
<?php $this->endWidget(); ?>
</div>
</div>
<script>
	$("#botonajax").click(function(){
		var idcuenta=$("#Cuenta_nombre").val();
		if(idcuenta == ""){
			$("#error-div-nombre").show();
			//$("#error-div-nombre").append("Debe seleccionar una  <strong>cuenta</strong> ");
		} else {
			$("#error-div-nombre").css('display','none');
			$("#error-div-nombre").empty();
		}
		});
</script>