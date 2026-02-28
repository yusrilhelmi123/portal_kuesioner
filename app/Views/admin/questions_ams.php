<?php include 'header.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="callout callout-warning shadow-sm bg-white">
            <h5 class="text-warning font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Disclaimer</h5>
            <p class="mb-0 text-muted">Kategori dan butir pertanyaan AMS harus disusun berdasarkan landasan teori
                motivasi yang kuat dan divalidasi oleh <strong>Ahli (Expert)</strong> untuk memastikan reliabilitas
                hasil klasifikasi.</p>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="card card-outline card-success shadow-sm h-100">
            <div class="card-header border-0 pb-0">
                <h3 class="card-title font-weight-bold text-success"><i class="fas fa-calculator mr-1"></i> Metodologi
                    Perhitungan AMS</h3>
            </div>
            <div class="card-body py-3">
                <p class="text-sm text-muted mb-0">Klasifikasi tipe motivasi AMS ditentukan dengan membandingkan
                    <strong>Rata-rata Skor (Mean)</strong> untuk setiap kategori (Intrinsic, Extrinsic, Achievement,
                    Amotivation). Mahasiswa akan diklasifikasikan ke dalam kategori yang memiliki nilai rata-rata
                    tertinggi sebagai <strong>Profil Motivasi Utama</strong> mereka.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card card-success shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Tambah / Edit Soal AMS</h3>
            </div>
            <form action="/admin/ams" method="POST">
                <div class="card-body">
                    <input type="hidden" name="id" id="q_id">
                    <div class="form-group">
                        <label>Teks Pertanyaan</label>
                        <textarea name="teks_pertanyaan" id="q_teks" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kategori Motivasi</label>
                        <select name="kategori" id="q_kategori" class="form-control" required>
                            <option value="intrinsic">Intrinsic</option>
                            <option value="extrinsic">Extrinsic</option>
                            <option value="achievement">Achievement</option>
                            <option value="amotivation">Amotivation</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan Soal</button>
                    <button type="button" class="btn btn-default float-right" onclick="resetForm()">Reset</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title">Daftar Bank Soal AMS</h3>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="10%">ID</th>
                            <th>Pertanyaan</th>
                            <th>Kategori</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($questions as $q): ?>
                            <tr>
                                <td>#<?= $q['id'] ?></td>
                                <td><?= htmlspecialchars($q['teks_pertanyaan']) ?></td>
                                <td><span class="badge badge-success"
                                        style="text-transform:capitalize;"><?= htmlspecialchars($q['kategori']) ?></span>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-info" onclick='editQ(<?= json_encode($q) ?>)'><i
                                            class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-xs btn-danger"
                                        onclick="confirmDelete(<?= $q['id'] ?>)"><i class="fas fa-trash"></i></button>
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
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Soal AMS?',
            text: "Soal ini akan dihapus secara permanen dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/delete_question/ams/' + id;
            }
        })
    }

    function editQ(q) {
        $('#q_id').val(q.id);
        $('#q_teks').val(q.teks_pertanyaan);
        $('#q_kategori').val(q.kategori);
        $('.card-title').first().text('Edit Soal #' + q.id);
    }
    function resetForm() {
        $('#q_id').val('');
        $('#q_teks').val('');
        $('#q_kategori').val('intrinsic');
        $('.card-title').first().text('Tambah / Edit Soal AMS');
    }
</script>

<?php include 'footer.php'; ?>