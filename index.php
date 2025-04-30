<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visualizador de Modelos 3D</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Three.js y complementos -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="d-flex flex-column flex-md-row" style="height: 100vh; overflow: hidden;">
  <div id="modelSelector" class="bg-dark text-light p-2" style="width: 200px;">
    <!-- Dinámicamente botones o dropdown -->
  </div>

  <div id="viewer" class="flex-grow-1 position-relative d-flex justify-content-center align-items-center" style="
  border:2px solid gray; border-radius: 15px;">
    <!-- Three.js canvas va aquí -->
  </div>
</div>

<script src="script.js"></script>

</body>
</html>
