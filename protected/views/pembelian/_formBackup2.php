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
							'id' => 'PembelianDetail_Barang_ID', // Ensure this ID matches
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
					<label for="modal">Modal</label>
					<?php echo $form->textField($pembelianDetail, 'Modal', array('class' => 'form-control', 'id' => 'PembelianDetail_Modal')); ?>
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
			<button type="button" class="btn btn-primary" id="add-detail-btn">Add Detail</button>
		</div>

		<!-- Table for Displaying Added Details -->
		<table class="table table-bordered" id="details-table">
			<thead>
				<tr class="bg-info">
					<th>Barang</th>
					<th>Satuan</th>
					<th>Jumlah</th>
					<th>Harga</th>
					<th>Modal</th>
					<th>Expired</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<?php echo "xxx".Yii::app()->session['pembelianDetails'] = 'pembelianDetails'; ?>

		<div class="form-group pt-3">
			<button type="submit" class="btn btn-success">Save</button>
		</div>
	</div>

	<?php $this->endWidget(); ?>
</div>

<script>
	// Ensure that the session variable is correctly handled
	var pembelianDetails = <?php echo json_encode(Yii::app()->session['pembelianDetails'] ?? []); ?>;

	// Check if pembelianDetails is an array, if not initialize it
	if (!Array.isArray(pembelianDetails)) {
		pembelianDetails = [];
	}

	console.log('Initial pembelianDetails:', pembelianDetails);

	// Function to update the details table
	function updateDetailsTable() {
		var tbody = document.querySelector('#details-table tbody');
		tbody.innerHTML = ''; // Clear existing rows

		if (pembelianDetails.length === 0) {
			// Create a row to show "No data"
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
				<td>${detail.modal}</td>
				<td>${detail.expired}</td>
                <td><button type="button" class="btn btn-danger" onclick="removeDetail(${index})">Remove</button></td>
            `;
				tbody.appendChild(row);
			});
		}
	}

	// Add detail to session and update table
	document.getElementById('add-detail-btn').addEventListener('click', function() {
		var barangID = document.getElementById('PembelianDetail_Barang_ID').value;
		var barangName = document.querySelector('#PembelianDetail_Barang_ID option:checked').text;
		var satuanID = document.getElementById('PembelianDetail_Satuan_ID').value;
		var satuanName = document.querySelector('#PembelianDetail_Satuan_ID option:checked').text;
		var jumlah = document.getElementById('PembelianDetail_Jumlah').value;
		var harga = document.getElementById('PembelianDetail_Harga').value;
		var modal = document.getElementById('PembelianDetail_Modal').value;
		var expired = document.getElementById('PembelianDetail_Expired').value;

		// Validate fields
		if (!barangID || !satuanID || !jumlah || !harga || !modal || !expired) {
			alert('Please fill all fields');
			return;
		}

		// Add to session (simulate session using JavaScript)
		pembelianDetails.push({
			barangID: barangID,
			barangName: barangName,
			satuanID: satuanID,
			satuanName: satuanName,
			jumlah: jumlah,
			harga: harga,
			modal: modal,
			expired: expired
		});

		// Update session and table
		<?php Yii::app()->session['pembelianDetails'] = 'pembelianDetails'; ?> // This line is necessary to persist the session in Yii
		console.log('Initial pembelianDetails:', pembelianDetails);
		updateDetailsTable();
	});

	// Remove detail from session
	window.removeDetail = function(index) {
		pembelianDetails.splice(index, 1);
		updateDetailsTable();
	}

	// Initial table population
	updateDetailsTable();

	// Add event listener to input fields to capture Enter key
	document.getElementById('PembelianDetail_Barang_ID').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault(); // Prevent form submission
			document.getElementById('add-detail-btn').click(); // Simulate click on Add Detail button
		}
	});

	document.getElementById('PembelianDetail_Satuan_ID').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault(); // Prevent form submission
			document.getElementById('add-detail-btn').click(); // Simulate click on Add Detail button
		}
	});

	document.getElementById('PembelianDetail_Jumlah').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault(); // Prevent form submission
			document.getElementById('add-detail-btn').click(); // Simulate click on Add Detail button
		}
	});

	document.getElementById('PembelianDetail_Harga').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault(); // Prevent form submission
			document.getElementById('add-detail-btn').click(); // Simulate click on Add Detail button
		}
	});

	document.getElementById('PembelianDetail_Modal').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault(); // Prevent form submission
			document.getElementById('add-detail-btn').click(); // Simulate click on Add Detail button
		}
	});

	document.getElementById('PembelianDetail_Expired').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault(); // Prevent form submission
			document.getElementById('add-detail-btn').click(); // Simulate click on Add Detail button
		}
	});

	function updateSatuan2(masterbarang_id) {
		// Make an AJAX request to fetch the Satuan data based on the selected Pembelian_ID
		$.ajax({
			type: 'GET',
			url: '<?php echo Yii::app()->createUrl("pembelian/getSatuan2"); ?>',
			data: {
				masterbarang_id: masterbarang_id
			},
			success: function(data) {
				// Parse the JSON string into an object
				var satuanData = JSON.parse(data);
				// Update the Satuan dropdown list
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
</script>