<?php include '../app/Views/layout/header.php'; ?>

<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="mb-3">
                        <?php if (isset($user['foto']) && $user['foto']): ?>
                            <img src="/uploads/profile/<?= $user['foto'] ?>"
                                class="profile-user-img img-fluid img-circle shadow-sm"
                                style="width: 100px; height: 100px; object-fit: cover;" alt="User Profile">
                        <?php else: ?>
                            <div class="bg-primary d-inline-block rounded-circle p-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-graduate fa-3x"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <h3 class="profile-username text-center">
                    <?= htmlspecialchars($user['nama']) ?>
                </h3>
                <p class="text-muted text-center">NPM:
                    <?= htmlspecialchars($user['npm']) ?>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Status Akun</b> <a class="float-right text-success"><i class="fas fa-check-circle mr-1"></i>
                            Terverifikasi</a>
                    </li>
                    <li class="list-group-item">
                        <b>Terdaftar Sejak</b> <a class="float-right text-muted small">
                            <?= date('d M Y', strtotime($user['created_at'])) ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Activity Log Card -->
        <div class="card card-outline card-secondary shadow-sm mt-3" id="activity-log">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-history mr-1"></i> Log Aktivitas</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush small">
                    <?php if (empty($activity_log)): ?>
                        <li class="list-group-item text-muted text-center py-3">Belum ada aktivitas tercatat.</li>
                    <?php else: ?>
                        <?php foreach ($activity_log as $log): ?>
                            <li class="list-group-item px-3 py-2">
                                <div class="d-flex justify-content-between">
                                    <span class="font-weight-bold"><?= $log['quiz_type'] ?> Assessment</span>
                                    <span class="text-muted"
                                        style="font-size: 0.75rem;"><?= date('d/m/y H:i', strtotime($log['submitted_at'])) ?></span>
                                </div>
                                <div class="text-muted">
                                    Hasil: <span
                                        class="badge <?= $log['quiz_type'] == 'VARK' ? 'badge-primary' : ($log['quiz_type'] == 'MSLQ' ? 'badge-info' : 'badge-success') ?>"><?= $log['result_label'] ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <?php if ($log_pages > 0): ?>
                <div class="card-footer bg-white py-2">
                    <ul class="pagination pagination-sm m-0 justify-content-center">
                        <li class="page-item <?= $current_log_page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?log_page=<?= $current_log_page - 1 ?>#activity-log">&laquo;</a>
                        </li>
                        <?php for ($i = 1; $i <= $log_pages; $i++): ?>
                            <li class="page-item <?= $i == $current_log_page ? 'active' : '' ?>">
                                <a class="page-link" href="?log_page=<?= $i ?>#activity-log"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $current_log_page >= $log_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?log_page=<?= $current_log_page + 1 ?>#activity-log">&raquo;</a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Questionnaire Status -->
    <div class="col-md-8">
        <div class="card card-dark card-outline shadow-sm">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold"><i class="fas fa-tasks mr-1"></i> Status Kuesioner Saya</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-valign-middle">
                    <?php
                    // Helper untuk menghitung estimasi buka kembali
                    function getNextOpen($schedule, $key, $interval_weeks)
                    {
                        if (!empty($schedule[$key]['next_open_at'])) {
                            return date('d M Y', strtotime($schedule[$key]['next_open_at']));
                        } elseif (!empty($schedule[$key]['opened_at'])) {
                            $d = new DateTime($schedule[$key]['opened_at']);
                            $d->modify('+' . $interval_weeks . ' weeks');
                            return $d->format('d M Y');
                        }
                        return '-';
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>Kuesioner</th>
                            <th>Periode</th>
                            <th>Status Terakhir</th>
                            <th>Buka Kembali</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- VARK -->
                        <tr>
                            <td><i class="fas fa-book text-primary mr-2"></i> VARK Assessment</td>
                            <td>1x Per Semester</td>
                            <td>
                                <?php if ($vark_status == 'active'): ?>
                                    <span class="badge badge-success">Selesai
                                        (<?= date('d/m/Y', strtotime($user['vark_updated_at'])) ?>)</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Belum/Perlu Ulang</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $nextVark = getNextOpen($quiz_schedule, 'vark_open', 16); ?>
                                <?php if ($nextVark != '-'): ?>
                                    <small class="text-primary font-weight-bold">
                                        <i class="fas fa-calendar-alt mr-1"></i><?= $nextVark ?>
                                    </small>
                                <?php else: ?>
                                    <small class="text-muted">-</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($vark_status != 'active'): ?>
                                    <a href="/vark" class="btn btn-xs btn-primary shadow-sm px-3">Mulai</a>
                                <?php else: ?>
                                    <button class="btn btn-xs btn-outline-secondary disabled"
                                        title="Sudah dilakukan semester ini">Done</button>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- MSLQ -->
                        <tr>
                            <td><i class="fas fa-brain text-info mr-2"></i> MSLQ Evaluation</td>
                            <td>Bulanan</td>
                            <td>
                                <?php if ($mslq_status == 'active'): ?>
                                    <span class="badge badge-success">Selesai
                                        (<?= date('d/m/Y', strtotime($user['mslq_updated_at'])) ?>)</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Belum/Perlu Ulang</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $nextMslq = getNextOpen($quiz_schedule, 'mslq_open', 4); ?>
                                <?php if ($nextMslq != '-'): ?>
                                    <small class="text-info font-weight-bold">
                                        <i class="fas fa-calendar-alt mr-1"></i><?= $nextMslq ?>
                                    </small>
                                <?php else: ?>
                                    <small class="text-muted">-</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($mslq_status != 'active'): ?>
                                    <a href="/mslq" class="btn btn-xs btn-info shadow-sm px-3">Mulai</a>
                                <?php else: ?>
                                    <button class="btn btn-xs btn-outline-secondary disabled">Done</button>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- AMS -->
                        <tr>
                            <td><i class="fas fa-graduation-cap text-success mr-2"></i> AMS Motivation</td>
                            <td>Bulanan</td>
                            <td>
                                <?php if ($ams_status == 'active'): ?>
                                    <span class="badge badge-success">Selesai
                                        (<?= date('d/m/Y', strtotime($user['ams_updated_at'])) ?>)</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Belum/Perlu Ulang</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $nextAms = getNextOpen($quiz_schedule, 'ams_open', 4); ?>
                                <?php if ($nextAms != '-'): ?>
                                    <small class="text-success font-weight-bold">
                                        <i class="fas fa-calendar-alt mr-1"></i><?= $nextAms ?>
                                    </small>
                                <?php else: ?>
                                    <small class="text-muted">-</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($ams_status != 'active'): ?>
                                    <a href="/ams" class="btn btn-xs btn-success shadow-sm px-3">Mulai</a>
                                <?php else: ?>
                                    <button class="btn btn-xs btn-outline-secondary disabled">Done</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light py-2">
                <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Kuesioner bulanan membantu kami
                    mengukur perkembangan belajar Anda secara berkala.</small>
            </div>
        </div>

        <!-- Latest Results Summary -->
        <?php if ($user['vark_type'] || $user['mslq_score'] || $user['ams_type']): ?>
            <div class="card shadow-sm border-top border-primary">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-chart-pie mr-1"></i> Ringkasan Profil Belajar
                        Terakhir</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase d-block mb-1">Gaya Belajar</small>
                            <h4 class="font-weight-bold text-primary">
                                <?= $user['vark_type'] ?: '-' ?>
                            </h4>
                        </div>
                        <div class="col-md-4 border-left border-right">
                            <small class="text-muted text-uppercase d-block mb-1">Skor MSLQ</small>
                            <h4 class="font-weight-bold text-info">
                                <?= $user['mslq_score'] ?: '-' ?>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase d-block mb-1">Kategori AMS</small>
                            <h4 class="font-weight-bold text-success text-capitalize">
                                <?= $user['ams_type'] ?: '-' ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- Learning Progress Chart -->
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-chart-line mr-1"></i> Perkembangan Skor MSLQ
                    Saya</h3>
            </div>
            <div class="card-body">
                <?php if (empty($mslq_history)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada riwayat pengisian MSLQ. Silakan mulai kuesioner untuk melihat
                            perkembangan Anda.</p>
                    </div>
                <?php else: ?>
                    <canvas id="studentProgressChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    <div class="mt-3 text-center">
                        <span class="badge badge-success mr-2"><i class="fas fa-circle mr-1"></i> Skor Anda</span>
                        <span class="badge badge-secondary"><i class="fas fa-circle mr-1"></i> Rata-rata Global
                            (<?= $mslq_global_avg ?>)</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function () {
        const historyData = <?= json_encode($mslq_history) ?>;
        const globalAvg = <?= $mslq_global_avg ?>;

        if (historyData.length > 0) {
            new Chart(document.getElementById('studentProgressChart'), {
                type: 'line',
                data: {
                    labels: historyData.map(d => d.label),
                    datasets: [
                        {
                            label: 'Skor Saya',
                            data: historyData.map(d => d.value),
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.1)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 5,
                            pointHoverRadius: 8
                        },
                        {
                            label: 'Rata-rata Global',
                            data: Array(historyData.length).fill(globalAvg),
                            borderColor: '#6c757d',
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 7,
                            title: { display: true, text: 'Skor (1-7)' }
                        },
                        x: {
                            title: { display: true, text: 'Tanggal Pengisian' }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    }
</script>

<?php include '../app/Views/layout/footer.php'; ?>