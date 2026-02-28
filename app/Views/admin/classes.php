<?php include 'header.php'; ?>

<div class="row">
    <div class="col-md-5">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Tambah Kelas Baru</h3>
            </div>
            <form action="/admin/add_class" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="class_name" class="form-control" placeholder="Misal: IF-4A" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi / Informasi Tambahan</label>
                        <textarea name="description" class="form-control" rows="3"
                            placeholder="Misal: Semester Genap 2026, Prodi Teknik Informatika"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold"><i class="fas fa-list mr-1"></i> Daftar Kelas Tersedia</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Deskripsi Pelengkap</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($classes)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada data kelas.</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($classes as $i => $c): ?>
                            <tr>
                                <td>
                                    <?= $i + 1 ?>
                                </td>
                                <td class="font-weight-bold text-dark">
                                    <?= htmlspecialchars($c['class_name']) ?>
                                </td>
                                <td class="small text-muted">
                                    <?= htmlspecialchars($c['description'] ?? '-') ?>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <a href="/admin/edit_class/<?= $c['id'] ?>" class="btn btn-xs btn-outline-primary"
                                            title="Edit Kelas">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-xs btn-outline-danger" title="Hapus Kelas"
                                            onclick="confirmDelete(<?= $c['id'] ?>, '<?= addslashes($c['class_name']) ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
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
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Kelas?',
            text: "Anda akan menghapus kelas " + name + ". Perubahan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/delete_class/' + id;
            }
        })
    }
</script>

<?php include 'footer.php'; ?>