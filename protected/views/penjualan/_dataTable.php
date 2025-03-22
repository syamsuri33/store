<?php if ($model): ?>
    <b>Penjualan Tanggal: <?php echo $model->Tanggal; ?></b>
    <h5>Detail:</h5>
    <table class="table table-bordered" id="details-table">
        <thead>
            <tr class="bg-info">
                <th>Barang</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Penjualan Dari</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($mPenjualanDetail as $detail) {
                echo "<tr>" .
                    "<td>" . $detail->masterBarang->Nama . "</td>" .
                    "<td>" . $detail->satuan->Satuan . "</td>" .
                    "<td>" . $detail->Jumlah . "</td>" .
                    "<td>" . $detail->Harga . "</td>" .
                    "<td>" . $detail->Penjualan_Dari . "</td>" .
                    "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No data available.</p>
<?php endif; ?>