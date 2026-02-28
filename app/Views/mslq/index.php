<?php include '../app/Views/layout/header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-brain mr-1"></i> Bagian 2: MSLQ (Motivated Strategies for
                    Learning)</h3>
            </div>
            <div class="card-body">
                <div class="progress mb-4" style="height: 25px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 66%;" aria-valuenow="66"
                        aria-valuemin="0" aria-valuemax="100">Progres: 66%</div>
                </div>

                <div class="alert alert-light border mb-4">
                    <p class="mb-0">Berikan penilaian dari <strong>1 (Sangat Tidak Setuju)</strong> hingga <strong>7
                            (Sangat Setuju)</strong> sesuai dengan kondisi belajar Anda.</p>
                </div>

                <form id="mslq-form" action="/mslq/submit" method="POST">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered shadow-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3">Aspek Pertanyaan</th>
                                    <th class="text-center py-3" style="width: 400px;">Internalisasi Diri (Skala 1-7)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                shuffle($questions); // Randomize MSLQ questions
                                foreach ($questions as $q):
                                    ?>
                                    <tr>
                                        <td class="align-middle py-3">
                                            <p class="mb-1 font-weight-bold text-dark">
                                                <?= htmlspecialchars($q['teks_pertanyaan']) ?>
                                            </p>
                                            <span
                                                class="badge badge-pill badge-light border text-muted px-3"><?= htmlspecialchars($q['dimensi']) ?></span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex justify-content-between px-2">
                                                <?php for ($i = 1; $i <= 7; $i++): ?>
                                                    <div class="custom-control custom-radio mx-1">
                                                        <input class="custom-control-input" type="radio"
                                                            id="mslq_<?= $q['id'] ?>_<?= $i ?>" name="answers[<?= $q['id'] ?>]"
                                                            value="<?= $i ?>" required>
                                                        <label for="mslq_<?= $q['id'] ?>_<?= $i ?>"
                                                            class="custom-control-label text-xs font-weight-bold"
                                                            style="cursor:pointer;"><?= $i ?></label>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5 mb-3 text-right">
                        <button type="button" onclick="confirmSubmit('mslq')"
                            class="btn btn-info btn-lg shadow px-5 font-weight-bold" style="border-radius: 50px;">
                            SELESAIKAN MSLQ <i class="fas fa-check-circle ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include '../app/Views/layout/footer.php'; ?>