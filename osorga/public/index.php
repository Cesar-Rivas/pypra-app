<?php include '../bootstrap.php'; ?>
<?php include '../partials/header.php'; ?>

<div class="container py-3">
    <div class="mb-3">
        <h2 class="h4">Inventario de Herramientas</h2>
        <!-- <input type="text" class="form-control form-control-sm" placeholder="Buscar..." id="search-input"
            style="max-width: 60%;"> -->
    </div>

    <div class="row" id="inventory-container">
        <!-- Mobile cards will load here -->
        <!-- Sample card -->
        <?php
$counter = 0;
$articulos = $C_articulos->find([], ['sort' => ['nombre' => 1]]);

    function base64Image($img) {
        return 'data:' . $img['mime'] . ';base64,' . base64_encode($img['data']->getData());
    }
foreach ($articulos as $articulo):
    $carouselId = 'carouselItem_' . $counter++;
    $tags = explode(',', $articulo['tags']);
    $img1 = $articulo['foto1'] ?? null;
    $img2 = $articulo['foto2'] ?? null;

?>
<div class="col-12 col-lg-3 pb-2">
  <div class="card shadow-sm h-100">
    <div class="card-header text-center bg-white border-0 pb-0">
      <h5 class="card-title mb-0"><?= htmlspecialchars($articulo['nombre']) ?></h5>
    </div>

    <div class="row g-0">
      <!-- Carousel -->
      <div class="col-4 col-lg-12 text-center p-2">
        <div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php if ($img1): ?>
              <div class="carousel-item active">
                <img src="<?= base64Image($img1) ?>" class="d-block w-100"
                     style="max-height: 150px; object-fit: contain;" alt="Imagen 1">
              </div>
            <?php endif; ?>
            <?php if ($img2): ?>
              <div class="carousel-item <?= $img1 ? '' : 'active' ?>">
                <img src="<?= base64Image($img2) ?>" class="d-block w-100"
                     style="max-height: 150px; object-fit: contain;" alt="Imagen 2">
              </div>
            <?php endif; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>
      </div>

      <!-- Body -->
      <div class="col-8 col-lg-12">
        <div class="card-body py-2 px-3">
          <p class="card-text small text-muted mb-2 text-center">
            <?= htmlspecialchars($articulo['desc']) ?>
          </p>

          <p class="card-text small text-muted mb-2 text-center">
            <?php foreach ($tags as $tag): ?>
              <span class="badge bg-secondary"><?= htmlspecialchars($tag) ?></span>
            <?php endforeach; ?>
          </p>

          <p class="text-center mb-3">
            <span class="card-text small text-muted">Disponibles: <?= $articulo['disp'] ?></span>
            <span> , </span>
            <span class="card-text small text-muted">En existencia: <?= $articulo['inv'] ?></span>
          </p>

          <div class="row g-2">
            <div class="col-6">
              <button class="btn btn-outline-danger btn-sm w-100">
                <i class="bi bi-dash-circle"></i> Retirar
              </button>
            </div>
            <div class="col-6">
              <button class="btn btn-outline-success btn-sm w-100">
                <i class="bi bi-plus-circle"></i> Agregar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>






    </div>


</div>

<?php include '../partials/modals.php'; ?>
<?php include '../partials/footer.php'; ?>