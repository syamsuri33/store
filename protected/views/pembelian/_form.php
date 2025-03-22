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
		<div class="row">
			<div class="col-sm-3">
				<!-- Add PembelianDetail Form Fields -->
				<div class="form-group">
					<label for="barang">Barang</label>
					<?php echo $form->dropDownList(
						$pembelianDetail,
						'Barang_ID',
						$barangList,
						array(
							'prompt' => 'Select Barang',
							'class' => 'form-control',
							'id' => 'PembelianDetail_Barang_ID',
							'onchange' => 'updateSatuan2(this.value)',
						)
					); ?>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="satuan">Satuan</label>
					<?php echo $form->dropDownList($pembelianDetail, 'Satuan_ID', CHtml::listData(Satuan::model()->findAll(), 'Satuan_ID', 'Satuan'), array('prompt' => 'Select Satuan', 'class' => 'form-control', 'id' => 'PembelianDetail_Satuan_ID')); ?>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="form-group">
					<label for="jumlah">Jumlah</label>
					<?php echo $form->textField($pembelianDetail, 'Jumlah', array('class' => 'form-control', 'id' => 'PembelianDetail_Jumlah')); ?>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="harga">Harga</label>
					<?php echo $form->textField($pembelianDetail, 'Harga', array('class' => 'form-control', 'id' => 'PembelianDetail_Harga')); ?>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="diskon">Diskon</label>
					<?php echo $form->textField($pembelianDetail, 'Diskon', array('class' => 'form-control', 'id' => 'PembelianDetail_Diskon')); ?>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="expired">Expired</label>
					<?php echo $form->dateField($pembelianDetail, 'Expired', array('class' => 'form-control', 'id' => 'PembelianDetail_Expired')); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="button" class="btn btn-primary btn-large" id="add-detail-btn">Add Detail</button>
		</div>

		<table class="table table-bordered" id="details-table">
			<thead>
				<tr class="bg-info">
					<th>Barang</th>
					<th>Satuan</th>
					<th>Jumlah</th>
					<th>Harga</th>
					<th>Diskon</th>
					<th>Expired</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		<div class="form-group pt-3">
			<button type="submit" class="btn btn-success btn-large">Save</button>
		</div>
	</div>

	<?php $this->endWidget(); ?>
</div>

<script>
	var pembelianDetails = <?php echo json_encode(Yii::app()->session['pembelianDetails'] ?? []); ?>;

	if (!Array.isArray(pembelianDetails)) {
		pembelianDetails = [];
	}

	function updateDetailsTable() {
		var tbody = document.querySelector('#details-table tbody');
		tbody.innerHTML = '';

		if (pembelianDetails.length === 0) {
			var noDataRow = document.createElement('tr');
			noDataRow.innerHTML = '<td colspan="6" style="text-align: left;">No data</td>';
			tbody.appendChild(noDataRow);
		} else {
			pembelianDetails.forEach(function(detail, index) {
				var row = document.createElement('tr');
				row.innerHTML = `
                <td>${detail.barangName}</td>
                <td>${detail.satuanName}</td>
                <td>${detail.jumlah}</td>
				<td>${detail.harga}</td>
				<td>${detail.diskon}</td>
				<td>${detail.expired}</td>
                <td><button type="button" class="btn btn-danger" onclick="removeDetail(${index})">Remove</button></td>
            `;
				tbody.appendChild(row);
			});
		}
	}

	document.getElementById('add-detail-btn').addEventListener('click', function() {
		var barangID = document.getElementById('PembelianDetail_Barang_ID').value;
		var barangName = document.querySelector('#PembelianDetail_Barang_ID option:checked').text;
		var satuanID = document.getElementById('PembelianDetail_Satuan_ID').value;
		var satuanName = document.querySelector('#PembelianDetail_Satuan_ID option:checked').text;
		var jumlah = document.getElementById('PembelianDetail_Jumlah').value;
		var harga = document.getElementById('PembelianDetail_Harga').value;
		var diskon = -document.getElementById('PembelianDetail_Diskon').value;
		var expired = document.getElementById('PembelianDetail_Expired').value;

		if (!barangID || !satuanID || !jumlah || !harga || !diskon || !expired) {
			alert('Please fill all fields');
			return;
		}

		if (isNaN(jumlah) || isNaN(harga) || isNaN(diskon)) {
			alert('Jumlah, Harga Satuan and Diskon must be numbers');
			return;
		}

		pembelianDetails.push({
			barangID: barangID,
			barangName: barangName,
			satuanID: satuanID,
			satuanName: satuanName,
			jumlah: jumlah,
			harga: harga,
			diskon: diskon,
			expired: expired
		});

		updateDetailsTable();

		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("pembelian/updateSessionPembelianDetails"); ?>',
			data: {
				pembelianDetails: JSON.stringify(pembelianDetails)
			},
			success: function(response) {
				var result = JSON.parse(response);
				if (result.status === 'success') {
					console.log('Session updated successfully');
				} else {
					console.error('Error updating session:', result.message);
				}
			},
			error: function() {
				console.error('AJAX request failed');
			}
		});
	});

	window.removeDetail = function(index) {
		pembelianDetails.splice(index, 1);

		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("pembelian/updateSessionPembelianDetails"); ?>',
			data: {
				pembelianDetails: JSON.stringify(pembelianDetails)
			},
			success: function(response) {
				var result = JSON.parse(response);
				if (result.status === 'success') {
					console.log('Session updated successfully after removal');
				} else {
					console.error('Error updating session after removal:', result.message);
				}
			},
			error: function() {
				console.error('AJAX request failed while removing detail');
			}
		});

		updateDetailsTable();
	}

	updateDetailsTable();

	document.getElementById('PembelianDetail_Barang_ID').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});

	document.getElementById('PembelianDetail_Satuan_ID').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});

	document.getElementById('PembelianDetail_Jumlah').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});

	document.getElementById('PembelianDetail_Harga').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});

	document.getElementById('PembelianDetail_Diskon').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});

	document.getElementById('PembelianDetail_Expired').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});

	function updateSatuan2(masterbarang_id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo Yii::app()->createUrl("satuan/getSatuan2"); ?>',
			data: {
				masterbarang_id: masterbarang_id
			},
			success: function(data) {
				var satuanData = JSON.parse(data);

				var satuanDropdown = $('#PembelianDetail_Satuan_ID');
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

	//typing format idr
	formatInput('PembelianDetail_Jumlah');
    formatInput('PembelianDetail_Harga');

	function formatInput(id) {
        document.getElementById(id).addEventListener('input', function(event) {
            let input = event.target.value.replace(/[^\d]/g, '');
            input = Number(input).toLocaleString('id-ID');
            event.target.value = input;
        });
    }
</script>