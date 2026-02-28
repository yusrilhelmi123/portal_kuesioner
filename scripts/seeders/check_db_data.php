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
    echo "--- DATA STUDENTS ---\n";
    $students = $db->query("SELECT id, nama, kelas FROM students LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    print_r($students);

    echo "\n--- DATA CLASSES ---\n";
    $classes = $db->query("SELECT id, class_name FROM classes")->fetchAll(PDO::FETCH_ASSOC);
    print_r($classes);

    echo "\n--- JOIN TEST ---\n";
    $join = $db->query("
        SELECT s.nama, s.kelas, c.class_name 
        FROM students s 
        LEFT JOIN classes c ON s.kelas = c.id 
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);
    print_r($join);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
