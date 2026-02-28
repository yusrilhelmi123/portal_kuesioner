<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Question;
use App\Models\Setting;

class VarkController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['student_id'])) {
            $this->redirect('/home');
        }
        $settingModel = new Setting();
        if (!$settingModel->isOpen('vark_open')) {
            $this->view('errors/closed_notice', ['type' => 'vark']);
            exit;
        }
    }

    public function index()
    {
        $this->view('home/quiz_welcome', ['type' => 'vark']);
    }

    public function quiz()
    {
        $questionModel = new Question();
        $questions = $questionModel->getVark();
        $this->view('vark/index', ['questions' => $questions]);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $studentModel = new \App\Models\Student();
            $questionModel = new Question();
            $answers = $_POST['answers'] ?? [];
            foreach ($answers as $q_id => $val) {
                $questionModel->saveResponse($_SESSION['student_id'], 'VARK', $q_id, $val);
            }
            $result = $studentModel->calculateAndSetVark($_SESSION['student_id']);

            // Log to history
            $db = \App\Core\Database::getInstance();
            $stmt = $db->prepare("INSERT INTO quiz_history (student_id, quiz_type, result_label) VALUES (?, 'VARK', ?)");
            $stmt->execute([$_SESSION['student_id'], $result]);

            // The MSLQ part seems to be an unrelated leftover from a previous edit or copy-paste.
            // Removing it to focus on the VARK submission as per the controller's context.
            // If MSLQ submission is also intended here, it should be explicitly stated.

            $_SESSION['quiz_success'] = 'VARK Assessment';
            $this->redirect('/dashboard/profile');
        }
    }
}
