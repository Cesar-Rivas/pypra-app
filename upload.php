<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "models/";

    if (isset($_POST['fileName']) && !empty($_POST['fileName'])) {
        $fileName = preg_replace("/[^a-zA-Z0-9_\-]/", "", $_POST['fileName']);
    } else {
        die("<p style='color: red;'>Error: Debes proporcionar un nombre válido para el archivo.</p>");
    }

    if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
        $tempFile = $_FILES['fileUpload']['tmp_name'];
        $originalFile = $_FILES['fileUpload']['name'];
        $fileExtension = strtolower(pathinfo($originalFile, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, ['step', 'stp'])) {
            die("<p style='color: red;'>Error: Solo se permiten archivos con extensión .step o .stp.</p>");
        }

        // Preparar archivo para enviar
        $fileToUpload = curl_file_create($tempFile, 'application/octet-stream', $originalFile);

        $url = "https://imagetostl.com/api/convert";
        $postFields = [
            'file' => $fileToUpload,
            'format' => 'gltf'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 🔥 Ignorar verificación SSL en local

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }

        curl_close($ch);

        if (isset($error_msg)) {
            die("<p style='color: red;'>Error en cURL: " . htmlspecialchars($error_msg) . "</p>");
        }

        if ($response) {
            $convertedFile = $targetDir . $fileName . ".gltf";
            file_put_contents($convertedFile, $response);

            echo "<p style='color: green;'>El archivo se convirtió y guardó correctamente como: " . htmlspecialchars($convertedFile) . "</p>";
        } else {
            die("<p style='color: red;'>Error: No se recibió respuesta del servidor de conversión.</p>");
        }
    } else {
        die("<p style='color: red;'>Error: No se seleccionó ningún archivo o hubo un problema al subirlo.</p>");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir y Convertir Archivo STEP/STP a GLTF</title>
</head>
<body>
    <h1>Subir y Convertir Archivo STEP/STP a GLTF</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="fileName">Nombre del archivo:</label>
        <input type="text" id="fileName" name="fileName" required>
        <br><br>

        <label for="fileUpload">Selecciona un archivo STEP o STP:</label>
        <input type="file" id="fileUpload" name="fileUpload" accept=".step,.stp" required>
        <br><br>

        <button type="submit">Subir y Convertir</button>
    </form>
</body>
</html>

