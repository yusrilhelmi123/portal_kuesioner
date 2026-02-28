<?php include 'header.php'; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold"><i class="fas fa-user-edit mr-2"></i> Form Edit Mahasiswa</h3>
            </div>
            <form action="/admin/update_student" method="POST">
                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control"
                                    value="<?= htmlspecialchars($s['nama']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NPM</label>
                                <input type="text" name="npm" class="form-control"
                                    value="<?= htmlspecialchars($s['npm']) ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kelas</label>
                                <select name="kelas" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($classes as $c): ?>
                                        <option value="<?= $c['class_name'] ?>" <?= (isset($s['kelas']) && $s['kelas'] == $c['class_name']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c['class_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="text" name="no_hp" class="form-control"
                                    value="<?= htmlspecialchars($s['no_hp'] ?? '') ?>" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?= htmlspecialchars($s['email'] ?? '') ?>" placeholder="nama@email.com">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ganti Password <small class="text-muted">(Kosongkan jika tidak ingin
                                mengubah)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="card-footer bg-light text-right">
                    <a href="/admin/students" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-outline card-info">
            <div class="card-body box-profile text-center">
                <div class="mb-3 text-center">
                    <?php if ($s['foto']): ?>
                        <img src="/uploads/profile/<?= $s['foto'] ?>" class="profile-user-img img-fluid img-circle"
                            style="width: 120px; height: 120px; object-fit: cover;" alt="User picture">
                    <?php else: ?>
                        <div class="bg-gray d-inline-block rounded-circle"
                            style="width: 120px; height: 120px; line-height: 120px;">
                            <i class="fas fa-user fa-4x"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h3 class="profile-username font-weight-bold">
                    <?= htmlspecialchars($s['nama']) ?>
                </h3>
                <p class="text-muted">
                    <?= htmlspecialchars($s['npm']) ?>
                </p>
                <hr>
                <div class="text-left small text-muted">
                    <b>Terdaftar:</b>
                    <?= date('d M Y, H:i', strtotime($s['created_at'])) ?><br>
                    <b>VARK:</b>
                    <?= $s['vark_updated_at'] ? date('d M Y', strtotime($s['vark_updated_at'])) : '-' ?><br>
                    <b>MSLQ:</b>
                    <?= $s['mslq_updated_at'] ? date('d M Y', strtotime($s['mslq_updated_at'])) : '-' ?><br>
                    <b>AMS:</b>
                    <?= $s['ams_updated_at'] ? date('d M Y', strtotime($s['ams_updated_at'])) : '-' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>