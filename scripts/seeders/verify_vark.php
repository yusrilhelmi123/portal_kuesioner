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

$db = Database::getInstance();
$count = $db->query("SELECT COUNT(*) FROM vark_questions")->fetchColumn();
echo "Jumlah Soal VARK: " . $count . "\n";
$first = $db->query("SELECT * FROM vark_questions LIMIT 1")->fetch();
print_r($first);
