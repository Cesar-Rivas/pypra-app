<?php
include_once "db_connection.php";

use MongoDB\BSON\ObjectId;

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("Método no permitido");
}

// Helpers
function sanitize_string($value) {
    return trim(filter_var($value, FILTER_SANITIZE_STRING));
}

function sanitize_tags($raw) {
    return array_filter(array_map('trim', explode(',', $raw)));
}

function embed_image($inputName) {
    if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $fileData = file_get_contents($_FILES[$inputName]['tmp_name']);
    $mimeType = mime_content_type($_FILES[$inputName]['tmp_name']);

    return [
        'data' => new MongoDB\BSON\Binary($fileData, MongoDB\BSON\Binary::TYPE_GENERIC),
        'mime' => $mimeType,
        'name' => $_FILES[$inputName]['name']
    ];
}

// Collect form data
$id          = $_POST['id'] ?? null;
$nombre      = sanitize_string($_POST['nombre'] ?? '');
$desc        = sanitize_string($_POST['desc'] ?? '');
$tags_raw    = $_POST['tags'] ?? '';
$consumible  = isset($_POST['consumible']) && $_POST['consumible'] === 'on';
$disp        = max(0, (int) ($_POST['disp'] ?? 0));
$inv         = max(0, (int) ($_POST['inv'] ?? 0));
$tags_array  = sanitize_tags($tags_raw);

// Ensure tags exist in tags collection
$existingTags = $C_tags
    ->find(['nombre' => ['$in' => $tags_array]])
    ->toArray();

$existingNames = array_map(fn($doc) => $doc['nombre'], $existingTags);

$newTags = array_diff($tags_array, $existingNames);

if (!empty($newTags)) {
    $docs = array_map(fn($tag) => ['nombre' => $tag], $newTags);
    $C_tags->insertMany($docs);
}


// Get embedded images
$foto1 = embed_image('foto1');
$foto2 = embed_image('foto2');

// Build Mongo document
$data = [
    'nombre'      => $nombre,
    'desc'        => $desc,
    'tags'        => implode(',', $tags_array),
    'consumible'  => $consumible,
    'disp'        => $disp,
    'inv'         => $inv
];

if ($foto1) $data['foto1'] = $foto1;
if ($foto2) $data['foto2'] = $foto2;

// Insert or update
if ($id && preg_match('/^[a-f\d]{24}$/i', $id)) {
    $C_articulos->updateOne(
        ['_id' => new ObjectId($id)],
        ['$set' => $data]
    );
} else {
    $C_articulos->insertOne($data);
}

echo "OK";
