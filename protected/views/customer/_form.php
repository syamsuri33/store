<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'customer-form',
		'enableAjaxValidation' => false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="card-body">
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Nama'); ?>
			<?php echo $form->textField($model, 'Nama', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Nama'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Alamat'); ?>
			<?php echo $form->textField($model, 'Alamat', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Alamat'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Telepon'); ?>
			<?php echo $form->textField($model, 'Telepon', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Telepon'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Type'); ?>
			<?php echo $form->dropDownList(
				$model,
				'Type',
				CHtml::listData(
					Customertype::model()->findAll(), 'CustomerType_ID', 'Type'),
				array('class' => 'form-control', 'empty' => 'Pilih Tipe...')
			); ?>
			<?php echo $form->error($model, 'Type'); ?>
		</div>
		<div class="row buttons">
			<?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
				'color' => TbHtml::BUTTON_COLOR_PRIMARY,
				'class' => 'mr-2' // Add margin-right
			));
			?>
			<?php echo TbHtml::link('Cancel', array('customer/index'), array('class' => 'btn btn-warning')); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->