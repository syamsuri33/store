<?php
/* @var $this CustomerController */
/* @var $model Customer */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Customer_ID'); ?>
		<?php echo $form->textField($model,'Customer_ID',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Nama'); ?>
		<?php echo $form->textField($model,'Nama',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Alamat'); ?>
		<?php echo $form->textField($model,'Alamat',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Telepon'); ?>
		<?php echo $form->textField($model,'Telepon',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Type'); ?>
		<?php echo $form->textField($model,'Type'); ?>
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