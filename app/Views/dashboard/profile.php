<?php include '../app/Views/layout/header.php'; ?>

<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">
                <div class="mb-3">
                    <?php if (isset($user['foto']) && $user['foto']): ?>
                        <img src="/uploads/profile/<?= $user['foto'] ?>" class="profile-user-img img-fluid img-circle"
                            style="width: 150px; height: 150px; object-fit: cover;" alt="User profile picture">
                    <?php else: ?>
                        <div class="bg-gray p-4 d-inline-block rounded-circle"
                            style="width: 150px; height: 150px; line-height: 80px;">
                            <i class="fas fa-user fa-5x"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h3 class="profile-username font-weight-bold">
                    <?= htmlspecialchars($user['nama']) ?>
                </h3>
                <p class="text-muted">
                    <?= htmlspecialchars($user['npm']) ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Hasil Kuesioner Section -->
        <?php if ($user['vark_type'] || $user['mslq_score'] || $user['ams_type']): ?>
            <div class="card card-success card-outline mb-4 shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold ml-1"><i class="fas fa-poll mr-2"></i> Hasil Kuesioner Saya</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Instrumen Kuesioner</th>
                                <th class="text-center">Hasil/Skor</th>
                                <th class="text-right pr-4">Tanggal Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($user['vark_type']): ?>
                                <tr>
                                    <td class="align-middle"><i class="fas fa-eye text-primary mr-2"></i> <strong>VARK</strong>
                                        (Gaya Belajar)</td>
                                    <td class="text-center align-middle"><span class="badge badge-primary px-3 py-2"
                                            style="font-size: 0.9rem;"><?= $user['vark_type'] ?></span></td>
                                    <td class="text-right align-middle text-muted small pr-4">
                                        <?= date('d M Y, H:i', strtotime($user['vark_updated_at'])) ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($user['mslq_score']): ?>
                                <tr>
                                    <td class="align-middle"><i class="fas fa-brain text-info mr-2"></i> <strong>MSLQ</strong>
                                        (Strategi Belajar)</td>
                                    <td class="text-center align-middle text-info font-weight-bold" style="font-size: 1.1rem;">
                                        <?= number_format($user['mslq_score'], 1) ?>
                                    </td>
                                    <td class="text-right align-middle text-muted small pr-4">
                                        <?= date('d M Y, H:i', strtotime($user['mslq_updated_at'])) ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($user['ams_type']): ?>
                                <tr>
                                    <td class="align-middle"><i class="fas fa-flag text-success mr-2"></i> <strong>AMS</strong>
                                        (Motivasi Akademik)</td>
                                    <td class="text-center align-middle text-success text-capitalize font-weight-bold">
                                        <?= $user['ams_type'] ?>
                                    </td>
                                    <td class="text-right align-middle text-muted small pr-4">
                                        <?= date('d M Y, H:i', strtotime($user['ams_updated_at'])) ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white py-2">
                    <small class="text-muted italic"><i class="fas fa-info-circle mr-1"></i> Hasil ini dihitung secara
                        otomatis berdasarkan respon terbaru Anda.</small>
                </div>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h3 class="card-title font-weight-bold"><i class="fas fa-id-card mr-2"></i> Lengkapi Data Diri</h3>
            </div>
            <form action="/dashboard/update" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control"
                                    value="<?= htmlspecialchars($user['nama']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas</label>
                                <select name="kelas" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($classes as $c): ?>
                                        <option value="<?= $c['class_name'] ?>" <?= (isset($user['kelas']) && $user['kelas'] == $c['class_name']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c['class_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor HP (WhatsApp)</label>
                                <input type="text" name="no_hp" class="form-control"
                                    value="<?= htmlspecialchars($user['no_hp'] ?? '') ?>" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="nama@email.com">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ganti Password <small class="text-muted">(Kosongkan jika tidak
                                        ganti)</small></label>
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unggah Foto Profil</label>
                                <div class="custom-file">
                                    <input type="file" name="foto" class="custom-file-input" id="customFile"
                                        accept="image/*">
                                    <label class="custom-file-label" for="customFile">Pilih Gambar...</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save mr-1"></i> Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Update filename label in custom-file-input
    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>

<?php if (isset($_SESSION['quiz_success'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Terima Kasih!',
                html: 'Data kuesioner <strong><?= $_SESSION['quiz_success'] ?></strong> Anda telah berhasil disimpan dan diupdate.<br><br>Gunakan hasil ini sebagai panduan dalam proses pembelajaran Anda.',
                icon: 'success',
                confirmButtonText: 'OKE SIAP',
                confirmButtonColor: '#007bff'
            });
        });
    </script>
    <?php unset($_SESSION['quiz_success']); endif; ?>

<?php include '../app/Views/layout/footer.php'; ?>