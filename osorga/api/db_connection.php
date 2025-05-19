<?php
require '../vendor/autoload.php'; // Carga el autoloader de Composer

use MongoDB\Client;


try {
    // Conexión a MongoDB local
    $mongoClient = new Client("mongodb+srv://cesar:mangos123@osorga.uklcmd1.mongodb.net/");

    // Selecciona una base de datos (ajusta el nombre según tu proyecto)
    $database = $mongoClient->selectDatabase("toolcrib");
    

    // Opcional: puedes imprimir un mensaje para verificar que funciona
    
$C_articulos = $database->selectCollection("articulos");
$C_tags = $database->selectCollection("tags");
$C_log = $database->selectCollection("log");

} catch (Exception $e) {
    die("Error de conexión a MongoDB: " . $e->getMessage());
}
?>
