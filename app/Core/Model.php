<?php
// app/Core/Model.php - Base Model
namespace App\Core;

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
