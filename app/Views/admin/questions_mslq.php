<?php include 'header.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="callout callout-warning shadow-sm bg-white">
            <h5 class="text-warning font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Disclaimer</h5>
            <p class="mb-0 text-muted">Butir-butir pertanyaan MSLQ ini wajib didasarkan pada instrumen baku yang
                divalidasi dengan <strong>Expert Judgment</strong> untuk menjamin akurasi pengukuran strategi belajar
                mandiri mahasiswa.</p>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="card card-outline card-info shadow-sm h-100">
            <div class="card-header border-0 pb-0">
                <h3 class="card-title font-weight-bold text-info"><i class="fas fa-calculator mr-1"></i> Metodologi
                    Perhitungan MSLQ</h3>
            </div>
            <div class="card-body py-3">
                <p class="text-sm text-muted mb-0">Skor akhir MSLQ dihitung menggunakan <strong>Rata-rata Global
                        (Mean)</strong> dari seluruh butir pertanyaan yang dijawab (Skala 1-7). Skor ini
                    merepresentasikan tingkat strategi kognitif dan motivasi belajar mahasiswa secara umum. Skor yang
                    lebih tinggi (mendekati 7.0) menunjukkan kemandirian belajar yang lebih baik.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card card-info shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Tambah / Edit Soal MSLQ</h3>
            </div>
            <form action="/admin/mslq" method="POST">
                <div class="card-body">
                    <input type="hidden" name="id" id="q_id">
                    <div class="form-group">
                        <label>Teks Pertanyaan</label>
                        <textarea name="teks_pertanyaan" id="q_teks" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Dimensi / Kategori</label>
                        <select name="dimensi" id="q_dimensi" class="form-control" required>
                            <option value="">-- Pilih Dimensi --</option>
                            <optgroup label="Motivasi">
                                <option value="Intrinsic Goal Orientation">Intrinsic Goal Orientation</option>
                                <option value="Extrinsic Goal Orientation">Extrinsic Goal Orientation</option>
                                <option value="Task Value">Task Value</option>
                                <option value="Control of Learning Beliefs">Control of Learning Beliefs</option>
                                <option value="Self-Efficacy for Learning">Self-Efficacy for Learning</option>
                                <option value="Test Anxiety">Test Anxiety</option>
                            </optgroup>
                            <optgroup label="Strategi Belajar">
                                <option value="Rehearsal">Rehearsal (Pengulangan)</option>
                                <option value="Elaboration">Elaboration (Elaborasi)</option>
                                <option value="Organization">Organization (Organisasi)</option>
                                <option value="Critical Thinking">Critical Thinking</option>
                                <option value="Metacognitive Self-Regulation">Metacognitive Self-Regulation</option>
                                <option value="Time and Study Environment">Time and Study Environment</option>
                                <option value="Effort Regulation">Effort Regulation</option>
                                <option value="Peer Learning">Peer Learning</option>
                                <option value="Help Seeking">Help Seeking</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Simpan Soal</button>
                    <button type="button" class="btn btn-default float-right" onclick="resetForm()">Reset</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title">Daftar Bank Soal MSLQ</h3>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="10%">ID</th>
                            <th>Pertanyaan</th>
                            <th>Dimensi</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($questions as $q): ?>
                            <tr>
                                <td>#
                                    <?= $q['id'] ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($q['teks_pertanyaan']) ?>
                                </td>
                                <td><span class="badge badge-info">
                                        <?= htmlspecialchars($q['dimensi']) ?>
                                    </span></td>
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
            title: 'Hapus Soal MSLQ?',
            text: "Soal ini akan dihapus secara permanen dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/delete_question/mslq/' + id;
            }
        })
    }

    function editQ(q) {
        $('#q_id').val(q.id);
        $('#q_teks').val(q.teks_pertanyaan);
        $('#q_dimensi').val(q.dimensi);
        $('.card-title').first().text('Edit Soal #' + q.id);
    }
    function resetForm() {
        $('#q_id').val('');
        $('#q_teks').val('');
        $('#q_dimensi').val('');
        $('.card-title').first().text('Tambah / Edit Soal MSLQ');
    }
</script>

<?php include 'footer.php'; ?>