<?php if ($model): ?>
    <b>Pembelian Tanggal: <?php echo $model->Tanggal; ?></b>
    <h5>Detail:</h5>
    <table class="table table-bordered" id="details-table">
        <thead>
            <tr class="bg-info">
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($mOperasionaldetail as $detail) {
                echo "<tr>" .
                    "<td>" . $detail->Nama . "</td>" .
                    "<td>" . $detail->Jumlah . "</td>" .
                    "<td>" . Helper::formatRupiah( ($detail->Total/ $detail->Jumlah) ) . "</td>" .
                    "<td>" . Helper::formatRupiah($detail->Total) . "</td>" .
                    "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No data available.</p>
<?php endif; ?>