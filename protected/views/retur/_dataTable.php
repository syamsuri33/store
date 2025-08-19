  <div class="card card-info">
    <div class="card-header">
      <h3 class="card-title">Search</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
          <?php echo TbHtml::dateField('startDate', '', array('class' => 'form-control', 'id' => 'startDate')); ?>
        </div>
        <div class="col-sm-6">
          <?php echo TbHtml::dateField('endDate', '', array('class' => 'form-control', 'id' => 'endDate')); ?>
        </div>
      </div>
      <button class="btn btn-primary btn-large" type="button" onclick="searchData()">Search</button>
    </div>
  </div>

  <?php if ($TipeRetur == "PEMBELIAN"): ?>
    <table class="table table-bordered" id="details-table">
      <thead>
        <tr class="bg-info">
          <th>Select</th>
          <th>Nama Barang</th>
          <th>Jumlah</th>
          <th>Satuan</th>
          <th>Harga</th>
          <th>HargaOffline</th>
          <th>HargaGrosir</th>
          <th>HargaTokped</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($model as $detail): ?>
          <?php
          $isSelected = false;
          foreach ($selectedItems as $item) {
            if ($item['PembelianDetail_ID'] == $detail->PembelianDetail_ID) {
              $isSelected = true;
              break;
            }
          }
          ?>
          <tr>
            <td>
              <input type="checkbox" class="item-checkbox"
                <?php echo $isSelected ? 'checked' : ''; ?>
                data-detail-id="<?php echo $detail->PembelianDetail_ID; ?>">
            </td>
            <td data-field="Nama"><?php echo CHtml::encode($detail->barang->masterbarang->Nama); ?></td>
            <td data-field="Jumlah"><?php echo $detail->Jumlah; ?></td>
            <td data-field="SatuanNama"><?php echo CHtml::encode($detail->satuan->Satuan); ?></td>
            <td data-field="Harga"><?php echo $detail->Harga; ?></td>
            <td data-field="HargaOffline"><?php echo $detail->HargaOffline; ?></td>
            <td data-field="HargaGrosir"><?php echo $detail->HargaGrosir; ?></td>
            <td data-field="HargaTokped"><?php echo $detail->HargaTokped; ?></td>

            <!-- Hidden TDs for data we want to store but not display -->
            <td data-field="Satuan_ID" style="display:none"><?php echo $detail->Satuan_ID; ?></td>
            <td data-field="Barang_ID" style="display:none"><?php echo $detail->Barang_ID; ?></td>
            <td data-field="Penjualan_Dari" style="display:none"><?php echo ""; ?></td>

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <button class="btn btn-success" type="button" onclick="saveSelected()">Save</button>

  <?php elseif ($TipeRetur == "PENJUALAN"): ?>
    <table class="table table-bordered" id="details-table">
      <thead>
        <tr class="bg-info">
          <th>Select</th>
          <th>Nama Barang</th>
          <th>Jumlah</th>
          <th>Satuan</th>
          <th>Harga</th>
          <th>HargaOffline</th>
          <th>HargaGrosir</th>
          <th>HargaTokped</th>
          <th>Penjualan Dari</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($model as $detail): ?>
          <?php
          $isSelected = false;
          foreach ($selectedItems as $item) {
            if ($item['PembelianDetail_ID'] == $detail->PenjualanDetail_ID) {
              $isSelected = true;
              break;
            }
          }
          ?>
          <tr>
            <td>
              <input type="checkbox" class="item-checkbox"
                <?php echo $isSelected ? 'checked' : ''; ?>
                data-detail-id="<?php echo $detail->PenjualanDetail_ID; ?>">
            </td>
            <td data-field="Nama"><?php echo CHtml::encode($detail->masterBarang->Nama); ?></td>
            <td data-field="Jumlah"><?php echo $detail->Jumlah; ?></td>
            <td data-field="SatuanNama"><?php echo CHtml::encode($detail->satuan->Satuan); ?></td>
            <td data-field="Harga"><?php echo $detail->Harga; ?></td>
            <td data-field="HargaOffline"><?php echo $detail->HargaOffline; ?></td>
            <td data-field="HargaGrosir"><?php echo $detail->HargaGrosir; ?></td>
            <td data-field="HargaTokped"><?php echo $detail->HargaTokped; ?></td>
            <td data-field="Penjualan_Dari"><?php echo $detail->Penjualan_Dari; ?></td>

            <!-- Hidden TDs for data we want to store but not display -->
            <td data-field="Satuan_ID" style="display:none"><?php echo $detail->Satuan_ID; ?></td>
            <td data-field="Barang_ID" style="display:none"><?php echo $detail->MasterBarang_ID; ?></td>

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <button class="btn btn-success" type="button" onclick="saveSelected()">Save</button>

  <?php else : ?>
    <p>No data available.</p>
  <?php endif; ?>