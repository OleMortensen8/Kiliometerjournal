<?php
// Autoload function
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/' . $class_name . '.php';
});

// Instantiate Table class if it exists and is needed
if (class_exists('Table')) {
    $table = new Table();
}

// Create an instance of DB class
$db = new DB();
?>
