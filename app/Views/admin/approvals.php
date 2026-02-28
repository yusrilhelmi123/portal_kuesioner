<?php $title = 'Verifikasi Pendaftaran';
include 'header.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title">Daftar Antrean Mahasiswa Baru</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-valign-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Informasi Mahasiswa</th>
                            <th>Tanggal Registrasi</th>
                            <th class="text-right">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted small">Tidak ada antrean verifikasi saat
                                    ini.</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($students as $s): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle mr-3"
                                            style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">
                                                <?= htmlspecialchars($s['nama']) ?>
                                            </div>
                                            <div class="text-xs text-muted">NPM:
                                                <?= htmlspecialchars($s['npm']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="small text-muted">
                                    <?= $s['created_at'] ?>
                                </td>
                                <td class="text-right">
                                    <a href="/admin/approve/<?= $s['id'] ?>"
                                        class="btn btn-sm btn-success shadow-xs mr-2"><i class="fas fa-check mr-1"></i>
                                        Approve</a>
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="confirmReject(<?= $s['id'] ?>, '<?= addslashes($s['nama']) ?>')">
                                        <i class="fas fa-times"></i> Reject</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmReject(id, name) {
        Swal.fire({
            title: 'Tolak Pendaftaran?',
            text: "Pendaftaran atas nama " + name + " akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Tolak & Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/delete_student/' + id + '?ref=approvals';
            }
        })
    }
</script>

<?php include 'footer.php'; ?>