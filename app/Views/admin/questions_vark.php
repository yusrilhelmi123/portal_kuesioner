<?php include 'header.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="callout callout-warning shadow-sm border-left-3 bg-white">
            <h5 class="text-warning font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Disclaimer</h5>
            <p class="mb-0 text-muted">Seluruh butir pertanyaan dan pilihan jawaban dalam bank soal ini wajib disusun,
                divalidasi, dan ditinjau secara berkala berdasarkan <strong>Expert Judgment (Pertimbangan
                    Ahli)</strong>. Hal ini diperlukan untuk menjamin validitas isi dan reliabilitas instrumen riset
                dalam mengidentifikasi profil psikometrik mahasiswa secara akurat.</p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <h3 class="card-title font-weight-bold text-primary"><i class="fas fa-calculator mr-1"></i>
                        Metodologi Perhitungan VARK</h3>
                </div>
                <div class="card-body py-3">
                    <p class="text-sm text-muted mb-0">Hasil akhir ditentukan menggunakan <strong>Metode Frekuensi
                            Tertinggi (Mode)</strong>. Sistem akan menghitung jumlah jawaban pada masing-masing
                        modalitas (V/A/R/K). Mahasiswa akan diklasifikasikan ke dalam tipe gaya belajar yang memiliki
                        jumlah pilihan terbanyak di antara keempat kategori tersebut.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Tambah / Edit Soal</h3>
                </div>
                <form action="/admin/vark" method="POST">
                    <div class="card-body">
                        <input type="hidden" name="id" id="q_id">
                        <div class="form-group">
                            <label>Pertanyaan</label>
                            <textarea name="teks_pertanyaan" id="q_teks" class="form-control" rows="3"
                                required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group"><label>Opsi V</label><input type="text" name="opt_v" id="q_v"
                                        class="form-control" required></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><label>Opsi A</label><input type="text" name="opt_a" id="q_a"
                                        class="form-control" required></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><label>Opsi R</label><input type="text" name="opt_r" id="q_r"
                                        class="form-control" required></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><label>Opsi K</label><input type="text" name="opt_k" id="q_k"
                                        class="form-control" required></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Soal</button>
                        <button type="button" class="btn btn-default float-right" onclick="resetForm()">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-database mr-1"></i> Bank Soal VARK</h3>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-valign-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">ID</th>
                                <th>Pertanyaan & Opsi Jawaban</th>
                                <th class="text-right" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions as $q): ?>
                                <tr>
                                    <td><span class="badge badge-secondary">#<?= $q['id'] ?></span></td>
                                    <td>
                                        <div class="font-weight-bold mb-2"><?= htmlspecialchars($q['teks_pertanyaan']) ?>
                                        </div>
                                        <div class="row no-gutters">
                                            <div class="col-6 small text-muted"><span
                                                    class="badge badge-outline-primary mr-1">V</span>
                                                <?= htmlspecialchars(substr($q['opt_v'], 0, 50)) ?>...</div>
                                            <div class="col-6 small text-muted"><span
                                                    class="badge badge-outline-success mr-1">A</span>
                                                <?= htmlspecialchars(substr($q['opt_a'], 0, 50)) ?>...</div>
                                            <div class="col-6 small text-muted"><span
                                                    class="badge badge-outline-warning mr-1">R</span>
                                                <?= htmlspecialchars(substr($q['opt_r'], 0, 50)) ?>...</div>
                                            <div class="col-6 small text-muted"><span
                                                    class="badge badge-outline-danger mr-1">K</span>
                                                <?= htmlspecialchars(substr($q['opt_k'], 0, 50)) ?>...</div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-info" onclick='editQ(<?= json_encode($q) ?>)'
                                                title="Edit Soal"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete(<?= $q['id'] ?>)" title="Hapus"><i
                                                    class="fas fa-trash"></i></button>
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
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Soal?',
                text: "Soal ini akan dihapus secara permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/admin/delete_question/vark/' + id;
                }
            })
        }

        function editQ(q) {
            $('#q_id').val(q.id);
            $('#q_teks').val(q.teks_pertanyaan);
            $('#q_v').val(q.opt_v);
            $('#q_a').val(q.opt_a);
            $('#q_r').val(q.opt_r);
            $('#q_k').val(q.opt_k);
            $('.card-title').first().text('Edit Soal #' + q.id);
        }
        function resetForm() {
            $('#q_id').val('');
            $('#q_teks').val('');
            $('#q_v').val(''); $('#q_a').val(''); $('#q_r').val(''); $('#q_k').val('');
            $('.card-title').first().text('Tambah / Edit Soal');
        }
    </script>

    <style>
        .badge-outline-primary {
            color: #007bff;
            border: 1px solid #007bff;
            background: transparent;
        }

        .badge-outline-success {
            color: #28a745;
            border: 1px solid #28a745;
            background: transparent;
        }

        .badge-outline-warning {
            color: #ffc107;
            border: 1px solid #ffc107;
            background: transparent;
        }

        .badge-outline-danger {
            color: #dc3545;
            border: 1px solid #dc3545;
            background: transparent;
        }
    </style>

    <?php include 'footer.php'; ?>