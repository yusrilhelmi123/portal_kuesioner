<?php include '../app/Views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card card-outline card-primary shadow-lg border-0">
            <div class="card-header bg-white py-4 border-0">
                <div class="text-center">
                    <div class="bg-primary d-inline-block rounded-circle p-3 mb-3 shadow-sm">
                        <?php
                        $icon = 'fa-poll-h';
                        $color = 'primary';
                        if ($type == 'vark') {
                            $icon = 'fa-book';
                            $title_long = 'VARK Learning Styles';
                        }
                        if ($type == 'mslq') {
                            $icon = 'fa-brain';
                            $title_long = 'Motivated Strategies for Learning (MSLQ)';
                            $color = 'info';
                        }
                        if ($type == 'ams') {
                            $icon = 'fa-graduation-cap';
                            $title_long = 'Academic Motivation Scale (AMS)';
                            $color = 'success';
                        }
                        ?>
                        <i class="fas <?= $icon ?> fa-3x"></i>
                    </div>
                    <h2 class="font-weight-bold text-dark">Selamat Datang di
                        <?= $title_long ?>
                    </h2>
                    <p class="text-muted lead">Mohon baca instruksi di bawah ini dengan saksama sebelum memulai.</p>
                </div>
            </div>

            <div class="card-body px-5 pb-5">
                <div class="bg-light rounded p-4 mb-4 border-left border-<?= $color ?>"
                    style="border-left-width: 5px !important;">
                    <h5 class="font-weight-bold"><i class="fas fa-info-circle mr-2"></i> Petunjuk Pengisian:</h5>
                    <ul class="mb-0 mt-3" style="line-height: 1.8;">
                        <li>Instrumen ini bertujuan untuk mengukur <strong>
                                <?= $type == 'vark' ? 'kecenderungan gaya belajar' : ($type == 'mslq' ? 'strategi belajar' : 'motivasi akademik') ?>
                            </strong> Anda.</li>
                        <li>Tidak ada jawaban benar atau salah. Jawaban terbaik adalah yang paling jujur menggambarkan
                            kondisi Anda.</li>
                        <li>Pilihlah jawaban yang paling sesuai dengan apa yang Anda rasakan atau lakukan dalam konteks
                            perkuliahan.</li>
                        <li>Pastikan Anda berada di lingkungan yang kondusif agar dapat berkonsentrasi penuh.</li>
                        <li>Waktu pengerjaan rata-rata adalah 10-15 menit.</li>
                    </ul>
                </div>

                <div class="row text-center mb-4">
                    <div class="col-md-4">
                        <div class="p-3">
                            <i class="fas fa-list-ol fa-2x text-muted mb-2"></i>
                            <p class="small mb-0 font-weight-bold">Estimasi Soal</p>
                            <span class="badge badge-<?= $color ?>">
                                <?= ($type == 'vark' ? '16' : ($type == 'mslq' ? '81' : '28')) ?> Pertanyaan
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 border-left border-right">
                        <div class="p-3">
                            <i class="fas fa-check-double fa-2x text-muted mb-2"></i>
                            <p class="small mb-0 font-weight-bold">Metode Jawaban</p>
                            <span class="badge badge-<?= $color ?>">Pilihan Ganda</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <i class="fas fa-save fa-2x text-muted mb-2"></i>
                            <p class="small mb-0 font-weight-bold">Penyimpanan</p>
                            <span class="badge badge-<?= $color ?>">Otomatis di Akhir</span>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <p class="text-muted small mb-4">Dengan menekan tombol di bawah, Anda menyatakan bersedia
                        berpartisipasi dalam riset ini secara sukarela.</p>
                    <a href="/<?= $type ?>/quiz"
                        class="btn btn-<?= $color ?> btn-lg px-5 shadow animate__animated animate__fadeInUp"
                        style="border-radius: 50px; font-weight: bold; letter-spacing: 1px;">
                        MULAI PENGISIAN <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../app/Views/layout/footer.php'; ?>