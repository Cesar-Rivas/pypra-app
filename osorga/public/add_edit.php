<?php include '../bootstrap.php'; ?>
<?php include '../partials/header.php'; ?>

<div class="container py-4">
    <h1><?= isset($_GET['id']) ? 'Editar' : 'Registrar' ?> Artículo</h1>

    <form id="item-form" method="POST" action="../api/item.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?? '' ?>">

        <div class="row">
            <!-- Nombre -->
            <div class="col-6 col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-tools"></i></span>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
            </div>

            <!-- Descripción -->
            <div class="col-12 col-md-6 mb-3">
                <label for="desc" class="form-label">Descripción</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                    <textarea class="form-control" id="desc" name="desc" rows="2" style="max-height:50px"
                        required></textarea>
                </div>
            </div>
        </div>


        <!-- Tags -->
        <div class="mb-3">
            <label class="form-label">Etiquetas</label>
            <div class="input-group">
                <!-- Label -->
                <span class="input-group-text">Etiquetas</span>

                <!-- Display area -->
                <span class="form-control d-flex flex-wrap gap-1" id="tag-display" style="min-height: 40px;"></span>

                <!-- Select -->
                <span class="input-group-text p-0">
                    <i class="bi bi-plus-circle text-success px-2"></i>
                    <select id="tag-select" class="form-select form-select-sm border-0 bg-transparent">
                        <option value="">Seleccionar...</option>
                        <option value="__custom">Otro...</option>
                        <?php
$tagsCursor = $C_tags->find([], ['sort' => ['nombre' => 1]]);
foreach ($tagsCursor as $tagDoc) {
    $tagName = htmlspecialchars($tagDoc['nombre']);
    echo "<option value=\"$tagName\">$tagName</option>";
}
?>

                    </select>
                </span>
            </div>
            <!-- Hidden field for submission -->
            <input type="text" name="tags" id="tags-input" hidden>
        </div>
        <!-- Disponibles, Inventario, and Consumible in one row -->
        <div class="row">
            <!-- Disponibles -->
            <div class="col-md-3 mb-3">
                <label for="disp" class="form-label">Disponibles</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-check2-circle"></i></span>
                    <input type="number" class="form-control" id="disp" name="disp" min="0">
                </div>
            </div>

            <!-- Inventario total -->
            <div class="col-md-3 mb-3">
                <label for="inv" class="form-label">En existencia</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-archive"></i></span>
                    <input type="number" class="form-control" id="inv" name="inv" min="0">
                </div>
            </div>
            <script>
            const dispInput = document.getElementById('disp');
            const invInput = document.getElementById('inv');

            function clampToZero(val) {
                return Math.max(0, parseInt(val) || 0);
            }

            function syncDispAndInvFromDisp() {
                let disp = clampToZero(dispInput.value);
                let inv = clampToZero(invInput.value);

                // If disp exceeds inv, bump inv
                if (disp > inv) {
                    inv = disp;
                    invInput.value = inv;
                }

                dispInput.value = disp;
                invInput.value = inv;
            }

            function syncDispAndInvFromInv() {
                let inv = clampToZero(invInput.value);
                let disp = clampToZero(dispInput.value);

                // If inv drops below disp, decrease disp down to match
                if (inv < disp) {
                    disp = Math.max(0, inv);
                    dispInput.value = disp;
                }

                invInput.value = inv;
                dispInput.value = disp;
            }

            dispInput.addEventListener('input', syncDispAndInvFromDisp);
            invInput.addEventListener('input', syncDispAndInvFromInv);
            </script>



            <!-- Consumible switch -->
            <div class="col-md-3 mb-3 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="consumible" name="consumible">
                    <label class="form-check-label" for="consumible">Consumible</label>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- Foto 1 -->
            <div class="col-12 col-md-6 mb-3">
                <label for="foto1" class="form-label">Foto 1</label>
                <div class="input-group align-items-start">
                    <span class="input-group-text"><i class="bi bi-image"></i></span>
                    <input type="file" class="form-control" id="foto1" name="foto1" accept="image/*">

                    <div class="position-relative ms-2" style="width: 80px; height: auto;">
                        <img id="preview1" src="" alt="Preview 1" class="img-thumbnail w-100" style="display: none;">
                        <button type="button" id="clear1" class="img-clear-btn" style="display: none;">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>

                    </div>
                </div>
            </div>

            <!-- Foto 2 -->
            <div class="col-12 col-md-6 mb-3">
                <label for="foto2" class="form-label">Foto 2</label>
                <div class="input-group align-items-start">
                    <span class="input-group-text"><i class="bi bi-image"></i></span>
                    <input type="file" class="form-control" id="foto2" name="foto2" accept="image/*">

                    <div class="position-relative ms-2" style="width: 80px; height: auto;">
                        <img id="preview2" src="" alt="Preview 2" class="img-thumbnail w-100" style="display: none;">
                        <button type="button" id="clear2" class="img-clear-btn" style="display: none;">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>

                    </div>
                </div>
            </div>
        </div>



        <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-save"></i> Guardar
            </button>
        </div>

    </form>
</div>



<?php include '../partials/footer.php'; ?>