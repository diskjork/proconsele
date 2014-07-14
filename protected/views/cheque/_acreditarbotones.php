    <div class="well well-small">
    <h4 align="center">Usted puede realizar las siguientes operaciones:</h4>
    </div>
<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'Modalendozar',
    'header' => 'Endozar',
    'content' => '',//$this->renderPartial('_acreditendozar', array('model'=>$model,'modelCaja'=>$modelCaja),true),
  )); ?>
     

     <br>
     
<?php 
	echo TbHtml::link('Cobrar por Ventanilla ', Yii::app()->createUrl("cheque/acreditarcaja", array("id"=>$model->idcheque)),
	array ('class'=>'btn btn-primary')
	); 
    ?> 

<?php echo TbHtml::button('Depositar en Banco', array(
    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
    'size' => TbHtml::BUTTON_SIZE_DEFAULT,
    'data-toggle' => 'modal',
    'data-target' => '#Modaldepositar',
    )); 
    ?> 
 
 <?php
	
	$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'Modaldepositar',
    'header' => 'Depositar en Banco',
    'content' => $this->renderPartial('_formacreditarBanco', array('model'=>$model,'modelBanco'=>$modelBanco),true),
	'backdrop'=> 'static',
	'fade'=>false,
	'keyboard'=> false,
	'buttonOptions'=> false,
	'closeText'=>"",	
	
  ));  ?>