<?php
require 'vendor/autoload.php'; // Incluye el driver de MongoDB

use MongoDB\Client;

// Obtener los valores desde las variables de entorno
$mongo_uri = getenv("MONGO_URI");
$mongo_db_name = getenv("MONGO_DB_NAME");
$mongo_collection = getenv("MONGO_COLLECTION");

try {
    $client = new Client($mongo_uri);
    $database = $client->selectDatabase($mongo_db_name);
    $collection = $database->selectCollection($mongo_collection);

    echo "Conexión exitosa a MongoDB Atlas!";
} catch (Exception $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
