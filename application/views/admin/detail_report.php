<div class="container-fluid">
    <?php if (isset($reports[0]->name)): ?>
        <h1 class="h3 mb-2 text-gray-800">DETAIL REPORT UNIT <?= $reports[0]->name ?></h1>
    <?php endif; ?>
    <div class="card shadow mb-4">
        <div class="card-body py-3">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalJumlah = 0;
                    foreach ($reports as $report):
                        if ($report->tipe == 'masuk') {
                            $totalJumlah += $report->jumlah;
                        } elseif ($report->tipe == 'keluar') {
                            $totalJumlah -= $report->jumlah;
                        }
                        ?>
                        <tr>
                            <td><?= format_date_with_day($report->tanggal) ?></td>
                            <td><b> <?= $report->keterangan ?></b></td>
                            <td><?= $report->tipe ?></td>
                            <td><?= ($report->tipe == 'keluar' ? '-' : '') . rupiah($report->jumlah) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                        <td><strong><?= rupiah($totalJumlah) ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>