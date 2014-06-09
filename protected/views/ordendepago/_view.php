<?php
/* @var $this OrdendepagoController */
/* @var $data Ordendepago */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idordendepago')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idordendepago),array('view','id'=>$data->idordendepago)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcionordendepago')); ?>:</b>
	<?php echo CHtml::encode($data->descripcionordendepago); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importe')); ?>:</b>
	<?php echo CHtml::encode($data->importe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctacteprov_idctacteprov')); ?>:</b>
	<?php echo CHtml::encode($data->ctacteprov_idctacteprov); ?>
	<br />


</div>