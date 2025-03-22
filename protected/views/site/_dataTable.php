<?php if ($model): ?>
    <?php if ($dashboard == "totalBarang") { ?>
        <table class="table table-bordered" id="details-table">
            <thead>
                <tr class="bg-info">
                    <th>Barang</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($model as $detail) {
                    echo "<tr>" .
                        "<td>" . $detail->Nama . "</td>" .
                        "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php }elseif ($dashboard == "stokLimit") { ?>
        <table class="table table-bordered" id="details-table">
            <thead>
                <tr class="bg-info">
                    <th>Barang</th>
                    <th>Minimal Stok</th>
                    <th>Sisa Barang</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($model as $detail) {
                    echo "<tr>" .
                        "<td>" . $detail->Nama . "</td>" .
                        "<td>" . $detail->MinStok . "</td>" .
                        "<td>" . $detail->Keterangan . "</td>" .
                        "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php } else { ?>
        <table class="table table-bordered" id="details-table">
            <thead>
                <tr class="bg-info">
                    <th>Barang</th>
                    <th>Tanggal Expired</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($model as $detail) {
                    echo "<tr>" .
                        "<td>" . $detail->barang->masterbarang->Nama . "</td>" .
                        "<td>" . $detail->Expired . "</td>" .
                        "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php } ?>
<?php else: ?>
    <p>No data available.</p>
<?php endif; ?>