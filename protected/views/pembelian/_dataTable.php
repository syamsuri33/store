<?php if ($model): ?>
    <b>Pembelian Tanggal: <?php echo Yii::app()->formatter->formatDate($model->Tanggal); ?></b>
    <h5>Detail:</h5>
    <table class="table table-bordered" id="details-table">
        <thead>
            <tr class="bg-info">
                <th>Barang</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Expired</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($mPembelianDetail as $detail) {
                echo "<tr>" .
                    "<td>" . $detail->barang->masterbarang->Nama . "</td>" .
                    "<td>" . $detail->satuan->Satuan . "</td>" .
                    "<td>" . $detail->Jumlah . "</td>" .
                    "<td>" . Helper::formatRupiah($detail->Harga) . "</td>" .
                    "<td>" . $detail->Diskon . "</td>" .
                    "<td>" . $detail->Expired . "</td>" .
                    "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No data available.</p>
<?php endif; ?>