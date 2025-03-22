<?php
/* @var $this MasterbarangController */
/* @var $model Masterbarang */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'MasterBarang_ID'); ?>
		<?php echo $form->textField($model,'MasterBarang_ID',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Kode'); ?>
		<?php echo $form->textField($model,'Kode',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Nama'); ?>
		<?php echo $form->textField($model,'Nama',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Kategori'); ?>
		<?php echo $form->textField($model,'Kategori',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Keterangan'); ?>
		<?php echo $form->textField($model,'Keterangan',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Harga'); ?>
		<?php echo $form->textField($model,'Harga'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Barcode'); ?>
		<?php echo $form->textField($model,'Barcode',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MinStok'); ?>
		<?php echo $form->textField($model,'MinStok'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'StatusAktif'); ?>
		<?php echo $form->textField($model,'StatusAktif'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->