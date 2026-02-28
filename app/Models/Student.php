<?php
namespace App\Models;

use App\Core\Model;

class Student extends Model
{
    public function findByNpm($npm)
    {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE npm = ?");
        $stmt->execute([$npm]);
        return $stmt->fetch();
    }

    public function register($npm, $nama, $password)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO students (npm, nama, password) VALUES (?, ?, ?)");
        return $stmt->execute([$npm, $nama, $hashed]);
    }

    public function getPending()
    {
        return $this->db->query("SELECT * FROM students WHERE is_approved = 0 ORDER BY created_at DESC")->fetchAll();
    }

    public function getApproved()
    {
        return $this->db->query("SELECT * FROM students WHERE is_approved = 1 ORDER BY npm ASC")->fetchAll();
    }

    public function approve($id)
    {
        return $this->db->prepare("UPDATE students SET is_approved = 1 WHERE id = ?")->execute([$id]);
    }

    public function delete($id)
    {
        return $this->db->prepare("DELETE FROM students WHERE id = ?")->execute([$id]);
    }

    public function updateProfile($id, $data)
    {
        $fields = [];
        $params = [];

        // Konversi string kosong ke NULL untuk field yang memiliki UNIQUE constraint
        $nullable_unique_fields = ['email', 'no_hp', 'npm'];
        foreach ($data as $key => $val) {
            if (in_array($key, $nullable_unique_fields) && $val === '') {
                $val = null;
            }
            $fields[] = "$key = ?";
            $params[] = $val;
        }
        $params[] = $id;
        $sql = "UPDATE students SET " . implode(", ", $fields) . " WHERE id = ?";
        return $this->db->prepare($sql)->execute($params);
    }

    public function updateScores($id, $vark, $mslq, $ams)
    {
        $stmt = $this->db->prepare("UPDATE students SET 
            vark_type = ?, 
            mslq_score = ?, 
            ams_type = ?, 
            vark_updated_at = IF(? IS NOT NULL, NOW(), vark_updated_at),
            mslq_updated_at = IF(? IS NOT NULL, NOW(), mslq_updated_at),
            ams_updated_at = IF(? IS NOT NULL, NOW(), ams_updated_at)
            WHERE id = ?");
        return $stmt->execute([$vark, $mslq, $ams, $vark, $mslq, $ams, $id]);
    }

    public function calculateAndSetVark($id)
    {
        // Ambil jawaban TERBARU per soal (MAX id), hitung frekuensi V/A/R/K
        $stmt = $this->db->prepare("
            SELECT r.nilai_jawaban, COUNT(*) AS freq
            FROM responses r
            INNER JOIN (
                SELECT question_id, MAX(id) AS max_id
                FROM responses
                WHERE student_id = ? AND tipe_pertanyaan = 'VARK'
                GROUP BY question_id
            ) latest ON r.id = latest.max_id
            GROUP BY r.nilai_jawaban
            ORDER BY freq DESC
            LIMIT 1
        ");
        $stmt->execute([$id]);
        $res = $stmt->fetchColumn() ?: null;
        if ($res) {
            $this->db->prepare("UPDATE students SET vark_type = ?, vark_updated_at = NOW() WHERE id = ?")
                ->execute([$res, $id]);
        }
        return $res;
    }

    public function calculateAndSetMslq($id)
    {
        // Hitung rata-rata dari jawaban TERBARU per soal (MAX id)
        $stmt = $this->db->prepare("
            SELECT AVG(CAST(r.nilai_jawaban AS UNSIGNED))
            FROM responses r
            INNER JOIN (
                SELECT question_id, MAX(id) AS max_id
                FROM responses
                WHERE student_id = ? AND tipe_pertanyaan = 'MSLQ'
                GROUP BY question_id
            ) latest ON r.id = latest.max_id
        ");
        $stmt->execute([$id]);
        $res = round($stmt->fetchColumn() ?: 0, 2);
        if ($res > 0) {
            $this->db->prepare("UPDATE students SET mslq_score = ?, mslq_updated_at = NOW() WHERE id = ?")
                ->execute([$res, $id]);
        }
        return $res;
    }

    public function calculateAndSetAms($id)
    {
        // Cari kategori AMS dengan rata-rata skor tertinggi dari jawaban TERBARU per soal
        $stmt = $this->db->prepare("
            SELECT q.kategori, AVG(CAST(r.nilai_jawaban AS UNSIGNED)) AS avg_score
            FROM responses r
            INNER JOIN (
                SELECT question_id, MAX(id) AS max_id
                FROM responses
                WHERE student_id = ? AND tipe_pertanyaan = 'AMS'
                GROUP BY question_id
            ) latest ON r.id = latest.max_id
            JOIN ams_questions q ON r.question_id = q.id
            GROUP BY q.kategori
            ORDER BY avg_score DESC
            LIMIT 1
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        $res = $row ? $row['kategori'] : null;
        if ($res) {
            $this->db->prepare("UPDATE students SET ams_type = ?, ams_updated_at = NOW() WHERE id = ?")
                ->execute([$res, $id]);
        }
        return $res;
    }
}
