<?php
/* @var $this CuentaController */
/* @var $data Cuenta */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idcuenta')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idcuenta),array('view','id'=>$data->idcuenta)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigocta')); ?>:</b>
	<?php echo CHtml::encode($data->codigocta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipocuenta_idtipocuenta')); ?>:</b>
	<?php echo CHtml::encode($data->tipocuenta_idtipocuenta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asentable')); ?>:</b>
	<?php echo CHtml::encode($data->asentable); ?>
	<br />


</div>