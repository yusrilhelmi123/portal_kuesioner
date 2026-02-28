<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Student;
use App\Core\Database;

class ResultsController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['student_id'])) {
            $this->redirect('/home');
        }
        $db = Database::getInstance();
        $student_id = $_SESSION['student_id'];

        // Logic to calculate results...
        $vark = $db->prepare("SELECT nilai_jawaban FROM responses WHERE student_id=? AND tipe_pertanyaan='VARK' GROUP BY nilai_jawaban ORDER BY COUNT(*) DESC LIMIT 1");
        $vark->execute([$student_id]);
        $vark_type = $vark->fetchColumn() ?: 'Unknown';

        $mslq = $db->prepare("SELECT AVG(CAST(nilai_jawaban AS UNSIGNED)) FROM responses WHERE student_id=? AND tipe_pertanyaan='MSLQ'");
        $mslq->execute([$student_id]);
        $mslq_score = round($mslq->fetchColumn() ?: 0, 2);

        $ams = $db->prepare("SELECT q.kategori FROM responses r JOIN ams_questions q ON r.question_id=q.id WHERE r.student_id=? AND r.tipe_pertanyaan='AMS' GROUP BY q.kategori ORDER BY AVG(CAST(r.nilai_jawaban AS UNSIGNED)) DESC LIMIT 1");
        $ams->execute([$student_id]);
        $ams_type = $ams->fetchColumn() ?: 'Unknown';

        (new Student())->updateScores($student_id, $vark_type, $mslq_score, $ams_type);

        $_SESSION['quiz_success'] = true;

        $this->view('results/index', [
            'vark' => $vark_type,
            'mslq' => $mslq_score,
            'ams' => $ams_type,
            'json' => json_encode(['npm' => $_SESSION['npm'], 'vark' => $vark_type, 'mslq' => $mslq_score, 'ams' => $ams_type], JSON_PRETTY_PRINT)
        ]);
    }
}
