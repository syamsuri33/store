<?php
/* @var $this MasterbarangController */
/* @var $data Masterbarang */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('MasterBarang_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->MasterBarang_ID), array('view', 'id'=>$data->MasterBarang_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Kode')); ?>:</b>
	<?php echo CHtml::encode($data->Kode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Nama')); ?>:</b>
	<?php echo CHtml::encode($data->Nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Kategori')); ?>:</b>
	<?php echo CHtml::encode($data->Kategori); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->Keterangan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Harga')); ?>:</b>
	<?php echo CHtml::encode($data->Harga); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Barcode')); ?>:</b>
	<?php echo CHtml::encode($data->Barcode); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('MinStok')); ?>:</b>
	<?php echo CHtml::encode($data->MinStok); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('StatusAktif')); ?>:</b>
	<?php echo CHtml::encode($data->StatusAktif); ?>
	<br />

	*/ ?>

</div>