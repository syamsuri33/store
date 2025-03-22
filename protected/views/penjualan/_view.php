<?php
/* @var $this PenjualanController */
/* @var $data Penjualan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Penjualan_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Penjualan_ID), array('view', 'id'=>$data->Penjualan_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tanggal')); ?>:</b>
	<?php echo CHtml::encode($data->Tanggal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Created')); ?>:</b>
	<?php echo CHtml::encode($data->Created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UserCreated_ID')); ?>:</b>
	<?php echo CHtml::encode($data->UserCreated_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Updated')); ?>:</b>
	<?php echo CHtml::encode($data->Updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UserUpdated_ID')); ?>:</b>
	<?php echo CHtml::encode($data->UserUpdated_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Total')); ?>:</b>
	<?php echo CHtml::encode($data->Total); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('StatusAktif')); ?>:</b>
	<?php echo CHtml::encode($data->StatusAktif); ?>
	<br />

	*/ ?>

</div>