<?php
namespace App\Models;

use App\Core\Model;

class ClassModel extends Model
{
    public function getAll()
    {
        return $this->db->query("SELECT * FROM classes ORDER BY class_name ASC")->fetchAll();
    }

    public function add($name, $description = '')
    {
        $stmt = $this->db->prepare("INSERT INTO classes (class_name, description) VALUES (?, ?)");
        return $stmt->execute([$name, $description]);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM classes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $name, $description)
    {
        $stmt = $this->db->prepare("UPDATE classes SET class_name = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM classes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
