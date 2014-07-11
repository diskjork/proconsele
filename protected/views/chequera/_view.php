<?php
/* @var $this ChequeraController */
/* @var $data Chequera */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idchequera')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idchequera),array('view','id'=>$data->idchequera)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctabancaria_idctabancaria')); ?>:</b>
	<?php echo CHtml::encode($data->ctabancaria_idctabancaria); ?>
	<br />


</div>