<?php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0)
        return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file))
        require $file;
});

use App\Core\Database;

try {
    $db = Database::getInstance();
    $totalHistory = $db->query("SELECT COUNT(*) FROM quiz_history")->fetchColumn();
    $perPage = 10;
    $history_pages = ceil($totalHistory / $perPage);

    echo "Total History: $totalHistory\n";
    echo "Per Page: $perPage\n";
    echo "Total Pages: $history_pages\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
