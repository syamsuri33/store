<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'vendor-form',
		'enableAjaxValidation' => false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="card-body">
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Vendor'); ?>
			<?php echo $form->textField($model, 'Vendor', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Vendor'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model, 'Alamat'); ?>
			<?php echo $form->textField($model, 'Alamat', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Alamat'); ?>
		</div>

		<div class="row buttons">
			<?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
				'color' => TbHtml::BUTTON_COLOR_PRIMARY,
				'class' => 'mr-2' // Add margin-right
			));
			?>
			<?php echo TbHtml::link('Cancel', array('vendor/index'), array('class' => 'btn btn-warning')); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->