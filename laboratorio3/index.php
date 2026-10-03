<?php
// Habilitamos el permiso antes de llamar a los includes protegidos
define('INCLUDED_FROM_APP', true);
require 'includes/header.php';
?>

<main class="flex-grow-1 py-5">
    <section class="container" style="max-width: 600px;">

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">Formulario de Registro de Aspirantes</h2>

                <form action="procesar.php" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre (Requerido):</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            placeholder="Ej: María" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label fw-bold">Apellido (Requerido):</label>
                        <input type="text" class="form-control" id="apellido" name="apellido"
                            placeholder="Ej: González" required>
                    </div>

                    <div class="mb-3">
                        <label for="identificacion" class="form-label fw-bold">Identificación (Requerido):</label>
                        <input type="text" class="form-control" id="identificacion" name="identificacion"
                            placeholder="Ej: 8-123-4567" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label fw-bold">Fecha de Nacimiento (Requerido):</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Sexo (Requerido):</label>
                        <div class="btn-group w-100" role="group" aria-label="Sexo">
                            <input type="radio" class="btn-check" name="sexo" id="sexo_h" value="Hombre" required>
                            <label class="btn btn-outline-primary" for="sexo_h">Hombre</label>

                            <input type="radio" class="btn-check" name="sexo" id="sexo_m" value="Mujer" required>
                            <label class="btn btn-outline-primary" for="sexo_m">Mujer</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="form-label fw-bold">Fotografía del Aspirante (png, jpg, jpeg, gif):</label>
                        <input type="file" class="form-control" id="foto" name="foto"
                            accept=".png,.jpg,.jpeg,.gif,.webp" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Registrar Aspirante</button>

                </form>
            </div>
        </div>

    </section>
</main>

<?php
require 'includes/footer.php';
?>
