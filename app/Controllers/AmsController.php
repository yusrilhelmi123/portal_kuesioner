<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Question;
use App\Models\Setting;

class AmsController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['student_id'])) {
            $this->redirect('/home');
        }
        if (!(new Setting())->isOpen('ams_open')) {
            $this->view('errors/closed_notice', ['type' => 'ams']);
            exit;
        }
    }

    public function index()
    {
        $this->view('home/quiz_welcome', ['type' => 'ams']);
    }

    public function quiz()
    {
        $this->view('ams/index', ['questions' => (new Question())->getAms()]);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $studentModel = new \App\Models\Student();
            $questionModel = new Question();
            foreach (($_POST['answers'] ?? []) as $q_id => $val) {
                $questionModel->saveResponse($_SESSION['student_id'], 'AMS', $q_id, $val);
            }
            $result = $studentModel->calculateAndSetAms($_SESSION['student_id']);

            // Log to history
            $db = \App\Core\Database::getInstance();
            $stmt = $db->prepare("INSERT INTO quiz_history (student_id, quiz_type, result_label) VALUES (?, 'AMS', ?)");
            $stmt->execute([$_SESSION['student_id'], $result]);

            $_SESSION['quiz_success'] = 'AMS Motivation';
            $this->redirect('/dashboard/profile');
        }
    }
}
