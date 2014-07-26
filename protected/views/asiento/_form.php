<?php
/* @var $this AsientoController */
/* @var $model Asiento */
/* @var $form TbActiveForm */
?>
<?php 
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile($baseUrl.'/js_plugin/select2/select2.js');
	//$cs->registerScriptFile($baseUrl.'js_plugin/teamdf-jquery-number-c19aa59/jquery.number.js');
	$cs->registerCssFile($baseUrl.'/js_plugin/select2/select2.css');
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js_plugin/asiento.js', CClientScript::POS_HEAD);
	if(isset($_GET['vista'])){
		$vista=$_GET['vista'];
		
	}
?>
<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'asiento-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <?php
        //show errorsummary at the top for all models
        //build an array of all models to check
        echo $form->errorSummary(array_merge(array($model),$validatedMembers));
    ?>

            <?php echo $form->label($model, 'fecha');?>
             <div class="input-append">
		            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
					        'model' => $model,
							'attribute' => 'fecha',
		            	    'pluginOptions' => array(
					            'format' => 'dd/mm/yyyy',
		            			),
					        'htmlOptions' => array(
					            //'placeholder' => 'Seleccionar fecha',
					        	'class' => 'input-small',
					        	
					            'value'=>date('d/m/Y'),
					        )
					    ));
					    ?>
			<span class="add-on"><icon class="icon-calendar"></icon></span>
			</div>
            <?php echo $form->hiddenField($model,'totaldebe',array('span'=>5)); ?>
            <?php echo $form->hiddenField($model,'totalhaber',array('span'=>5)); ?>

            <?php echo $form->textAreaControlGroup($model,'descripcion', array('span' => 6, 'rows' => 2)); ?>
	<?php

    // see http://www.yiiframework.com/doc/guide/1.1/en/form.table
    // Note: Can be a route to a config file too,
    //       or create a method 'getMultiModelForm()' in the member model
	$arrayCuentas=GxHtml::listDataEx(Cuenta::model()->findAll(array('select' => 'idcuenta, concat(codigocta, " - ", nombre) as nombre','condition'=>'asentable=1','order'=>'nombre ASC')),'idcuenta','nombre');
    $memberFormConfig = array(
   		 
          'elements'=>array(
            'cuenta_idcuenta'=>array(
                'type'=>'dropdownlist',
               // 'maxlength'=>40,
    			'items'=>$arrayCuentas,
    			'prompt'=>'seleccione una cuenta',
    			//'class'=>'select2',
            ),
            'debe'=>array(
                'type'=>'text',
                'onclick'=>'debeBlock(this.id);
                		   ',
            	'onkeydown'=>'solonumeromod(event);
					        				  this.val().toFixed(2);',
            ),
            'haber'=>array(
                'type'=>'text',
                'onclick'=>'haberBlock(this.id);
                			',
            	'onkeydown'=>'solonumeromod(event);
					          ',
            ),
            
        ));

    $this->widget('ext.multimodelform.MultiModelForm',array(
            'id' => 'id_member', //the unique widget id
            'formConfig' => $memberFormConfig, //the form configuration array
            'model' => $member, //instance of the form model
			'bootstrapLayout'=>true,
	   		//'jsAfterCloneCallback'=>'alertIds',
			'tableView' => true,
			
			'addItemText' => '(+)',
			'removeText' => '(-)',
			'removeConfirm' => 'Quitar este elemento?',
			'showErrorSummary' => false,
			'showAddItemOnError'=>true,
	   		'hideCopyTemplate'=>true,
	   		'addItemAsButton'=>true,
            //if submitted not empty from the controller,
            //the form will be rendered with validation errors
            'validatedItems' => $validatedMembers,

            //array of member instances loaded from db
            'data' => $member->findAll('asiento_idasiento=:idasiento', array(':idasiento'=>$model->idasiento)),
        ));
    ?>
        <div class="form-actions" align="center">
        <?php 
        if(!isset($vista)){
        echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',array(
		    'class'=>'btn btn-primary',
        	'id'=>'boton-submit',
		)); 
		 		echo " ";
		    	echo CHtml::link('Cancelar',Yii::app()->createUrl("asiento/admin"),
				array('class'=>'btn btn-primary'));
        } else {
        	switch ($vista){
        		case 1:
	        		echo CHtml::link('Volver',Yii::app()->createUrl("movimientobanco/admin"),
					array('class'=>'btn btn-primary'));
        		break;
        		case 2:
        			echo CHtml::link('Volver',Yii::app()->createUrl("movimientocaja/admin"),
					array('class'=>'btn btn-primary'));
        	}
        	
        }
			?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
