<style>
  .modal {
    left: auto !important;
    right: auto !important;
    margin-left: auto !important;
    margin: auto !important;
    -ms-flex-align: center !important;
    align-items: center !important;
  }
</style>

<div class="form">

  <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'retur-form',
    'enableAjaxValidation' => false,
  )); ?>

  <p class="note">Fields with <span class="required">*</span> are required.</p>

  <?php if ($model->hasErrors()): ?>
    <div class="flash-error">
      <?php echo $form->errorSummary($model); ?>
    </div>
  <?php endif; ?>

  <div class="card-body">
    <div class="row">
      <div class="col-sm-6">
        <?php echo $form->labelEx($model, 'Tanggal'); ?>
        <?php echo $form->dateField($model, 'Tanggal', array('class' => 'form-control date-picker', 'readonly' => 'readonly')); ?>
        <?php echo $form->error($model, 'Tanggal'); ?>
      </div>
      <div class="col-sm-6">
        <?php echo $form->labelEx($model, 'TipeRetur'); ?>
        <div class="input-group">
          <?php echo $form->dropDownList(
            $model,
            'TipeRetur',
            array('PENJUALAN' => 'Penjualan', 'PEMBELIAN' => 'Pembelian'),
            array('prompt' => 'Select Retur', 'class' => 'form-control', 'id' => 'Retur_Tipe_Retur')
          );
          ?>
          <div class="input-group-append">
            <?php
            echo CHtml::button('Search', array(
              'id' => 'btnSearch',
              'class' => 'btn btn-primary',
              'onclick' => 'openModal(this); return false;',
              'data-url' => Yii::app()->createUrl("retur/getData", array("TipeRetur" => $model->TipeRetur)),
            ));
            ?>
          </div>
        </div>
        <?php echo $form->error($model, 'TipeRetur'); ?>
      </div>
    </div>

    <div id="selectedDetails">
      <?php
      $selectedItems = isset(Yii::app()->session['selectedItems']) ?
        Yii::app()->session['selectedItems'] : array();

      if (!empty($selectedItems)):
      ?>
        <table class="table table-bordered">
          <thead>
            <tr class="bg-info">
              <th>Nama Barang</th>
              <th>Jumlah</th>
              <th>Satuan</th>
              <th>HargaOffline</th>
              <th>HargaGrosir</th>
              <th>HargaTokped</th>
              <th>Alasan</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($selectedItems as $index => $item): ?>
              <tr>
                <td><?php echo CHtml::encode($item['Nama']); ?></td>
                <td>
                  <?php echo CHtml::numberField(
                    "selectedItems[$index][Jumlah]",
                    $item['Jumlah'],
                    array('min' => 0, 'class' => 'form-control')
                  ); ?>
                </td>
                <td><?php echo CHtml::encode($item['SatuanNama']); ?></td>
                <td><?php echo CHtml::encode($item['HargaOffline']); ?></td>
                <td><?php echo CHtml::encode($item['HargaGrosir']); ?></td>
                <td><?php echo CHtml::encode($item['HargaTokped']); ?></td>
                <td>
                  <?php echo CHtml::textField(
                    "selectedItems[$index][Alasan]",
                    $item['Alasan'],
                    array('class' => 'form-control')
                  ); ?>
                </td>
              </tr>
              <?php
              echo CHtml::hiddenField("selectedItems[$index][PembelianDetail_ID]", $item['PembelianDetail_ID']);
              echo CHtml::hiddenField("selectedItems[$index][Barang_ID]", $item['Barang_ID']);
              echo CHtml::hiddenField("selectedItems[$index][Nama]", $item['Nama']);
              echo CHtml::hiddenField("selectedItems[$index][Satuan_ID]", $item['Satuan_ID']);
              echo CHtml::hiddenField("selectedItems[$index][SatuanNama]", $item['SatuanNama']);
              echo CHtml::hiddenField("selectedItems[$index][Harga]", $item['Harga']);
              echo CHtml::hiddenField("selectedItems[$index][HargaOffline]", $item['HargaOffline']);
              echo CHtml::hiddenField("selectedItems[$index][HargaGrosir]", $item['HargaGrosir']);
              echo CHtml::hiddenField("selectedItems[$index][HargaTokped]", $item['HargaTokped']);
              echo CHtml::hiddenField("selectedItems[$index][Penjualan_Dari]", $item['Penjualan_Dari']);

              ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <div class="row buttons">
      <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- form -->

<!-- Modal -->
<div class="modal fade" id="dataModal" style="display: none; width:70% !important;" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="dataModalLabel">Detail</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body" id="dataContent">
    </div>
  </div>
</div>



<script>
  $(document).ready(function() {
    // Trigger search if items exist on page load
    <?php if (!empty($selectedItems)): ?>
      $('#selectedDetails').show();
    <?php endif; ?>
  });

  function openModal(button) {
    var url = $(button).attr('data-url'); // Get the correct URL from data attribute

    $('#dataContent').html('<p>Loading...</p>'); // Show loading while request

    $.ajax({
      url: url,
      type: 'GET',
      data: {
        TipeRetur: $("#Retur_Tipe_Retur").val()
      },
      success: function(data) {
        $('#dataContent').html(data);
        $('#dataModal').modal('show');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error loading data: ' + textStatus, errorThrown);
        $('#dataContent').html('<p>Error loading data.</p>');
      }
    });
  }

  function searchData() {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var tipeRetur = $("#Retur_Tipe_Retur").val();

    $.ajax({
      url: '<?php echo Yii::app()->createUrl('retur/getData'); ?>',
      type: 'GET',
      data: {
        TipeRetur: tipeRetur,
        startDate: startDate,
        endDate: endDate
      },
      success: function(data) {
        $('#dataContent').html(data);
      }
    });
  }

  function saveSelected() {
    var selectedItems = [];
    $('#details-table .item-checkbox:checked').each(function() {
      var row = $(this).closest('tr');
      var item = {
        PembelianDetail_ID: $(this).data('detail-id'),
        Nama: row.find('[data-field="Nama"]').text().trim(),
        Jumlah: row.find('[data-field="Jumlah"]').text().trim(),
        SatuanNama: row.find('[data-field="SatuanNama"]').text().trim(),
        Harga: row.find('[data-field="Harga"]').text().trim(),
        HargaOffline: row.find('[data-field="HargaOffline"]').text().trim(),
        HargaGrosir: row.find('[data-field="HargaGrosir"]').text().trim(),
        HargaTokped: row.find('[data-field="HargaTokped"]').text().trim(),
        Satuan_ID: row.find('[data-field="Satuan_ID"]').text().trim(),
        Barang_ID: row.find('[data-field="Barang_ID"]').text().trim(),
        Penjualan_Dari: row.find('[data-field="Penjualan_Dari"]').text().trim(),
        Alasan: ''
      };
      selectedItems.push(item);
    });

    $('#Retur_Tipe_Retur').prop('disabled', true);

    // Save to session via AJAX
    $.ajax({
      url: '<?php echo Yii::app()->createUrl('retur/saveSelectedItems'); ?>',
      type: 'POST',
      data: {
        items: JSON.stringify(selectedItems)
      },
      success: function(response) {
        $('#dataModal').modal('hide');
        // Reload the selected items display
        $.ajax({
          url: '<?php echo Yii::app()->createUrl('retur/loadSelectedItems'); ?>',
          type: 'GET',
          success: function(html) {
            $('#selectedDetails').html(html);
          }
        });
      }
    });
  }
</script>