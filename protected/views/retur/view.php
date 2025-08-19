<h1><?php echo $model->TipeRetur; ?></h1>
<h2><?php echo Yii::app()->formatter->formatDate($model->Tanggal); ?></h2>


<?php

if ($model->TipeRetur === "PENJUALAN") {
  $Returdetail = Returdetail::model()->findAllByAttributes(array(
    'Retur_ID' => $model->Retur_ID
  ));
?>

  <table class="table table-bordered" id="details-table">
    <thead>
      <tr class="bg-info">
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Satuan</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($Returdetail as $detail) {
        $modulDetail = Penjualandetail::model()->findByAttributes(array(
          'PenjualanDetail_ID' => $detail->ModulDetail_ID
        ));

        echo "<tr>
        <td>" . $modulDetail->masterBarang->Nama . "</td>
        <td>" . $detail->Jumlah . "</td>
        <td>" . $detail->satuan->Satuan . "</td>
        </tr>";
      }
      ?>

    </tbody>
  </table>

<?php
} else {
?>

  <?php
  $Returdetail = Returdetail::model()->findAllByAttributes(array(
    'Retur_ID' => $model->Retur_ID
  ));
  ?>
  <table class="table table-bordered" id="details-table">
    <thead>
      <tr class="bg-info">
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Satuan</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($Returdetail as $detail) {
      $modulDetail = Pembeliandetail::model()->findByAttributes(array(
        'PembelianDetail_ID' => $detail->ModulDetail_ID
      ));

      echo "<tr>
        <td>" . $modulDetail->barang->masterbarang->Nama . "</td>
        <td>" . $detail->Jumlah . "</td>
        <td>" . $detail->satuan->Satuan . "</td>
        </tr>";
    }
  }
    ?>
    </tbody>
  </table>