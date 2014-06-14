<?php
/* @var $this CtabancariaController */
/* @var $data Ctabancaria */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idctabancaria')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idctabancaria),array('view','id'=>$data->idctabancaria)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('banco_idBanco')); ?>:</b>
	<?php echo CHtml::encode($data->banco_idBanco); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoctabancaria_idtipoctabancaria')); ?>:</b>
	<?php echo CHtml::encode($data->tipoctabancaria_idtipoctabancaria); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />


</div>