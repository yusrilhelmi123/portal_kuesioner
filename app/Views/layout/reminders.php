<?php
// app/Views/layout/reminders.php

$settingModel = new \App\Models\Setting();
$allReminders = $settingModel->getActiveReminders();

// Tentukan apakah pengguna adalah mahasiswa atau admin
$isStudent = isset($_SESSION['student_id']);
$isAdmin = isset($_SESSION['admin_id']);
$studentReminders = [];

if ($isStudent) {
    $studentModel = new \App\Models\Student();
    $user = $studentModel->findByNpm($_SESSION['npm']);
    $current_month = date('Y-m');

    foreach ($allReminders as $r) {
        $show = false;
        if ($r['setting_key'] == 'vark_open') {
            // VARK: Tampilkan jika belum mengisi atau lebih dari 6 bulan
            if (!$user['vark_updated_at']) {
                $show = true;
            } else {
                $monthsDiff = (new DateTime())->diff(new DateTime($user['vark_updated_at']))->m
                    + (new DateTime())->diff(new DateTime($user['vark_updated_at']))->y * 12;
                if ($monthsDiff >= 6)
                    $show = true;
            }
        } else {
            // MSLQ & AMS: Tampilkan jika belum mengisi bulan ini
            $update_at = $r['setting_key'] == 'mslq_open' ? ($user['mslq_updated_at'] ?? '') : ($user['ams_updated_at'] ?? '');
            if (!$update_at || date('Y-m', strtotime($update_at)) != $current_month) {
                $show = true;
            }
        }
        if ($show)
            $studentReminders[] = $r;
    }
} else {
    // Admin atau tamu: perlihatkan semua reminder yang aktif
    $studentReminders = $allReminders;
}

$labels = [
    'vark_open' => 'VARK Learning Style',
    'mslq_open' => 'MSLQ Strategy',
    'ams_open' => 'AMS Motivation'
];
?>

<?php if (!empty($studentReminders)): ?>
    <div id="reminder-container" class="mb-3">
        <?php foreach ($studentReminders as $r):
            $id = "reminder_" . $r['setting_key'] . "_" . str_replace('-', '', $r['next_open_at']);
            ?>
            <div class="alert alert-warning alert-dismissible shadow reminder-banner" id="<?= $id ?>" role="alert"
                style="border-left: 5px solid #e08e0b; display: none;">
                <button type="button" class="close" aria-hidden="true" onclick="dismissReminder('<?= $id ?>')">&times;</button>
                <h5 class="mb-1">
                    <i class="fas fa-bell fa-shake mr-2 text-warning"></i>
                    <strong>Pengingat Jadwal Riset!</strong>
                </h5>
                <hr class="my-1">
                Kuesioner <strong><?= $labels[$r['setting_key']] ?></strong>
                dijadwalkan untuk dibuka mulai
                <strong><?= date('d M Y', strtotime($r['next_open_at'])) ?></strong>
                <?php if ($isStudent): ?>
                    &mdash; Mohon bersiap dan tunggu instruksi Admin untuk mengisi kuesioner.
                <?php else: ?>
                    &mdash; Jadwal sudah tiba namun akses masih <strong class="text-danger">TERTUTUP</strong>.
                    <a href="/admin/settings" class="btn btn-sm btn-danger ml-2">
                        <i class="fas fa-unlock mr-1"></i>Buka Akses Sekarang
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
    (function () {
        // Bersihkan format key lama agar tidak konflik
        const reminders = document.querySelectorAll('.reminder-banner');
        reminders.forEach(function (banner) {
            const id = banner.id;
            // Cek format key baru (dismissed_xxx) dan lama (xxx)
            const dismissed = localStorage.getItem('dismissed_' + id) || localStorage.getItem(id);
            if (!dismissed) {
                banner.style.display = 'flex';
                banner.style.alignItems = 'flex-start';
            }
        });
    })();

    function dismissReminder(id) {
        localStorage.setItem('dismissed_' + id, '1');
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    }
</script>

<style>
    .reminder-banner {
        animation: pulseBorder 2s infinite;
    }

    @keyframes pulseBorder {

        0%,
        100% {
            border-left-color: #e08e0b;
        }

        50% {
            border-left-color: #f39c12;
            box-shadow: 0 0 8px rgba(243, 156, 18, 0.5);
        }
    }
</style>