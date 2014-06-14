<?php
/* @var $this BancoController */
/* @var $data Banco */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idBanco')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idBanco),array('view','id'=>$data->idBanco)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
	<?php echo CHtml::encode($data->telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion')); ?>:</b>
	<?php echo CHtml::encode($data->direccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('propio')); ?>:</b>
	<?php echo CHtml::encode($data->propio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('localidad_idlocalidad')); ?>:</b>
	<?php echo CHtml::encode($data->localidad_idlocalidad); ?>
	<br />


</div>