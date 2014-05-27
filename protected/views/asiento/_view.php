<?php
/* @var $this AsientoController */
/* @var $data Asiento */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idasiento')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idasiento),array('view','id'=>$data->idasiento)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />


</div>