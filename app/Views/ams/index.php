<?php include '../app/Views/layout/header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-graduation-cap mr-1"></i> Bagian 3: Academic Motivation Scale
                    (AMS)</h3>
            </div>
            <div class="card-body">
                <div class="progress mb-4" style="height: 25px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100">Tahap Akhir: 100%</div>
                </div>

                <div class="alert alert-light border mb-4">
                    <p class="mb-0">Pilihlah skala yang paling sesuai: <strong>1 (Tidak sesuai sama sekali)</strong>
                        sampai <strong>7 (Sesuai sepenuhnya)</strong>.</p>
                </div>

                <form id="ams-form" action="/ams/submit" method="POST">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered shadow-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3">Alasan Belajar</th>
                                    <th class="text-center py-3" style="width: 400px;">Kesesuaian Diri (Skala 1-7)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                shuffle($questions); // Randomize AMS questions
                                foreach ($questions as $q):
                                    ?>
                                    <tr>
                                        <td class="align-middle py-3 text-dark font-weight-500">
                                            <?= htmlspecialchars($q['teks_pertanyaan']) ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex justify-content-between px-2">
                                                <?php for ($i = 1; $i <= 7; $i++): ?>
                                                    <div class="custom-control custom-radio mx-2">
                                                        <input class="custom-control-input custom-control-input-success"
                                                            type="radio" id="ams_<?= $q['id'] ?>_<?= $i ?>"
                                                            name="answers[<?= $q['id'] ?>]" value="<?= $i ?>" required>
                                                        <label for="ams_<?= $q['id'] ?>_<?= $i ?>"
                                                            class="custom-control-label font-weight-bold"
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
                        <button type="button" onclick="confirmSubmit('ams')"
                            class="btn btn-success btn-lg shadow px-5 font-weight-bold" style="border-radius: 50px;">
                            FINISH & LIHAT HASIL <i class="fas fa-flag-checkered ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<style>
    .font-weight-500 {
        font-weight: 500;
    }
</style>

<?php include '../app/Views/layout/footer.php'; ?>