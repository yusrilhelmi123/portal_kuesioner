<?php
// app/Core/Controller.php - Base Controller
namespace App\Core;

class Controller
{
    public function view($view, $data = [])
    {
        extract($data);
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die("View $view not found.");
        }
    }

    public function redirect($url)
    {
        $target = (strpos($url, '/') === 0) ? $url : '/' . $url;
        header("Location: " . $target);
        exit;
    }
}
