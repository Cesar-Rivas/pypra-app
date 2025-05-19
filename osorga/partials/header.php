<?php
include_once "../api/db_connection.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tool Crib</title>
  <link rel="icon" type="image/x-icon" href="assets/media/favicon.svg">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/add-edit.css">

</head>
<body>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
  <div class="container-fluid">

    <!-- Logo Only -->
    <a class="navbar-brand" href="index.php">
      <img src="assets/media/toolcrib_logo.svg" alt="Tool Crib Logo" height="55" style="filter: brightness(0) invert(1);">
    </a>

    <!-- Mobile Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"  style="position:absolute; right:5%">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation Items -->
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="index.php" class="btn btn-outline-light btn-sm mt-2 mt-lg-0 ms-lg-2">
            Inventario
          </a>
        </li>
        <li class="nav-item">
          <a href="add_edit.php" class="btn btn-outline-light btn-sm mt-2 mt-lg-0 ms-lg-2">
            Añadir artículo
          </a>
        </li>
      </ul>
    </div>

  </div>
</nav>

