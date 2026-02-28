<?php include '../app/Views/layout/header.php'; ?>

<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-8 text-center">
        <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
            <div class="card-body p-5">
                <div class="mb-4">
                    <div class="bg-light d-inline-block rounded-circle p-4 mb-3 shadow-sm">
                        <i
                            class="fas fa-lock fa-4x text-warning animate__animated animate__pulse animate__infinite"></i>
                    </div>
                </div>

                <h1 class="font-weight-bold text-dark mb-2">Akses Ditutup Sementara</h1>
                <p class="text-muted lead mb-4">Mohon maaf, instrumen kuesioner <strong>
                        <?= strtoupper($type) ?>
                    </strong> saat ini sedang tidak menerima respon baru.</p>

                <div class="alert alert-info border-0 shadow-sm text-left px-4 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x mr-3"></i>
                        <div>
                            <p class="mb-0 small font-weight-bold text-uppercase">Informasi Sistem:</p>
                            <p class="mb-0 small">Penutupan akses ini dilakukan secara periodik oleh Administrator atau
                                Pengelola Riset untuk kepentingan pemeliharaan data atau sinkronisasi instrumen.</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <a href="/dashboard" class="btn btn-primary px-5 py-2 shadow-sm mr-3">
                        <i class="fas fa-tachometer-alt mr-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
            <div class="card-footer bg-light py-3 border-0">
                <p class="text-muted mb-0 small">
                    <i class="fas fa-clock mr-1"></i> Status Terakhir: Terpantau oleh Sistem pada
                    <?= date('d M Y, H:i') ?>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .animate__pulse {
        animation: pulse 2s infinite ease-in-out;
    }
</style>

<?php include '../app/Views/layout/footer.php'; ?>