<?php
/* @var $this OperasionalController */
/* @var $data Operasional */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Operasional_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Operasional_ID), array('view', 'id'=>$data->Operasional_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tanggal')); ?>:</b>
	<?php echo CHtml::encode($data->Tanggal); ?>
	<br />


</div>