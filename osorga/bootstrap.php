<?php
require __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb+srv://cesar:mangos123@osorga.uklcmd1.mongodb.net/");
$db = $client->toolcrib;
?>