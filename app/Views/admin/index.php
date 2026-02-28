<?php include 'header.php'; ?>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info shadow-sm border">
            <div class="inner">
                <h3>
                    <?= $total ?>
                </h3>
                <p>Total Mahasiswa</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="/admin/students" class="small-box-footer">Lihat Detail <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning shadow-sm border">
            <div class="inner">
                <h3>
                    <?= $pending ?>
                </h3>
                <p>Menunggu Verifikasi</p>
            </div>
            <div class="icon"><i class="fas fa-user-clock"></i></div>
            <a href="/admin/approvals" class="small-box-footer">Verifikasi Sekarang <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- VARK Summary Boxes -->
<h5 class="mb-2 mt-4 font-weight-bold"><i class="fas fa-eye mr-1"></i> Ringkasan Gaya Belajar (VARK)</h5>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary shadow-sm">
            <div class="inner">
                <h3><?= $vark_summary['Visual'] ?></h3>
                <p>Visual (V)</p>
            </div>
            <div class="icon"><i class="fas fa-eye"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3><?= $vark_summary['Aural'] ?></h3>
                <p>Aural (A)</p>
            </div>
            <div class="icon"><i class="fas fa-headphones"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3><?= $vark_summary['Read/Write'] ?></h3>
                <p>Read/Write (R)</p>
            </div>
            <div class="icon"><i class="fas fa-book"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3><?= $vark_summary['Kinesthetic'] ?></h3>
                <p>Kinesthetic (K)</p>
            </div>
            <div class="icon"><i class="fas fa-running"></i></div>
        </div>
    </div>
</div>

<!-- AMS & MSLQ Summary Boxes -->
<h5 class="mb-2 mt-4 font-weight-bold"><i class="fas fa-brain mr-1"></i> Ringkasan Motivasi (AMS) & Evaluasi (MSLQ)</h5>
<div class="row">
    <div class="col-lg-2 col-6">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3><?= $ams_summary['Intrinsic'] ?></h3>
                <p>Intrinsic</p>
            </div>
            <div class="icon"><i class="fas fa-heart"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-secondary shadow-sm">
            <div class="inner">
                <h3><?= $ams_summary['Extrinsic'] ?></h3>
                <p>Extrinsic</p>
            </div>
            <div class="icon"><i class="fas fa-external-link-alt"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-indigo shadow-sm" style="background-color: #6610f2 !important; color: white;">
            <div class="inner">
                <h3><?= $ams_summary['Achievement'] ?></h3>
                <p>Achievement</p>
            </div>
            <div class="icon"><i class="fas fa-trophy"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-dark shadow-sm">
            <div class="inner">
                <h3><?= $ams_summary['Amotivation'] ?></h3>
                <p>Amotivation</p>
            </div>
            <div class="icon"><i class="fas fa-user-slash"></i></div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="small-box bg-purple shadow-sm" style="background-color: #6f42c1 !important; color: white;">
            <div class="inner">
                <h3><?= $mslq_overall_avg ?> <small>/ 7.0</small></h3>
                <p>Rata-rata Skor MSLQ Global</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-calendar-alt mr-1"></i> Timeline & Ringkasan
                    Sistem</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Instrumen</th>
                            <th class="text-center">Status</th>
                            <th>Terakhir Dibuka</th>
                            <th>Terakhir Ditutup</th>
                            <th class="text-primary">Estimasi Buka Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $labels = ['vark_open' => 'VARK', 'mslq_open' => 'MSLQ', 'ams_open' => 'AMS'];
                        foreach ($settings as $s):
                            if (!isset($labels[$s['setting_key']]))
                                continue;

                            // Hitung Estimasi Buka Kembali
                            $nextOpen = '-';
                            if ($s['next_open_at']) {
                                $nextOpen = date('d M Y', strtotime($s['next_open_at']));
                            } elseif ($s['opened_at']) {
                                $opened = new DateTime($s['opened_at']);
                                if ($s['setting_key'] == 'vark_open') {
                                    $opened->modify('+16 weeks');
                                } else {
                                    $opened->modify('+4 weeks');
                                }
                                $nextOpen = $opened->format('d M Y');
                            }
                            ?>
                            <tr>
                                <td class="font-weight-bold"><?= $labels[$s['setting_key']] ?> Assessment</td>
                                <td class="text-center">
                                    <?= $s['setting_value'] ? '<span class="badge badge-success">TERBUKA</span>' : '<span class="badge badge-danger">TERTUTUP</span>' ?>
                                </td>
                                <td><?= $s['opened_at'] ? date('d M Y, H:i', strtotime($s['opened_at'])) : '<span class="text-muted italic">--</span>' ?>
                                </td>
                                <td><?= $s['closed_at'] ? date('d M Y, H:i', strtotime($s['closed_at'])) : '<span class="text-muted italic">--</span>' ?>
                                </td>
                                <td class="font-weight-bold text-primary"><?= $nextOpen ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- VARK & AMS Distribution -->
    <div class="col-md-6">
        <div class="card card-outline card-info shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-chart-pie mr-1"></i> Distribusi Kuesioner
                    (Keseluruhan)</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="varkChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        <p class="text-center mt-2 mb-0 small text-muted font-weight-bold">Gaya Belajar (VARK)</p>
                    </div>
                    <div class="col-md-6">
                        <canvas id="amsChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        <p class="text-center mt-2 mb-0 small text-muted font-weight-bold">Motivasi (AMS)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MSLQ Average Progress -->
    <div class="col-md-6">
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-chart-line mr-1"></i> Rata-rata Skor MSLQ
                    (Progress)</h3>
            </div>
            <div class="card-body">
                <canvas id="mslqChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Activity Chart -->
    <div class="col-md-12">
        <div class="card card-outline card-dark shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-bolt mr-1"></i> Aktivitas Pengisian (30 Hari
                    Terakhir)</h3>
            </div>
            <div class="card-body">
                <canvas id="activityChart"
                    style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Student Progress Tracking Table -->
    <div class="col-md-12" id="progress-table">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold"><i class="fas fa-history mr-1"></i> Log Perkembangan Mahasiswa
                    (Terbaru)</h3>
                <div class="card-tools">
                    <span class="badge badge-primary">20 Aktivitas Terakhir</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-valign-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Mahasiswa</th>
                                <th>NPM</th>
                                <th>Kelas</th>
                                <th>Kuesioner</th>
                                <th>Hasil/Skor</th>
                                <th>Tanggal Pengisian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_history)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat pengisian
                                        kuesioner.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_history as $log): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 mr-2"
                                                    style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user-graduate text-muted small"></i>
                                                </div>
                                                <span
                                                    class="font-weight-bold text-dark"><?= htmlspecialchars($log['nama']) ?></span>
                                            </div>
                                        </td>
                                        <td><code><?= htmlspecialchars($log['npm']) ?></code></td>
                                        <td><span
                                                class="badge badge-secondary"><?= htmlspecialchars($log['class_name'] ?? 'Unclassed') ?></span>
                                        </td>
                                        <td>
                                            <?php
                                            $badgeClass = 'badge-primary';
                                            if ($log['quiz_type'] == 'MSLQ')
                                                $badgeClass = 'badge-info';
                                            if ($log['quiz_type'] == 'AMS')
                                                $badgeClass = 'badge-success';
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= $log['quiz_type'] ?></span>
                                        </td>
                                        <td>
                                            <?php if ($log['quiz_type'] == 'MSLQ'): ?>
                                                <span class="font-weight-bold text-info"><?= $log['result_label'] ?></span>
                                                <small class="text-muted">/ 7.0</small>
                                            <?php else: ?>
                                                <span
                                                    class="text-dark font-weight-bold text-capitalize"><?= $log['result_label'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-muted small">
                                            <i
                                                class="far fa-clock mr-1"></i><?= date('d M Y, H:i', strtotime($log['submitted_at'])) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Data di atas menunjukkan riwayat
                    perubahan status belajar mahasiswa secara real-time.</small>

                <?php if ($history_pages > 0): ?>
                    <ul class="pagination pagination-sm m-0">
                        <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $current_page - 1 ?>#progress-table">&laquo;</a>
                        </li>
                        <?php
                        $start = max(1, $current_page - 2);
                        $end = min($history_pages, $start + 4);
                        if ($end - $start < 4)
                            $start = max(1, $end - 4);

                        for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>#progress-table"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $current_page >= $history_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $current_page + 1 ?>#progress-table">&raquo;</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function () {
        // VARK Chart
        const varkData = <?= json_encode($vark_dist) ?>;
        new Chart(document.getElementById('varkChart'), {
            type: 'doughnut',
            data: {
                labels: varkData.map(d => d.label),
                datasets: [{
                    data: varkData.map(d => d.value),
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8']
                }]
            },
            options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });

        // AMS Chart
        const amsData = <?= json_encode($ams_dist) ?>;
        new Chart(document.getElementById('amsChart'), {
            type: 'pie',
            data: {
                labels: amsData.map(d => d.label),
                datasets: [{
                    data: amsData.map(d => d.value),
                    backgroundColor: ['#6f42c1', '#fd7e14', '#e83e8c']
                }]
            },
            options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });

        // MSLQ Progress Chart
        const mslqData = <?= json_encode($mslq_avg) ?>;
        new Chart(document.getElementById('mslqChart'), {
            type: 'line',
            data: {
                labels: mslqData.map(d => d.label),
                datasets: [{
                    label: 'Rata-rata Skor',
                    data: mslqData.map(d => d.value),
                    borderColor: '#28a745',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true, max: 7 } } }
        });

        // Activity Chart
        const actData = <?= json_encode($activity) ?>;
        new Chart(document.getElementById('activityChart'), {
            type: 'bar',
            data: {
                labels: actData.map(d => d.label),
                datasets: [{
                    label: 'Jumlah Pengisian',
                    data: actData.map(d => d.value),
                    backgroundColor: '#343a40'
                }]
            },
            options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    }
</script>

<?php include 'footer.php'; ?>