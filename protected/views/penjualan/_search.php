<?php
/* @var $this PenjualanController */
/* @var $model Penjualan */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Penjualan_ID'); ?>
		<?php echo $form->textField($model,'Penjualan_ID',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tanggal'); ?>
		<?php echo $form->textField($model,'Tanggal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Created'); ?>
		<?php echo $form->textField($model,'Created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'UserCreated_ID'); ?>
		<?php echo $form->textField($model,'UserCreated_ID',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Updated'); ?>
		<?php echo $form->textField($model,'Updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'UserUpdated_ID'); ?>
		<?php echo $form->textField($model,'UserUpdated_ID',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Total'); ?>
		<?php echo $form->textField($model,'Total'); ?>
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