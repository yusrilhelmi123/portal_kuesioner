<?php
namespace App\Models;

use App\Core\Model;

class Setting extends Model
{
    public function getAll()
    {
        $settings = [];
        foreach ($this->db->query("SELECT * FROM system_settings") as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function getAllRaw()
    {
        return $this->db->query("SELECT * FROM system_settings")->fetchAll();
    }

    public function update($key, $value)
    {
        $column = $value ? 'opened_at' : 'closed_at';
        $stmt = $this->db->prepare("UPDATE system_settings SET setting_value = ?, $column = NOW() WHERE setting_key = ?");
        return $stmt->execute([$value, $key]);
    }

    public function updateNextOpen($key, $date)
    {
        // Validasi format kuncinya: vark_open, mslq_open, ams_open
        $stmt = $this->db->prepare("UPDATE system_settings SET next_open_at = ? WHERE setting_key = ?");
        return $stmt->execute([$date ?: null, $key]);
    }

    public function isOpen($key)
    {
        $stmt = $this->db->prepare("SELECT setting_value FROM system_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        return (bool) $stmt->fetchColumn();
    }

    public function getActiveReminders()
    {
        $now = date('Y-m-d H:i:s');
        $today = date('Y-m-d');
        $hour = (int) date('H');

        $sql = "SELECT * FROM system_settings 
                WHERE next_open_at IS NOT NULL 
                AND next_open_at <= ? 
                AND setting_value = 0";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$today]);
        $rows = $stmt->fetchAll();

        $reminders = [];
        foreach ($rows as $row) {
            // Waktu server kemungkinan UTC (Selisih -7 jam dari WIB)
            // Jam 07:00 WIB di server UTC adalah Jam 00:00
            // Namun agar lebih aman bagi admin, jika tanggal sudah masuk, tampilkan saja.
            if ($row['next_open_at'] < $today) {
                $reminders[] = $row;
            } elseif ($row['next_open_at'] == $today) {
                // Tampilkan jika jam server sudah masuk hari tersebut (>= 00:00 UTC)
                $reminders[] = $row;
            }
        }
        return $reminders;
    }
}
