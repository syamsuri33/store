<?php
/* @var $this CustomerController */
/* @var $data Customer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Customer_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Customer_ID), array('view', 'id'=>$data->Customer_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Nama')); ?>:</b>
	<?php echo CHtml::encode($data->Nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Alamat')); ?>:</b>
	<?php echo CHtml::encode($data->Alamat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Telepon')); ?>:</b>
	<?php echo CHtml::encode($data->Telepon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Type')); ?>:</b>
	<?php echo CHtml::encode($data->Type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Status')); ?>:</b>
	<?php echo CHtml::encode($data->Status); ?>
	<br />


</div>