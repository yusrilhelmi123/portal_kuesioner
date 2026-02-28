<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Question;
use App\Models\Setting;

class MslqController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['student_id'])) {
            $this->redirect('/home');
        }
        $settingModel = new Setting();
        if (!$settingModel->isOpen('mslq_open')) {
            $this->view('errors/closed_notice', ['type' => 'mslq']);
            exit;
        }
    }

    public function index()
    {
        $this->view('home/quiz_welcome', ['type' => 'mslq']);
    }

    public function quiz()
    {
        $questionModel = new Question();
        $this->view('mslq/index', ['questions' => $questionModel->getMslq()]);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $studentModel = new \App\Models\Student();
            $questionModel = new Question();
            foreach (($_POST['answers'] ?? []) as $q_id => $val) {
                $questionModel->saveResponse($_SESSION['student_id'], 'MSLQ', $q_id, $val);
            }
            $score = $studentModel->calculateAndSetMslq($_SESSION['student_id']);

            // Log to history
            $db = \App\Core\Database::getInstance();
            $stmt = $db->prepare("INSERT INTO quiz_history (student_id, quiz_type, result_label, result_value) VALUES (?, 'MSLQ', ?, ?)");
            $stmt->execute([$_SESSION['student_id'], $score, $score]);

            $_SESSION['quiz_success'] = 'MSLQ Evaluation';
            $this->redirect('/dashboard/profile');
        }
    }
}
