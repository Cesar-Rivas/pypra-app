<?php
$folder = 'models/';
$allowed_extensions = ['gltf', 'glb']; // tipos permitidos

$files = array_diff(scandir($folder), array('.', '..'));
$models = [];

foreach ($files as $file) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (in_array($ext, $allowed_extensions)) {
        $models[] = pathinfo($file, PATHINFO_FILENAME); // solo nombre sin extensión
    }
}

header('Content-Type: application/json');
echo json_encode($models);
?>
