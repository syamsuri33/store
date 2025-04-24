<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'masterbarang-form',
		'enableAjaxValidation' => false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="card-body">
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Kode'); ?>
			<?php echo $form->textField($model, 'Kode', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Kode'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Nama'); ?>
			<?php echo $form->textField($model, 'Nama', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Nama'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Kategori_ID'); ?>
			<?php echo $form->hiddenField($model, 'Kategori_ID', array('id' => 'Kategori_ID', 'class' => "form-control", 'readonly' => true)); ?>

			<div class="input-group input-group-sm">
				<?php echo CHtml::textField('Kategori', $kategoriValue, array('id' => 'kategori', 'class' => "form-control", 'readonly' => true)); ?>
				<div class="input-group-append">
					<?php echo CHtml::button('Pilih Kategori', array('id' => 'openPopup', 'class' => "btn btn-primary")); ?>
				</div>
			</div>

			<?php echo $form->error($model, 'Kategori_ID'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model, 'Vendor_ID'); ?>
			<?php echo $form->dropDownList(
				$model,
				'Vendor_ID',
				CHtml::listData(
					Vendor::model()->findAll(
						array( 'condition' => 'StatusAktif=:status', 'params' => array(':status' => 1) )
					), 
					'Vendor_ID', 'Vendor'),
				array('class' => 'form-control', 'empty' => 'Pilih Tipe...')
			); ?>
			<?php echo $form->error($model, 'Type'); ?>
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

		<div class="form-group">
			<?php echo $form->labelEx($model, 'Keterangan'); ?>
			<?php echo $form->textField($model, 'Keterangan', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'Keterangan'); ?>
		</div>
		
		<div class="form-group">
			<?php echo $form->labelEx($model, 'MinStok'); ?>
			<?php echo $form->textField($model, 'MinStok', array('class' => "form-control")); ?>
			<?php echo $form->error($model, 'MinStok'); ?>
		</div>

		<div class="row buttons">
			<?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
				'color' => TbHtml::BUTTON_COLOR_PRIMARY,
				'class' => 'mr-2' // Add margin-right
			));
			?>
			<?php echo TbHtml::link('Cancel', array('masterbarang/index'), array('class' => 'btn btn-warning')); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>

	<!-- Modal -->
	<div class="modal fade" id="dataModal" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dataModalLabel">Select Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="dataContent">
			</div>
		</div>
	</div>
</div><!-- form -->

<script>
    function formatNumberInput(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = value;
    }

    const hargaOfflineInput = document.getElementById('Masterbarang_HargaOffline');
	const hargaGrosirInput = document.getElementById('Masterbarang_HargaGrosir');	
    const hargaTokpedInput = document.getElementById('Masterbarang_HargaTokped');
	const minStokInput = document.getElementById('Masterbarang_MinStok');

    hargaOfflineInput.addEventListener('input', function (e) {
        formatNumberInput(e.target);
    });

	hargaGrosirInput.addEventListener('input', function (e) {
        formatNumberInput(e.target);
    });

    hargaTokpedInput.addEventListener('input', function (e) {
        formatNumberInput(e.target);
    });

	minStokInput.addEventListener('input', function (e) {
        formatNumberInput(e.target);
    });


	$(document).on('click', '#openPopup', function() {
		$('#dataContent').html('');

		$.ajax({
			url: '<?php echo $this->createUrl("masterBarang/getData"); ?>',
			type: 'GET',
			success: function(data) {
				$('#dataContent').html(data);
				$('#dataModal').modal('show');
			},
			error: function() {
				$('#dataContent').html('<p>Error loading data.</p>');
			}
		});
	});

	$('#dataModal').on('hidden.bs.modal', function() {
		$('#dataContent').html('');
	});
</script>