<?php
/* @var $this BarangController */
/* @var $model Barang */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Barang_ID'); ?>
		<?php echo $form->textField($model,'Barang_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MasterBarang_ID'); ?>
		<?php echo $form->textField($model,'MasterBarang_ID',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'StatusPPN'); ?>
		<?php echo $form->textField($model,'StatusPPN'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Jumlah'); ?>
		<?php echo $form->textField($model,'Jumlah'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Unit'); ?>
		<?php echo $form->textField($model,'Unit',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Harga'); ?>
		<?php echo $form->textField($model,'Harga'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Modal'); ?>
		<?php echo $form->textField($model,'Modal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'StatusAktif'); ?>
		<?php echo $form->textField($model,'StatusAktif'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Created'); ?>
		<?php echo $form->textField($model,'Created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'UserCreated_ID'); ?>
		<?php echo $form->textField($model,'UserCreated_ID',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Updated'); ?>
		<?php echo $form->textField($model,'Updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'UserUpdated_ID'); ?>
		<?php echo $form->textField($model,'UserUpdated_ID',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->