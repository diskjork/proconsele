<?php
/* @var $this EmpresaController */
/* @var $data Empresa */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idempresa')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idempresa),array('view','id'=>$data->idempresa)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('razonsocial')); ?>:</b>
	<?php echo CHtml::encode($data->razonsocial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombrefantasia')); ?>:</b>
	<?php echo CHtml::encode($data->nombrefantasia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuit')); ?>:</b>
	<?php echo CHtml::encode($data->cuit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion')); ?>:</b>
	<?php echo CHtml::encode($data->direccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
	<?php echo CHtml::encode($data->telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefax')); ?>:</b>
	<?php echo CHtml::encode($data->telefax); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tiposociedad')); ?>:</b>
	<?php echo CHtml::encode($data->tiposociedad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('localidad_idlocalidad')); ?>:</b>
	<?php echo CHtml::encode($data->localidad_idlocalidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logo')); ?>:</b>
	<?php echo CHtml::encode($data->logo); ?>
	<br />

	*/ ?>

</div>