<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Student;
use App\Models\Setting;
use App\Models\Question;
use App\Core\Database;

class AdminController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['admin_id']) && !strpos($_SERVER['REQUEST_URI'], 'login')) {
            $this->redirect('/admin/login');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
            $stmt->execute([$_POST['username']]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($_POST['password'], $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $this->redirect('/admin');
            } else {
                $this->view('admin/login', ['error' => 'Login Admin Gagal.']);
            }
        } else {
            $this->view('admin/login');
        }
    }

    public function index()
    {
        $studentModel = new Student();
        $db = Database::getInstance();

        // Stats for Overview Cards
        $data = [
            'total' => count($studentModel->getApproved()) + count($studentModel->getPending()),
            'pending' => count($studentModel->getPending()),
            'settings' => (new Setting())->getAllRaw()
        ];

        // VARK Distribution
        $data['vark_dist'] = $db->query("SELECT vark_type as label, COUNT(*) as value FROM students WHERE vark_type IS NOT NULL AND vark_type != '' GROUP BY vark_type")->fetchAll();

        // AMS Distribution
        $data['ams_dist'] = $db->query("SELECT ams_type as label, COUNT(*) as value FROM students WHERE ams_type IS NOT NULL AND ams_type != '' GROUP BY ams_type")->fetchAll();

        // MSLQ Average Progress (Last 6 months)
        $data['mslq_avg'] = $db->query("
            SELECT DATE_FORMAT(submitted_at, '%b %Y') as label, AVG(result_value) as value 
            FROM quiz_history 
            WHERE quiz_type = 'MSLQ' 
            GROUP BY DATE_FORMAT(submitted_at, '%b %Y'), DATE_FORMAT(submitted_at, '%Y-%m') 
            ORDER BY MIN(submitted_at) ASC 
            LIMIT 6
        ")->fetchAll();

        // Monthly Activity (Quiz Completions last 30 days)
        $data['activity'] = $db->query("
            SELECT DATE_FORMAT(submitted_at, '%d %b') as label, COUNT(*) as value 
            FROM quiz_history 
            WHERE submitted_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY DATE_FORMAT(submitted_at, '%d %b'), DATE(submitted_at) 
            ORDER BY MIN(submitted_at) ASC
        ")->fetchAll();

        // Detailed Summaries for Small Boxes
        // VARK (Mapping initials V/A/R/K to labels)
        $vark_raw = $db->query("SELECT vark_type, COUNT(*) as count FROM students WHERE vark_type IS NOT NULL AND vark_type != '' GROUP BY vark_type")->fetchAll(\PDO::FETCH_KEY_PAIR);
        $data['vark_summary'] = [
            'Visual' => $vark_raw['V'] ?? 0,
            'Aural' => $vark_raw['Aural'] ?? $vark_raw['A'] ?? 0,
            'Read/Write' => $vark_raw['Read/Write'] ?? $vark_raw['R'] ?? 0,
            'Kinesthetic' => $vark_raw['Kinesthetic'] ?? $vark_raw['K'] ?? 0,
        ];

        // AMS (Handing case-insensitive categories)
        $ams_raw = $db->query("SELECT LOWER(ams_type) as type, COUNT(*) as count FROM students WHERE ams_type IS NOT NULL AND ams_type != '' GROUP BY LOWER(ams_type)")->fetchAll(\PDO::FETCH_KEY_PAIR);
        $data['ams_summary'] = [
            'Intrinsic' => $ams_raw['intrinsic'] ?? 0,
            'Extrinsic' => $ams_raw['extrinsic'] ?? 0,
            'Achievement' => $ams_raw['achievement'] ?? 0,
            'Amotivation' => $ams_raw['amotivation'] ?? 0,
        ];

        // Overall MSLQ Average
        $data['mslq_overall_avg'] = round($db->query("SELECT AVG(result_value) FROM quiz_history WHERE quiz_type = 'MSLQ'")->fetchColumn() ?: 0, 2);

        // Pagination for Progress Table
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $totalHistory = $db->query("SELECT COUNT(*) FROM quiz_history")->fetchColumn();
        $data['history_pages'] = ceil($totalHistory / $perPage);
        $data['current_page'] = $page;

        // Recent Quiz History for Progress Table with Pagination
        $data['recent_history'] = $db->query("
            SELECT h.*, s.nama, s.npm, c.class_name
            FROM quiz_history h
            JOIN students s ON h.student_id = s.id
            LEFT JOIN classes c ON s.kelas = c.class_name
            ORDER BY h.submitted_at DESC
            LIMIT $perPage OFFSET $offset
        ")->fetchAll();

        $this->view('admin/index', $data);
    }

    public function approvals()
    {
        $studentModel = new Student();
        $this->view('admin/approvals', ['students' => $studentModel->getPending()]);
    }

    public function approve($id)
    {
        (new Student())->approve($id);
        $this->redirect('/admin/approvals');
    }

    public function students()
    {
        $studentModel = new Student();
        $this->view('admin/students', [
            'students' => $studentModel->getApproved(),
            'title' => 'Master Data Mahasiswa Aktif'
        ]);
    }

    public function delete_student($id)
    {
        (new Student())->delete($id);
        $_SESSION['success'] = "Data mahasiswa berhasil dihapus!";

        $ref = $_GET['ref'] ?? 'students';
        $this->redirect('/admin/' . $ref);
    }

    public function classes()
    {
        $classModel = new \App\Models\ClassModel();
        $this->view('admin/classes', [
            'classes' => $classModel->getAll(),
            'title' => 'Manajemen Data Kelas'
        ]);
    }

    public function add_class()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            (new \App\Models\ClassModel())->add($_POST['class_name'], $_POST['description'] ?? '');
            $_SESSION['success'] = "Kelas berhasil ditambahkan!";
        }
        $this->redirect('/admin/classes');
    }

    public function delete_class($id)
    {
        (new \App\Models\ClassModel())->delete($id);
        $_SESSION['success'] = "Kelas berhasil dihapus!";
        $this->redirect('/admin/classes');
    }

    public function edit_class($id)
    {
        $classModel = new \App\Models\ClassModel();
        $class = $classModel->find($id);
        $this->view('admin/edit_class', [
            'class' => $class,
            'title' => 'Edit Data Kelas'
        ]);
    }

    public function update_class()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['class_name'];
            $desc = $_POST['description'];
            (new \App\Models\ClassModel())->update($id, $name, $desc);
            $_SESSION['success'] = "Data kelas berhasil diperbarui!";
        }
        $this->redirect('/admin/classes');
    }

    public function edit_student($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch();

        $classModel = new \App\Models\ClassModel();
        $classes = $classModel->getAll();

        $this->view('admin/edit_student', [
            's' => $student,
            'classes' => $classes,
            'title' => 'Edit Data Mahasiswa'
        ]);
    }

    public function update_student()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $studentModel = new Student();
            $data = [
                'nama' => $_POST['nama'],
                'npm' => $_POST['npm'],
                'kelas' => $_POST['kelas'],
                'no_hp' => $_POST['no_hp'],
                'email' => $_POST['email']
            ];
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            $studentModel->updateProfile($id, $data);
            $_SESSION['success'] = "Data mahasiswa berhasil diperbarui!";
            $this->redirect('/admin/students');
        }
    }

    public function settings()
    {
        $settingModel = new Setting();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle Toggle Status
            if (isset($_POST['toggle_key'])) {
                $key = $_POST['toggle_key'];
                $val = (int) ($_POST[$key] ?? 0);
                $settingModel->update($key, $val);
            }

            // Handle Update Next Open Date
            if (isset($_POST['update_next_open'])) {
                $key = $_POST['update_next_open'];
                $date = $_POST['next_open_at'] ?? '';
                $settingModel->updateNextOpen($key, $date);
            }

            $this->redirect('/admin/settings');
        }
        $this->view('admin/settings', ['settings' => $settingModel->getAllRaw()]);
    }

    public function vark()
    {
        $db = Database::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            $teks = $_POST['teks_pertanyaan'] ?? '';
            if ($id) {
                $stmt = $db->prepare("UPDATE vark_questions SET teks_pertanyaan=?, opt_v=?, opt_a=?, opt_r=?, opt_k=? WHERE id=?");
                $stmt->execute([$teks, $_POST['opt_v'], $_POST['opt_a'], $_POST['opt_r'], $_POST['opt_k'], $id]);
            } else {
                $stmt = $db->prepare("INSERT INTO vark_questions (teks_pertanyaan, opt_v, opt_a, opt_r, opt_k) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$teks, $_POST['opt_v'], $_POST['opt_a'], $_POST['opt_r'], $_POST['opt_k']]);
            }
            $_SESSION['success'] = "Data soal VARK berhasil disimpan!";
            $this->redirect('/admin/vark');
        }
        $questions = $db->query("SELECT * FROM vark_questions")->fetchAll();
        $this->view('admin/questions_vark', ['questions' => $questions, 'title' => 'Manajemen Soal VARK']);
    }

    public function mslq()
    {
        $db = Database::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            if ($id) {
                $stmt = $db->prepare("UPDATE mslq_questions SET teks_pertanyaan=?, dimensi=? WHERE id=?");
                $stmt->execute([$_POST['teks_pertanyaan'], $_POST['dimensi'], $id]);
            } else {
                $stmt = $db->prepare("INSERT INTO mslq_questions (teks_pertanyaan, dimensi) VALUES (?, ?)");
                $stmt->execute([$_POST['teks_pertanyaan'], $_POST['dimensi']]);
            }
            $_SESSION['success'] = "Data soal MSLQ berhasil disimpan!";
            $this->redirect('/admin/mslq');
        }
        $questions = $db->query("SELECT * FROM mslq_questions")->fetchAll();
        $this->view('admin/questions_mslq', ['questions' => $questions, 'title' => 'Manajemen Soal MSLQ']);
    }

    public function ams()
    {
        $db = Database::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            if ($id) {
                $stmt = $db->prepare("UPDATE ams_questions SET teks_pertanyaan=?, kategori=? WHERE id=?");
                $stmt->execute([$_POST['teks_pertanyaan'], $_POST['kategori'], $id]);
            } else {
                $stmt = $db->prepare("INSERT INTO ams_questions (teks_pertanyaan, kategori) VALUES (?, ?)");
                $stmt->execute([$_POST['teks_pertanyaan'], $_POST['kategori']]);
            }
            $_SESSION['success'] = "Data soal AMS berhasil disimpan!";
            $this->redirect('/admin/ams');
        }
        $questions = $db->query("SELECT * FROM ams_questions")->fetchAll();
        $this->view('admin/questions_ams', ['questions' => $questions, 'title' => 'Manajemen Soal AMS']);
    }

    public function delete_question($type, $id)
    {
        $db = Database::getInstance();
        $table = $type . '_questions';
        if (in_array($type, ['vark', 'mslq', 'ams'])) {
            $stmt = $db->prepare("DELETE FROM $table WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['success'] = "Soal berhasil dihapus!";
        }
        $this->redirect('/admin/' . $type);
    }

    public function export_json()
    {
        $db = Database::getInstance();
        $students = $db->query("
            SELECT npm, nama, vark_type, mslq_score, ams_type, vark_updated_at, mslq_updated_at, ams_updated_at 
            FROM students 
            WHERE is_approved = 1 AND vark_type IS NOT NULL
            ORDER BY npm ASC
        ")->fetchAll(\PDO::FETCH_ASSOC);

        $output = [];
        foreach ($students as $s) {
            $output[] = [
                'npm' => $s['npm'],
                'nama' => $s['nama'],
                'vark_type' => $s['vark_type'] ?: '-',
                'mslq_score' => $s['mslq_score'] !== null ? (float) $s['mslq_score'] : 0,
                'ams_type' => $s['ams_type'] ? strtolower($s['ams_type']) : '-'
            ];
        }

        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="kuisioner_pm_export_' . date('Ymd_His') . '.json"');
        echo json_encode($output, JSON_PRETTY_PRINT);
        exit;
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        $this->redirect('/admin/login');
    }
}
