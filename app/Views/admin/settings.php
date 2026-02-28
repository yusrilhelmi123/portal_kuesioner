<?php $title = 'Logistik & Kontrol Waktu';
include 'header.php'; ?>

<div class="row">
    <div class="col-md-9">
        <div class="card card-dark shadow-sm">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold"><i class="fas fa-clock mr-1"></i> Penjadwalan & Status Instrumen
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-valign-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Nama Instrumen</th>
                            <th>Target Frekuensi</th>
                            <th class="text-center">Status Akses</th>
                            <th>Rencana Buka Kembali</th>
                            <th class="text-right">Aksi Toggle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $labels = [
                            'vark_open' => ['title' => 'VARK (Learning Styles)', 'freq' => '1x Setiap Semester'],
                            'mslq_open' => ['title' => 'MSLQ (Strategy)', 'freq' => 'Setiap Bulan'],
                            'ams_open' => ['title' => 'AMS (Motivation)', 'freq' => 'Setiap Bulan']
                        ];
                        foreach ($settings as $s):
                            if (!isset($labels[$s['setting_key']]))
                                continue;
                            $info = $labels[$s['setting_key']];
                            $isOpen = (bool) $s['setting_value'];
                            ?>
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-dark"><?= $info['title'] ?></div>
                                    <small class="text-muted"><?= $s['setting_key'] ?></small>
                                </td>
                                <td><span class="badge badge-secondary"><?= $info['freq'] ?></span></td>
                                <td class="text-center">
                                    <?php if ($isOpen): ?>
                                        <span class="badge badge-success px-3 py-2"><i class="fas fa-unlock mr-1"></i>
                                            TERBUKA</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger px-3 py-2"><i class="fas fa-lock mr-1"></i>
                                            TERTUTUP</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="/admin/settings" method="POST" class="form-inline">
                                        <input type="hidden" name="update_next_open" value="<?= $s['setting_key'] ?>">
                                        <div class="input-group input-group-sm">
                                            <input type="date" name="next_open_at" class="form-control form-control-sm" 
                                                   value="<?= $s['next_open_at'] ?>" style="width: 130px;">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary" title="Update Rencana Buka">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <small class="text-muted d-block mt-1">Status diubah: <?= date('d/m/Y H:i', strtotime($s['updated_at'])) ?></small>
                                </td>
                                <td class="text-right">
                                    <form action="/admin/settings" method="POST" style="display:inline;"
                                        id="form-<?= $s['setting_key'] ?>">
                                        <input type="hidden" name="toggle_key" value="<?= $s['setting_key'] ?>">
                                        <input type="hidden" name="<?= $s['setting_key'] ?>" value="<?= $isOpen ? 0 : 1 ?>">
                                        <?php if ($isOpen): ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger shadow-xs px-3"
                                                onclick="confirmClose('<?= $s['setting_key'] ?>', '<?= $info['title'] ?>')">Tutup
                                                Akses</button>
<?php else: ?>
                                            <button type="submit" class="btn btn-sm btn-success shadow-xs px-3">Buka
                                                Akses</button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light py-2">
                <p class="mb-0 small text-muted">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Pastikan jadwal pembukaan kuesioner sesuai dengan timeline riset POINTMARKET.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Info -->
    <div class="col-md-3">
        <div class="info-box shadow-sm mb-3">
            <span class="info-box-icon bg-info"><i class="fas fa-calendar-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Bulan Aktif</span>
                <span class="info-box-number"><?= date('F Y') ?></span>
            </div>
        </div>
        <div class="alert alert-warning shadow-sm">
            <h5><i class="icon fas fa-bullhorn"></i> Aturan Main</h5>
            <small>
                VARK diukur sekali per semester (Feb-Jul / Agt-Jan).
                MSLQ & AMS diukur setiap bulan untuk memantau fluktuasi motivasi mahasiswa.
            </small>
        </div>
    </div>
</div>

<script>
    function confirmClose(key, title) {
        Swal.fire({
            title: 'Konfirmasi Penutupan',
            text: "Apakah Anda yakin ingin menutup akses untuk instrumen " + title + "? Mahasiswa tidak akan bisa mengisi kuesioner ini lagi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Tutup Akses!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-' + key).submit();
            }
        })
    }
</script>

<?php include 'footer.php'; ?>