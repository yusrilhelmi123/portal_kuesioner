<?php include 'header.php'; ?>

<div class="row">
    <div class="col-md-6">
        <div class="card card-warning card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Informasi Kelas</h3>
            </div>
            <form action="/admin/update_class" method="POST">
                <input type="hidden" name="id" value="<?= $class['id'] ?>">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="class_name" class="form-control"
                            value="<?= htmlspecialchars($class['class_name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi / Informasi Tambahan</label>
                        <textarea name="description" class="form-control"
                            rows="4"><?= htmlspecialchars($class['description'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="card-footer bg-light text-right">
                    <a href="/admin/classes" class="btn btn-default mr-2">Batal</a>
                    <button type="submit" class="btn btn-warning px-4 shadow-sm text-dark font-weight-bold">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-info"><i class="fas fa-info-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tip Pengelolaan</span>
                <span class="info-box-number">Ubah nama kelas dengan hati-hati jika kelas sudah memiliki mahasiswa
                    aktif.</span>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>