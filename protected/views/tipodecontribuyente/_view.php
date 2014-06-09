<?php
/* @var $this TipodecontribuyenteController */
/* @var $data Tipodecontribuyente */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('idtipodecontribuyente')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idtipodecontribuyente),array('view','id'=>$data->idtipodecontribuyente)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iva')); ?>:</b>
	<?php echo CHtml::encode($data->iva); ?>
	<br />


</div>