<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Student;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['student_id'])) {
            $this->redirect('/home');
        }
    }

    public function index()
    {
        $studentModel = new Student();
        $user = $studentModel->findByNpm($_SESSION['npm']);

        // Ambil jadwal & timestamp buka/tutup dari settings
        $settingModel = new Setting();
        $rawSettings = $settingModel->getAllRaw();
        $quiz_schedule = [];
        foreach ($rawSettings as $s) {
            $quiz_schedule[$s['setting_key']] = $s;
        }

        // opened_at: kapan terakhir admin membuka akses kuesioner
        $vark_opened_at = $quiz_schedule['vark_open']['opened_at'] ?? null;
        $mslq_opened_at = $quiz_schedule['mslq_open']['opened_at'] ?? null;
        $ams_opened_at = $quiz_schedule['ams_open']['opened_at'] ?? null;

        // Helper: validasi pengisian mahasiswa SETELAH pembukaan akses terbaru oleh admin
        // Jika admin membuka ulang (opened_at baru), mahasiswa wajib isi lagi
        $isAfterReopened = function ($student_updated_at, $setting_opened_at) {
            if (!$student_updated_at)
                return false;
            if (!$setting_opened_at)
                return true;
            return strtotime($student_updated_at) >= strtotime($setting_opened_at);
        };

        // VARK: valid jika diisi dalam 6 bulan terakhir DAN setelah pembukaan akses terakhir
        $vark_status = 'expired';
        if ($user['vark_updated_at'] && $isAfterReopened($user['vark_updated_at'], $vark_opened_at)) {
            $diff = (new \DateTime($user['vark_updated_at']))->diff(new \DateTime());
            if ($diff->y == 0 && $diff->m < 6) {
                $vark_status = 'active';
            }
        }

        // MSLQ: valid jika diisi bulan ini DAN setelah pembukaan akses terakhir
        $current_month = date('Y-m');
        $mslq_status = 'expired';
        if (
            $user['mslq_updated_at']
            && date('Y-m', strtotime($user['mslq_updated_at'])) == $current_month
            && $isAfterReopened($user['mslq_updated_at'], $mslq_opened_at)
        ) {
            $mslq_status = 'active';
        }

        // AMS: valid jika diisi bulan ini DAN setelah pembukaan akses terakhir
        $ams_status = 'expired';
        if (
            $user['ams_updated_at']
            && date('Y-m', strtotime($user['ams_updated_at'])) == $current_month
            && $isAfterReopened($user['ams_updated_at'], $ams_opened_at)
        ) {
            $ams_status = 'active';
        }

        $db = \App\Core\Database::getInstance();
        $mslq_history = $db->query("
            SELECT DATE_FORMAT(submitted_at, '%d %b %y') as label, result_value as value 
            FROM quiz_history 
            WHERE student_id = " . (int) $_SESSION['student_id'] . " AND quiz_type = 'MSLQ' 
            ORDER BY submitted_at ASC 
            LIMIT 6
        ")->fetchAll();

        $mslq_global_avg = $db->query("SELECT AVG(result_value) FROM quiz_history WHERE quiz_type = 'MSLQ'")->fetchColumn() ?: 0;

        // Paginasi Log Aktivitas
        $logPage = isset($_GET['log_page']) ? (int) $_GET['log_page'] : 1;
        $logsPerPage = 5;
        $logOffset = ($logPage - 1) * $logsPerPage;

        $totalLogsResult = $db->query("SELECT COUNT(*) FROM quiz_history WHERE student_id = " . (int) $_SESSION['student_id']);
        $totalLogs = $totalLogsResult->fetchColumn();
        $logPagesCount = ceil($totalLogs / $logsPerPage);

        // Ambil Log Aktivitas (dengan Paginasi)
        $activity_log = $db->query("
            SELECT * FROM quiz_history 
            WHERE student_id = " . (int) $_SESSION['student_id'] . " 
            ORDER BY submitted_at DESC 
            LIMIT $logsPerPage OFFSET $logOffset
        ")->fetchAll();

        $this->view('dashboard/index', [
            'user' => $user,
            'vark_status' => $vark_status,
            'mslq_status' => $mslq_status,
            'ams_status' => $ams_status,
            'quiz_schedule' => $quiz_schedule,
            'mslq_history' => $mslq_history,
            'mslq_global_avg' => round($mslq_global_avg, 2),
            'activity_log' => $activity_log,
            'log_pages' => $logPagesCount,
            'current_log_page' => $logPage
        ]);
    }

    public function profile()
    {
        $studentModel = new Student();
        $user = $studentModel->findByNpm($_SESSION['npm']);

        $classModel = new \App\Models\ClassModel();
        $classes = $classModel->getAll();

        $this->view('dashboard/profile', [
            'user' => $user,
            'classes' => $classes
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $studentModel = new Student();
            $data = [
                'nama' => $_POST['nama'],
                'kelas' => $_POST['kelas'],
                'no_hp' => $_POST['no_hp'],
                'email' => $_POST['email']
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $filename = $_SESSION['npm'] . '_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/profile/' . $filename);
                $data['foto'] = $filename;
                $_SESSION['foto'] = $filename;
            }

            $studentModel->updateProfile($_SESSION['student_id'], $data);
            $_SESSION['nama'] = $data['nama'];
            $this->redirect('dashboard/profile');
        }
    }
}
