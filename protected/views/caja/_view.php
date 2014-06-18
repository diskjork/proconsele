<?php
/* @var $this CajaController */
/* @var $data Caja */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idcaja')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idcaja),array('view','id'=>$data->idcaja)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuenta_idcuenta')); ?>:</b>
	<?php echo CHtml::encode($data->cuenta_idcuenta); ?>
	<br />


</div>