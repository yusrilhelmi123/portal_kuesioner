<?php
namespace App\Models;

use App\Core\Model;

class Question extends Model
{
    public function getVark()
    {
        return $this->db->query("SELECT * FROM vark_questions")->fetchAll();
    }

    public function getMslq()
    {
        return $this->db->query("SELECT * FROM mslq_questions")->fetchAll();
    }

    public function getAms()
    {
        return $this->db->query("SELECT * FROM ams_questions")->fetchAll();
    }

    public function saveResponse($student_id, $type, $q_id, $value)
    {
        // Hapus jawaban sebelumnya untuk soal yang sama agar tidak duplikat
        $del = $this->db->prepare("DELETE FROM responses WHERE student_id=? AND tipe_pertanyaan=? AND question_id=?");
        $del->execute([$student_id, $type, $q_id]);
        // Simpan jawaban baru
        $stmt = $this->db->prepare("INSERT INTO responses (student_id, tipe_pertanyaan, question_id, nilai_jawaban) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$student_id, $type, $q_id, $value]);
    }
}
