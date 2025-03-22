<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'pembelian-form',
		'enableAjaxValidation' => false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if ($model->hasErrors()): ?>
		<div class="flash-error">
			<?php echo $form->errorSummary($model); ?>
		</div>
	<?php endif; ?>

	<?php echo $form->hiddenField($model, 'Pembelian_ID', array('value' => $id)); ?>

	<div class="card-body">
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Tanggal'); ?>
			<?php echo $form->dateField($model, 'Tanggal', array('class' => 'form-control date-picker', 'readonly' => 'readonly')); ?>
			<?php echo $form->error($model, 'Tanggal'); ?>
		</div>
		<div id="detail-container">
			<?php foreach ($details as $index => $detail): ?>
				<div class="detail-row">
					<h4>Detail <?php echo $index + 1; ?></h4>
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<?php echo $form->labelEx($modelPembelianDetail, "Barang_ID"); ?>
								<?php echo $form->dropDownList(
									$modelPembelianDetail,
									'Barang_ID',
									$barangList,
									array(
										'class' => 'form-control',
										'empty' => 'Pilih Tipe...',
										'name' => 'PembelianDetail[' . $index . '][Barang_ID]',
										'onchange' => 'updateSatuan2(' . $index . ', this.value)',
										'options' => array($detail['Barang_ID'] => array('selected' => 'selected')),
									)
								); ?>
								<?php echo $form->error($modelPembelianDetail, "[$index][Barang_ID]"); ?>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<?php echo $form->labelEx($modelPembelianDetail, "Satuan_ID"); ?>
								<?php echo $form->dropDownList(
									$modelPembelianDetail,
									'Satuan_ID',
									CHtml::listData(Satuan::model()->findAll(array(
										'condition' => 'MasterBarang_ID = ' . $detail['Barang_ID']
									)), 'Satuan_ID', 'Satuan'),
									array(
										'class' => 'form-control',
										'empty' => 'Pilih Satuan...',
										'name' => 'PembelianDetail[' . $index . '][Satuan_ID]',
										//'onchange' => 'updateSatuan2(' . $index . ', this.value)',
										'options' => array($detail['Satuan_ID'] => array('selected' => 'selected')),
									)
								); ?>

								<?php echo $form->error($modelPembelianDetail, "[$index][Satuan_ID]"); ?>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<?php echo $form->labelEx($modelPembelianDetail, "Jumlah"); ?>
								<?php echo $form->textField($modelPembelianDetail, "Jumlah", array('name' => 'PembelianDetail[' . $index . '][Jumlah]', 'class' => 'form-control', 'value' => $detail['Jumlah'])); ?>
								<?php echo $form->error($modelPembelianDetail, "[$index][Jumlah]"); ?>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<?php echo $form->labelEx($modelPembelianDetail, "Harga"); ?>
								<?php echo $form->textField($modelPembelianDetail, "Harga", array('name' => 'PembelianDetail[' . $index . '][Harga]', 'class' => 'form-control', 'value' => $detail['Harga'])); ?>
								<?php echo $form->error($modelPembelianDetail, "[$index][Harga]"); ?>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<?php echo $form->labelEx($modelPembelianDetail, "Modal"); ?>
								<?php echo $form->textField($modelPembelianDetail, "Modal", array('name' => 'PembelianDetail[' . $index . '][Modal]', 'class' => 'form-control', 'value' => $detail['Modal'])); ?>
								<?php echo $form->error($modelPembelianDetail, "[$index][Modal]"); ?>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<?php echo $form->labelEx($modelPembelianDetail, "Expired"); ?>
								<?php echo $form->dateField($modelPembelianDetail, "Expired", array('name' => 'PembelianDetail[' . $index . '][Expired]', 'class' => 'form-control date-picker', 'value' => $detail['Expired'])); ?>
								<?php echo $form->error($modelPembelianDetail, "[$index][Expired]"); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<button type="button" id="add-detail" class="btn btn-secondary">Add Detail</button>


		<div class="row buttons">
			<?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
				'color' => TbHtml::BUTTON_COLOR_PRIMARY,
				'class' => 'mr-2' // Add margin-right
			));
			?>
			<?php echo TbHtml::link('Cancel', array('pembelian/index'), array('class' => 'btn btn-warning')); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
	document.getElementById('add-detail').addEventListener('click', function() {
		var container = document.getElementById('detail-container');
		var index = container.children.length; // Get current count of detail rows
		var newRow = `
        <div class="detail-row">
            <h4>Detail ${index + 1}</h4>
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
						<label for="PembelianDetail[${index}][Barang_ID]">Barang</label>
						<select class="form-control" name="PembelianDetail[${index}][Barang_ID]" onchange="updateSatuan(${index}, this.value)">
							<option value="">Pilih Barang</option>
							<?php foreach ($barangList as $barang_id => $namaBarang): ?>
								<option value="<?php echo $barang_id; ?>"><?php echo $namaBarang; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="PembelianDetail[${index}][Satuan_ID]">Satuan</label>
						<select class="form-control" name="PembelianDetail[${index}][Satuan_ID]" id="satuan-${index}">
							<option value="">Pilih Satuan</option>
						</select>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="PembelianDetail[${index}][Jumlah]">Jumlah</label>
						<input class="form-control" name="PembelianDetail[${index}][Jumlah]" type="text">
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="PembelianDetail[${index}][Harga]">Harga</label>
						<input class="form-control" name="PembelianDetail[${index}][Harga]" type="text">
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="PembelianDetail[${index}][Modal]">Modal</label>
						<input class="form-control" name="PembelianDetail[${index}][Modal]" type="text">
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="PembelianDetail[${index}][Expired]">Expired</label>
						<input class="form-control date-picker" name="PembelianDetail[${index}][Expired]" id="Pembelian_Expired" type="date">
					</div>
				</div>
			</div>
        </div>
    `;
		container.insertAdjacentHTML('beforeend', newRow);
	});

	function updateSatuan(index, barangId) {
		var satuanSelect = document.getElementById('satuan-' + index);
		satuanSelect.innerHTML = ''; // Clear existing options

		if (barangId) {
			fetch(`<?php echo Yii::app()->createUrl('pembelian/getSatuan'); ?>&masterbarang_id=${barangId}`)
				.then(response => response.json())
				.then(data => {
					satuanSelect.innerHTML = '<option value="">Select Satuan</option>';
					for (var id in data) {
						satuanSelect.innerHTML += `<option value="${id}">${data[id]}</option>`;
					}
				});
		} else {
			satuanSelect.innerHTML = '<option value="">Select Satuan</option>';
		}
	}

	function updateSatuan2(index, masterbarang_id) {
		// Make an AJAX request to fetch the Satuan data based on the selected Pembelian_ID
		$.ajax({
			type: 'GET',
			url: '<?php echo Yii::app()->createUrl("pembelian/getSatuan2"); ?>',
			data: {
				masterbarang_id: masterbarang_id
			},
			// success: function(data) {
			// 	// Update the Satuan dropdown list
			// 	var satuanDropdown = $('#PembelianDetail_' + index + '_Satuan_ID');
			// 	satuanDropdown.empty();
			// 	$.each(data, function(key, value) {
			// 		satuanDropdown.append($('<option>', {
			// 			value: key,
			// 			text: value
			// 		}));
			// 	});
			// }
			// success: function(data) {
			// 	// Update the Satuan dropdown list
			// 	var satuanDropdown = $('#PembelianDetail_' + index + '_Satuan_ID');
			// 	satuanDropdown.empty();
			// 	Object.keys(data).forEach(function(key) {
			// 		satuanDropdown.append($('<option>', {
			// 			value: key,
			// 			text: data[key]
			// 		}));
			// 	});
			// }
			success: function(data) {
				// Parse the JSON string into an object
				var satuanData = JSON.parse(data);
				// Update the Satuan dropdown list
				var satuanDropdown = $('#PembelianDetail_' + index + '_Satuan_ID');
				satuanDropdown.empty();
				Object.keys(satuanData).forEach(function(key) {
					satuanDropdown.append($('<option>', {
						value: key,
						text: satuanData[key]
					}));
				});
			}
		});
	}
</script>