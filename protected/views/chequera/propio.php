<?php
/* @var $this ChequeraController */
/* @var $model Chequera */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'habilitar-form',
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

  
    <?php echo $form->errorSummary($model); ?>

            <?php // echo $form->textFieldControlGroup($model,'nombre',array('span'=>5,'maxlength'=>45)); ?>
			<?php if(isset($model->desactivadas)){
				
				echo $form->label($model, 'nombre');
			   $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
							    'asDropDownList' => true,
							    'model'=>$model,
						   		'language'=>'es',
				    			'attribute' => 'nombre',
					    		'data' => GxHtml::listDataEx(Chequera::model()->
						   				findAllAttributes(array('idchequera,nombre'),true,array('condition'=>'estado=0','order'=>'nombre ASC')),'idchequera','nombre'),
					    		'pluginOptions' => array(
							    	'width' => '90%',
						    		'minimumResultsForSearch' => '3',
						   			
						    	),
						    ));
			} else {
				$var=1;
				echo "<h5> No hay ninguna chequera deshabilitada</h5>";
			}
						?>
						
            <?php //echo $form->textFieldControlGroup($model,'telefono',array('span'=>5,'maxlength'=>20)); ?>

            <?php // echo $form->textFieldControlGroup($model,'direccion',array('span'=>5,'maxlength'=>45)); ?>

        <div class="form-actions" align="center">
        <?php if(!isset($var)){
           	echo TbHtml::submitButton('Habilitar',array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		 	));
		 	echo " ".CHtml::link('Cancelar', Yii::app()->request->baseUrl.'/chequera/admin',array ('class'=>'btn btn-primary'));
        } else {
        	echo CHtml::link('Volver', Yii::app()->request->baseUrl.'/chequera/admin',array ('class'=>'btn btn-primary'));
        }
		 	?>
		
		
		
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->