<?php
/* @var $this SatuanController */
/* @var $model Satuan */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Satuan_ID'); ?>
		<?php echo $form->textField($model,'Satuan_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Satuan'); ?>
		<?php echo $form->textField($model,'Satuan',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Jumlah'); ?>
		<?php echo $form->textField($model,'Jumlah'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Barang_ID'); ?>
		<?php echo $form->textField($model,'Barang_ID',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Status'); ?>
		<?php echo $form->textField($model,'Status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->