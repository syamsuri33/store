<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'satuan-form',
		'enableAjaxValidation' => false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="card-body">
		<div class="form-group">
			<?php echo $form->labelEx($model, 'MasterBarang_ID'); ?>
			<?php echo $form->dropDownList(
				$model,
				'MasterBarang_ID',
				CHtml::listData(MasterBarang::model()->findAll(), 'MasterBarang_ID', 'Nama'),
				array('class' => 'form-control', 'empty' => 'Pilih Barang...')
			); ?>
			<?php echo $form->error($model, 'MasterBarang_ID'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Satuan'); ?>
			<?php echo $form->textField($model, 'Satuan', array('class' => "form-control", 'size' => 60, 'maxlength' => 100)); ?>
			<?php echo $form->error($model, 'Satuan'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Jumlah'); ?>
			<?php echo $form->textField($model, 'Jumlah', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Jumlah'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'HargaOffline'); ?>
			<?php echo $form->textField($model, 'HargaOffline', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'HargaOffline'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'HargaGrosir'); ?>
			<?php echo $form->textField($model, 'HargaGrosir', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'HargaGrosir'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'HargaTokped'); ?>
			<?php echo $form->textField($model, 'HargaTokped', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'HargaTokped'); ?>
		</div>

		<div class="row buttons">
			<?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
				'color' => TbHtml::BUTTON_COLOR_PRIMARY,
				'class' => 'mr-2' // Add margin-right
			));
			?>
			<?php echo TbHtml::link('Cancel', array('satuan/index'), array('class' => 'btn btn-warning')); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
	//typing format idr 
	formatInput('Satuan_HargaOffline');
	formatInput('Satuan_HargaGrosir');
    formatInput('Satuan_HargaTokped');

	function formatInput(id) {
        document.getElementById(id).addEventListener('input', function(event) {
            let input = event.target.value.replace(/[^\d]/g, '');
            input = Number(input).toLocaleString('id-ID');
            event.target.value = input;
        });
    }
</script>