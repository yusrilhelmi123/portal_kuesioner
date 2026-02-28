<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Student;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home/landing');
    }

    public function login_page()
    {
        if (isset($_SESSION['student_id'])) {
            $this->redirect('dashboard');
        }
        $this->view('home/index');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $studentModel = new Student();
            $user = $studentModel->findByNpm($_POST['npm']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                if ($user['is_approved'] == 0) {
                    $this->view('home/index', ['error' => 'Akun Anda sedang menunggu persetujuan Admin.']);
                } else {
                    $_SESSION['student_id'] = $user['id'];
                    $_SESSION['npm'] = $user['npm'];
                    $_SESSION['nama'] = $user['nama'];
                    $_SESSION['foto'] = $user['foto'] ?? null;
                    $this->redirect('dashboard');
                }
            } else {
                $this->view('home/index', ['error' => 'NPM atau Password salah.']);
            }
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $studentModel = new Student();
            if ($studentModel->register($_POST['npm'], $_POST['nama'], $_POST['password'])) {
                $this->view('home/index', ['success' => 'Registrasi berhasil. Silakan tunggu persetujuan admin.']);
            } else {
                $this->view('home/index', ['error' => 'Registrasi gagal. NPM mungkin sudah ada.']);
            }
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('home');
    }
}
