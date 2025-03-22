<?php
/* @var $this KategoriController */
/* @var $model Kategori */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'kategori-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'Kode'); ?>
		<?php echo $form->textField($model,'Kode',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Kode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Kategori'); ?>
		<?php echo $form->textField($model,'Kategori',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Kategori'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Parent'); ?>
		<?php echo $form->textField($model,'Parent',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Status'); ?>
		<?php echo $form->textField($model,'Status'); ?>
		<?php echo $form->error($model,'Status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->