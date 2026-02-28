<?php $title = 'Master Data Peserta Aktif';
include 'header.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold"><i class="fas fa-users mr-1"></i> Database Mahasiswa
                    Terverifikasi</h3>
                <div class="card-tools">
                    <a href="/admin/export_json" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-download mr-1"></i> Ekspor Data JSON
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0 text-sm">
                    <thead class="bg-light">
                        <tr>
                            <th>Identitas Peserta</th>
                            <th>Info Kontak & Kelas</th>
                            <th class="text-center">Kuesioner Selesai</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada mahasiswa yang diverifikasi.
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($students as $s): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <?php if ($s['foto']): ?>
                                                <img src="/uploads/profile/<?= $s['foto'] ?>" class="rounded-circle shadow-sm"
                                                    style="width:40px; height:40px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-gray rounded-circle"
                                                    style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark"><?= htmlspecialchars($s['nama']) ?>
                                            </div>
                                            <div class="text-xs text-muted">NPM: <?= htmlspecialchars($s['npm']) ?></div>
                                            <div class="text-xs text-muted"><i class="fas fa-calendar-alt mr-1"></i> Daftar:
                                                <?= date('d/m/Y', strtotime($s['created_at'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-xs">
                                        <div class="mb-1"><i class="fas fa-chalkboard text-muted mr-1"></i>
                                            <?= htmlspecialchars($s['kelas'] ?? '-') ?></div>
                                        <div class="mb-1"><i class="fas fa-phone text-muted mr-1"></i>
                                            <?= htmlspecialchars($s['no_hp'] ?? '-') ?></div>
                                        <div><i class="fas fa-envelope text-muted mr-1"></i>
                                            <?= htmlspecialchars($s['email'] ?? '-') ?></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-block p-1 text-center" style="min-width: 60px;">
                                        <div class="badge badge-primary mb-1">VARK</div><br>
                                        <div class="text-dark font-weight-bold mb-1"><?= $s['vark_type'] ?: '-' ?></div>
                                        <small
                                            class="text-xs text-muted"><?= $s['vark_updated_at'] ? date('d/m/y', strtotime($s['vark_updated_at'])) : '<span class="text-danger">Belum</span>' ?></small>
                                    </div>
                                    <div class="d-inline-block p-1 text-center border-left border-right"
                                        style="min-width: 70px;">
                                        <div class="badge badge-info mb-1">MSLQ</div><br>
                                        <div class="text-dark font-weight-bold mb-1">
                                            <?= $s['mslq_score'] ? number_format($s['mslq_score'], 2) : '-' ?>
                                        </div>
                                        <small
                                            class="text-xs text-muted"><?= $s['mslq_updated_at'] ? date('d/m/y', strtotime($s['mslq_updated_at'])) : '<span class="text-danger">Belum</span>' ?></small>
                                    </div>
                                    <div class="d-inline-block p-1 text-center" style="min-width: 60px;">
                                        <div class="badge badge-success mb-1">AMS</div><br>
                                        <div class="text-dark font-weight-bold mb-1 text-capitalize">
                                            <?= $s['ams_type'] ?: '-' ?>
                                        </div>
                                        <small
                                            class="text-xs text-muted"><?= $s['ams_updated_at'] ? date('d/m/y', strtotime($s['ams_updated_at'])) : '<span class="text-danger">Belum</span>' ?></small>
                                    </div>
                                </td>
                                <td class="text-right align-middle">
                                    <div class="btn-group">
                                        <a href="/admin/edit_student/<?= $s['id'] ?>" class="btn btn-xs btn-outline-primary"
                                            title="Edit Data"><i class="fas fa-edit"></i></a>
                                        <button type="button" class="btn btn-xs btn-outline-danger"
                                            onclick="confirmDelete(<?= $s['id'] ?>, '<?= addslashes($s['nama']) ?>')"
                                            title="Hapus Mahasiswa"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-top">
                <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Data mahasiswa aktif digunakan sebagai
                    basis data pengambilan sampel riset POINTMARKET.</small>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Mahasiswa?',
            text: "Seluruh data kuesioner " + name + " juga akan terhapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/delete_student/' + id;
            }
        })
    }
</script>

<?php include 'footer.php'; ?>