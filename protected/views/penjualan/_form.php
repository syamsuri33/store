<style>
	#printArea {
		display: none;
	}

	.disabled-dropdown {
		background-color: #eee;
		cursor: not-allowed;
		opacity: 0.8;
		pointer-events: none;
	}

</style>
<div class="form">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'penjualan-form',
		'enableAjaxValidation' => false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if ($model->hasErrors()): ?>
		<div class="flash-error">
			<?php echo $form->errorSummary($model); ?>
		</div>
	<?php endif; ?>

	<?php echo $form->hiddenField($model, 'Penjualan_ID', array('value' => $id)); ?>

	<div class="card-body">
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Tanggal'); ?>
			<?php echo $form->dateField($model, 'Tanggal', array('class' => 'form-control date-picker', 'readonly' => 'readonly')); ?>
			<?php echo $form->error($model, 'Tanggal'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Customer_ID'); ?>
			<?php echo $form->dropDownList(
				$model,
				'Customer_ID',
				$customerList,
				array(
					'prompt' => 'Select Customer',
					'class' => 'form-control',
					'id' => 'Penjualan_Customer_ID',
					'onchange' => 'updateHarga(this.value, $("#PenjualanDetail_MasterBarang_ID").val(), $("#PenjualanDetail_Penjualan_Dari").val(), $("#PenjualanDetail_Satuan_ID").val());',
				)
			); ?>
			<?php echo CHtml::hiddenField('Customer_ID_hidden', '', array('id' => 'Customer_ID_hidden')); ?>
			<?php echo $form->error($model, 'Customer_ID'); ?>
		</div>


		<div class="row">
			<div class="col-sm-4">
				<!-- Add PenjualanDetail Form Fields -->
				<div class="form-group">
					<label for="barang">Barang</label>
					<?php echo $form->dropDownList(
						$penjualanDetail,
						'MasterBarang_ID',
						$barangList,
						array(
							'prompt' => 'Select Barang',
							'class' => 'form-control',
							'id' => 'PenjualanDetail_MasterBarang_ID',
							'onchange' => 'updateSatuan2(this.value);',
							// 'onchange' => 'updateSatuan2(this.value); updateHarga(this.value, $("#PenjualanDetail_Penjualan_Dari").val(), $("#PenjualanDetail_Satuan_ID").val());',
						)
					); ?>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="satuan">Satuan</label>
					<?php echo $form->dropDownList(
						$penjualanDetail,
						'Satuan_ID',
						CHtml::listData(Satuan::model()->findAll(), 'Satuan_ID', 'Satuan'),
						array(
							'prompt' => 'Select Satuan',
							'class' => 'form-control',
							'id' => 'PenjualanDetail_Satuan_ID',
							'onchange' => 'updateHarga($("#Penjualan_Customer_ID").val(), $("#PenjualanDetail_MasterBarang_ID").val(), $("#PenjualanDetail_Penjualan_Dari").val(), this.value);',
						)
					); ?>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="form-group">
					<label for="jumlah">Jumlah</label>
					<?php echo $form->textField($penjualanDetail, 'Jumlah', array('class' => 'form-control', 'id' => 'PenjualanDetail_Jumlah')); ?>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="harga">Harga</label>
					<?php echo $form->textField($penjualanDetail, 'Harga', array('class' => 'form-control', 'id' => 'PenjualanDetail_Harga')); ?>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="penjualanDari">Penjualan Dari</label>
					<?php echo $form->dropDownList($penjualanDetail, 'Penjualan_Dari', array(
						'OFFLINE' => 'OFFLINE',
						'TOKOPEDIA' => 'TOKOPEDIA',
					), array(
						'class' => 'form-control',
						'id' => 'PenjualanDetail_Penjualan_Dari',
						'onchange' => 'updateHarga($("#Penjualan_Customer_ID").val(), $("#PenjualanDetail_MasterBarang_ID").val(), this.value, $("#PenjualanDetail_Satuan_ID").val());',
					)); ?>
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
					<th>Penjualan Dari</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		<div class="form-group pt-3">
			<button type="submit" class="btn btn-success btn-large">Save</button>
			<button onclick="printContent()" class="btn btn-info btn-large">Print</button>
		</div>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->

<div class="container">
	<!-- <button onclick="printContent()">Print</button> -->
	<div id="printArea">
		<table id="details-table2" style="width: 280px; table-layout: fixed; font-family: sans-serif;">
			<thead>
				<tr>
					<th style="width: 170px;"></th>
					<th style="width: 50px;"></th>
					<th style="width: 80px;"></th>
					<th style="width: 80px;"></th>
				</tr>
				<tr>
					<td colspan="4" style="text-align: center; font-weight: bold;">Dyoz.&</td>
				</tr>
				<tr>
					<td colspan="4">==============================================</td>
				</tr>
				<tr>
					<td colspan="4"><?php echo date("d-M-Y H:i");; ?></td>
				</tr>
				<tr>
					<td colspan="4">==============================================</td>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>


<script>
	var penjualanDetails = <?php echo json_encode(Yii::app()->session['penjualanDetails'] ?? []); ?>;

	if (!Array.isArray(penjualanDetails)) {
		penjualanDetails = [];
	}

	function updateDetailsTable() {
		var tbody = document.querySelector('#details-table tbody');
		var tbody2 = document.querySelector('#details-table2 tbody');
		tbody.innerHTML = '';
		tbody2.innerHTML = '';

		if (penjualanDetails.length === 0) {
			var noDataRow = document.createElement('tr');
			var noDataRow2 = document.createElement('tr');
			noDataRow.innerHTML = '<td colspan="4" style="text-align: left;">No data</td>';
			noDataRow2.innerHTML = '<td colspan="4" style="text-align: left;">No data</td>';
			tbody.appendChild(noDataRow);
			tbody2.appendChild(noDataRow2);
		} else {
			var totalJumlah = 0;
			var totalHarga = 0;

			penjualanDetails.forEach(function(detail, index) {
				var row = document.createElement('tr');
				var row2 = document.createElement('tr');

				row.innerHTML = `
                <td>${detail.barangName}</td>
                <td>${detail.satuanName}</td>
                <td>${detail.jumlah}</td>
				<td>${detail.harga}</td>
				<td>${detail.penjualanDari}</td>
                <td><button type="button" class="btn btn-danger" onclick="removeDetail(${index})">Remove</button></td>`;

				var string = detail.barangName;
				var truncatedString = truncateString(string, 15, 9);
				row2.innerHTML = `
                <td style="width: 10px; font-size: 13px;">${truncatedString}</td>
                <td style="width: 10px; font-size: 14px; text-align:right;">${Number(detail.jumlah).toLocaleString()}</td>
				<td style="width: 10px; font-size: 14px; text-align:right;">${Number(detail.harga).toLocaleString()}</td>
				<td style="width: 10px; font-size: 14px; text-align:right;">${(detail.jumlah * detail.harga).toLocaleString()}</td>				
            `;
				totalJumlah += Number(detail.jumlah);
				totalHarga += Number(detail.jumlah * detail.harga);
				tbody.appendChild(row);
				tbody2.appendChild(row2);

			});

			var spasi = document.createElement('tr');
			spasi.innerHTML = `<td colspan="4">===============================================</td>`;
			tbody2.appendChild(spasi);

			var trTotal = document.createElement('tr');
			trTotal.innerHTML = `
                <td style="font-weight: bold; width: 10px; font-size: 13px;">Total</td>
				<td style="font-weight: bold; width: 10px; font-size: 14px; text-align:right;">${totalJumlah.toLocaleString()}</td>
				<td></td>
				<td style="font-weight: bold; width: 10px; font-size: 14px; text-align:right;">${totalHarga.toLocaleString()}</td>
            `;
			tbody2.appendChild(trTotal);
		}
	}



	function addDetailFunction() {
		console.log("Button Clicked!");
		var barangID = document.getElementById('PenjualanDetail_MasterBarang_ID').value;
		var barangName = document.querySelector('#PenjualanDetail_MasterBarang_ID option:checked').text;
		var satuanID = document.getElementById('PenjualanDetail_Satuan_ID').value;
		var satuanName = document.querySelector('#PenjualanDetail_Satuan_ID option:checked').text;
		var jumlah = document.getElementById('PenjualanDetail_Jumlah').value;
		var harga = document.getElementById('PenjualanDetail_Harga').value;
		var penjualanDari = document.getElementById('PenjualanDetail_Penjualan_Dari').value;

		if (!barangID || !satuanID || !jumlah || !harga || !penjualanDari) {
			alert('Please fill all fields');
			return;
		}

		if (isNaN(jumlah) || isNaN(harga)) {
			alert('Jumlah, Harga Satuan and Diskon must be numbers');
			return;
		}
		penjualanDetails.push({
			barangID: barangID,
			barangName: barangName,
			satuanID: satuanID,
			satuanName: satuanName,
			jumlah: jumlah,
			harga: harga,
			penjualanDari: penjualanDari
		});

		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("penjualan/updateSessionPenjualanDetails"); ?>',
			data: {
				penjualanDetails: JSON.stringify(penjualanDetails)
			},
			success: function(response) {
				var result = JSON.parse(response);
				if (result.status === 'success') {
					updateDetailsTable();
					console.log('Session updated successfully');
				} else {
					//remove array penjualanDetails ada 2(splice). yg satunya di controller
					var lastIndex = penjualanDetails.length - 1;
					penjualanDetails.splice(lastIndex, 1);

					$.ajax({
						type: 'POST',
						url: '<?php echo Yii::app()->createUrl("penjualan/updateSessionPenjualanDetails"); ?>',
						data: {
							penjualanDetails: JSON.stringify(penjualanDetails)
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
					alert(result.message);
					$('.flash-error').html(result.message).show();
					setTimeout(function() {
						$('.flash-error').fadeOut('slow');
					}, 4000); // Fade out the message
				}
			},
			error: function() {
				console.error('AJAX request failed');
			}
		});
	};

	//document.getElementById('add-detail-btn').addEventListener('click', addDetailFunction);

	document.getElementById('add-detail-btn').addEventListener('click', function() {
		addDetailFunction();

		// Using jQuery since Yii typically includes it
		$('#Penjualan_Customer_ID')
			.prop('readonly', true)
			.addClass('disabled-dropdown')
			.trigger('change'); // Trigger change event if needed

		// If you need to prevent the form from submitting
		return false;
	});

	window.removeDetail = function(index) {
		penjualanDetails.splice(index, 1);

		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("penjualan/updateSessionPenjualanDetails"); ?>',
			data: {
				penjualanDetails: JSON.stringify(penjualanDetails)
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

	function printContent() {
		var printContents = document.getElementById('printArea').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;

		document.getElementById('add-detail-btn').addEventListener('click', addDetailFunction);

	}

	updateDetailsTable();

	document.getElementById('PenjualanDetail_MasterBarang_ID').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});

	document.getElementById('PenjualanDetail_Satuan_ID').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});

	document.getElementById('PenjualanDetail_Jumlah').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});

	document.getElementById('PenjualanDetail_Harga').addEventListener('keydown', function(event) {
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

				var satuanDropdown = $('#PenjualanDetail_Satuan_ID');
				satuanDropdown.empty();
				Object.keys(satuanData).forEach(function(key) {
					satuanDropdown.append($('<option>', {
						value: key,
						text: satuanData[key]
					}));
				});

				var penjualanDari = $('#PenjualanDetail_Penjualan_Dari').val();
				var customer_id = $('#Penjualan_Customer_ID').val();
				updateHarga(customer_id, masterbarang_id, penjualanDari, '');

			}
		});
	}

	function updateHarga(customer_id, masterbarang_id, penjualanDari, satuan) {
		$.ajax({
			type: 'GET',
			url: '<?php echo Yii::app()->createUrl("masterBarang/getHarga"); ?>',
			data: {
				customer_id: customer_id,
				masterbarang_id: masterbarang_id,
				penjualanDari: penjualanDari,
				satuan: satuan
			},
			success: function(data) {
				$('#PenjualanDetail_Harga').val(data);
				$('#PenjualanDetail_Harga').prop('readonly', true);
			}
		});
	}

	function formatInput(id) {
		document.getElementById(id).addEventListener('input', function(event) {
			let input = event.target.value.replace(/[^\d]/g, '');
			input = Number(input).toLocaleString('id-ID');
			event.target.value = input;
		});
	}

	function truncateString(str, firstPartLength, lastPartLength) {
		// Get the first part of the string
		var firstPart = str.substring(0, firstPartLength);

		// Get the last part of the string
		var lastPart = str.substring(str.length - lastPartLength);

		// Combine the first part, the ellipsis, and the last part
		return firstPart + "...." + lastPart;
	}
</script>