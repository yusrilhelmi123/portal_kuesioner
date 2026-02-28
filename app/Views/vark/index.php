<?php include '../app/Views/layout/header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit mr-1"></i> Bagian 1: VARK Assessment</h3>
            </div>
            <div class="card-body">
                <div class="progress mb-4" style="height: 25px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 33%;" aria-valuenow="33"
                        aria-valuemin="0" aria-valuemax="100">Progres: 33%</div>
                </div>

                <p class="text-muted mb-4">Silakan pilih satu opsi yang paling mewakili diri Anda dalam situasi berikut:
                </p>

                <form id="vark-form" action="/vark/submit" method="POST">
                    <?php
                    shuffle($questions); // Randomize question order
                    foreach ($questions as $index => $q):
                        ?>
                        <div class="callout callout-info mb-4 shadow-sm border-left-3">
                            <h5 class="mb-3 font-weight-bold text-dark"><?= ($index + 1) ?>.
                                <?= htmlspecialchars($q['teks_pertanyaan']) ?>
                            </h5>
                            <div class="row px-3">
                                <?php
                                $types = ['V', 'A', 'R', 'K'];
                                shuffle($types);
                                foreach ($types as $type):
                                    ?>
                                    <div class="col-md-6 mb-2">
                                        <div class="custom-control custom-radio hov-scale">
                                            <input class="custom-control-input" type="radio" id="q_<?= $q['id'] ?>_<?= $type ?>"
                                                name="answers[<?= $q['id'] ?>]" value="<?= $type ?>" required>
                                            <label for="q_<?= $q['id'] ?>_<?= $type ?>"
                                                class="custom-control-label font-weight-normal text-muted"
                                                style="cursor: pointer;">
                                                <?= htmlspecialchars($q['opt_' . strtolower($type)]) ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="card-footer bg-transparent p-0 mt-5 mb-3">
                        <button type="button" onclick="confirmSubmit('vark')"
                            class="btn btn-primary btn-lg float-right shadow px-5"
                            style="border-radius: 50px; font-weight: bold;">
                            SELESAIKAN VARK <i class="fas fa-check-circle ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<style>
    .hov-scale:hover {
        transform: translateX(5px);
        transition: 0.2s;
    }

    .border-left-3 {
        border-left-width: 4px !important;
    }
</style>

<?php include '../app/Views/layout/footer.php'; ?>