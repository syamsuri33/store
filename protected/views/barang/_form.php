<?php
/* @var $this BarangController */
/* @var $model Barang */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'barang-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Barang_ID'); ?>
		<?php echo $form->textField($model,'Barang_ID'); ?>
		<?php echo $form->error($model,'Barang_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MasterBarang_ID'); ?>
		<?php echo $form->textField($model,'MasterBarang_ID',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'MasterBarang_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'StatusPPN'); ?>
		<?php echo $form->textField($model,'StatusPPN'); ?>
		<?php echo $form->error($model,'StatusPPN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Jumlah'); ?>
		<?php echo $form->textField($model,'Jumlah'); ?>
		<?php echo $form->error($model,'Jumlah'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Unit'); ?>
		<?php echo $form->textField($model,'Unit',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'Unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Harga'); ?>
		<?php echo $form->textField($model,'Harga'); ?>
		<?php echo $form->error($model,'Harga'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Modal'); ?>
		<?php echo $form->textField($model,'Modal'); ?>
		<?php echo $form->error($model,'Modal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'StatusAktif'); ?>
		<?php echo $form->textField($model,'StatusAktif'); ?>
		<?php echo $form->error($model,'StatusAktif'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Created'); ?>
		<?php echo $form->textField($model,'Created'); ?>
		<?php echo $form->error($model,'Created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UserCreated_ID'); ?>
		<?php echo $form->textField($model,'UserCreated_ID',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'UserCreated_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Updated'); ?>
		<?php echo $form->textField($model,'Updated'); ?>
		<?php echo $form->error($model,'Updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UserUpdated_ID'); ?>
		<?php echo $form->textField($model,'UserUpdated_ID',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'UserUpdated_ID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->