<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'operasional-form',
		'enableAjaxValidation' => false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="card-body">
		<div class="form-group">
			<?php echo $form->labelEx($model, 'Tanggal'); ?>
			<?php echo $form->dateField($model, 'Tanggal', array('class' => 'form-control')); ?>
			<?php echo $form->error($model, 'Tanggal'); ?>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="nama">Item Name</label>
					<?php echo $form->textField($mOperasionalDtl, 'Nama', array('class' => 'form-control')); ?>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label for="jumlah">Jumlah Item</label>
					<?php echo $form->textField($mOperasionalDtl, 'Jumlah', array('class' => 'form-control')); ?>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label for="Total">Total</label>
					<?php echo $form->textField($mOperasionalDtl, 'Total', array('class' => 'form-control')); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="button" class="btn btn-primary" id="add-detail-btn">Add Detail</button>
		</div>

		<table class="table table-bordered" id="details-table">
			<thead>
				<tr class="bg-info">
					<th>Item Name</th>
					<th>Jumlah Item</th>
					<th>Harga Satuan</th>
					<th>Total</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		<div class="form-group pt-3">
			<button type="submit" class="btn btn-success">Save</button>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div><!-- form -->

<script>
	document.addEventListener('DOMContentLoaded', function() {
		updateDetailsTable();
	});

	var operasionalDetails = <?php echo json_encode(Yii::app()->session['operasionalDetails'] ?? []); ?>;

	if (!Array.isArray(operasionalDetails)) {
		operasionalDetails = [];
	}

	function formatPrice(value) {
		return Number(value).toLocaleString('id-ID');
	}

	function updateDetailsTable() {
		var tbody = document.querySelector('#details-table tbody');
		tbody.innerHTML = '';

		if (operasionalDetails.length === 0) {
			var noDataRow = document.createElement('tr');
			noDataRow.innerHTML = '<td colspan="6" style="text-align: left;">No data</td>';
			tbody.appendChild(noDataRow);
		} else {
			operasionalDetails.forEach(function(detail, index) {
				var row = document.createElement('tr');
				row.innerHTML = `
					<td><input type="text" class="form-control" value="${detail.nama}" onchange="updateField(${index}, 'nama', this.value)"></td> 
					<td><input type="text" class="form-control" value="${detail.jumlah}" onchange="updateField(${index}, 'jumlah', this.value)"></td> 
					<td>${formatPrice(detail.hargaSatuan)}</td> 
					<td><input type="text" class="form-control" value="${formatPrice(detail.total)}" onchange="updateField(${index}, 'total', this.value.replace(/,/g, ''))"></td> 

					<td><button type="button" class="btn btn-danger" onclick="removeDetail(${index})">Remove</button></td>
            	`;
				tbody.appendChild(row);
			});
		}
	}

	function updateField(index, field, value) {

		if (field === 'jumlah' || field === 'total') {
			value = parseFloat(value);
			if (isNaN(value)) {
				value = 0;
				alert(field.charAt(0).toUpperCase() + field.slice(1) + ' must be numbers');
			}
			operasionalDetails[index].hargaSatuan = operasionalDetails[index].total / operasionalDetails[index].jumlah;
		}
		operasionalDetails[index][field] = value;

		console.log(JSON.stringify(operasionalDetails));

		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("operasional/updateSessionOperasionalDetails"); ?>',
			data: {
				operasionalDetails: JSON.stringify(operasionalDetails)
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

	}

	document.getElementById('add-detail-btn').addEventListener('click', function() {
		var nama = document.getElementById('Operasionaldetail_Nama').value;
		var jumlah = document.getElementById('Operasionaldetail_Jumlah').value;
		var hargaSatuan = 0;
		var total = document.getElementById('Operasionaldetail_Total').value.replace(/[^\d]/g, '');

		if (!nama || !jumlah || !total) {
			alert('Please fill all fields');
			return;
		}

		if (isNaN(jumlah) || isNaN(total)) {
			alert('Jumlah and Total must be numbers');
			return;
		}

		operasionalDetails.push({
			nama: nama,
			jumlah: jumlah,
			hargaSatuan: total / jumlah,
			total: total
		});
		//console.log(JSON.stringify(operasionalDetails));
		updateDetailsTable();

		//clear value
		document.querySelector('[id="Operasionaldetail_Nama"]').value = "";
		document.querySelector('[id="Operasionaldetail_Jumlah"]').value = "";
		document.querySelector('[id="Operasionaldetail_Total"]').value = "";

		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("operasional/updateSessionOperasionalDetails"); ?>',
			data: {
				operasionalDetails: JSON.stringify(operasionalDetails)
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
		operasionalDetails.splice(index, 1);

		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("operasional/updateSessionOperasionalDetails"); ?>',
			data: {
				operasionalDetails: JSON.stringify(operasionalDetails)
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

	document.getElementById('Operasionaldetail_Nama').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});
	document.getElementById('Operasionaldetail_Jumlah').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});
	document.getElementById('Operasionaldetail_Total').addEventListener('keydown', function(event) {
		if (event.key === 'Enter') {
			event.preventDefault();
			document.getElementById('add-detail-btn').click();
		}
	});
	document.getElementById('Operasionaldetail_Total').addEventListener('input', function(event) {
		let input = event.target.value.replace(/[^\d]/g, '');
		// Remove non-digit characters 
		input = Number(input).toLocaleString('id-ID');
		// Format as Indonesian Rupiah 
		event.target.value = input;
	});
</script>