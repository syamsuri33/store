<?php
/* @var $this KategoriController */
/* @var $data Kategori */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Kategori_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Kategori_ID), array('view', 'id'=>$data->Kategori_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Kode')); ?>:</b>
	<?php echo CHtml::encode($data->Kode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Kategori')); ?>:</b>
	<?php echo CHtml::encode($data->Kategori); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Parent')); ?>:</b>
	<?php echo CHtml::encode($data->Parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Status')); ?>:</b>
	<?php echo CHtml::encode($data->Status); ?>
	<br />


</div>