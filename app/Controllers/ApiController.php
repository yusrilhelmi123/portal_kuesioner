<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class ApiController extends Controller
{
    /**
     * Endpoint untuk mendapatkan data hasil kuesioner mahasiswa
     * URL: /api/results
     */
    public function results()
    {
        try {
            $db = Database::getInstance();
            $students = $db->query("
                SELECT npm, nama, vark_type, mslq_score, ams_type 
                FROM students 
                WHERE is_approved = 1
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
            header('Access-Control-Allow-Origin: *');
            echo json_encode($output, JSON_PRETTY_PRINT);
            exit;
        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => 'Gagal mengambil data: ' . $e->getMessage()]);
            exit;
        }
    }

    /**
     * Halaman dokumentasi Swagger UI
     * URL: /api/docs
     */
    public function docs()
    {
        $this->view('api/docs');
    }

    /**
     * Menyediakan file swagger.yaml
     * URL: /api/spec
     */
    public function spec()
    {
        $filePath = __DIR__ . '/../../dev-resources/docs/swagger.yaml';
        if (file_exists($filePath)) {
            header('Content-Type: text/yaml');
            echo file_get_contents($filePath);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo "Swagger specification not found.";
        }
        exit;
    }
}
