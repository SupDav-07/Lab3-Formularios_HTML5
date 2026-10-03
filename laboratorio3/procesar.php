<?php
// Habilitamos el permiso antes de llamar a los includes protegidos
define('INCLUDED_FROM_APP', true);
require 'includes/header.php';

$errores = [];
$datos = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ---------------------------------------------------------
    // 1. SANEAMIENTO Y SEGURIDAD (evitar XSS, limpiar etiquetas)
    // ---------------------------------------------------------
    $nombre          = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido        = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
    $identificacion  = isset($_POST['identificacion']) ? trim($_POST['identificacion']) : '';
    $fechaNacimiento = isset($_POST['fecha_nacimiento']) ? trim($_POST['fecha_nacimiento']) : '';
    $sexo            = isset($_POST['sexo']) ? trim($_POST['sexo']) : '';

    $nombre         = htmlspecialchars(strip_tags($nombre));
    $apellido       = htmlspecialchars(strip_tags($apellido));
    $identificacion = htmlspecialchars(strip_tags($identificacion));
    $sexo           = htmlspecialchars(strip_tags($sexo));

    // ---------------------------------------------------------
    // 2. VALIDAR QUE LOS CAMPOS NO ESTÉN VACÍOS
    // ---------------------------------------------------------
    if ($nombre === '')          $errores[] = 'El nombre es requerido.';
    if ($apellido === '')        $errores[] = 'El apellido es requerido.';
    if ($identificacion === '')  $errores[] = 'La identificación es requerida.';
    if ($fechaNacimiento === '') $errores[] = 'La fecha de nacimiento es requerida.';
    if ($sexo === '')            $errores[] = 'El sexo es requerido.';

    // ---------------------------------------------------------
    // 3. NORMALIZACIÓN Y LIMPIEZA
    //    Nombre y Apellido -> Formato Tipo Título
    //    Identificación -> Mayúsculas
    // ---------------------------------------------------------
    $nombre         = ucwords(strtolower($nombre));
    $apellido       = ucwords(strtolower($apellido));
    $identificacion = strtoupper($identificacion);

    // ---------------------------------------------------------
    // 4. CALCULAR LA EDAD Y VALIDAR RANGO (18 a 70 años)
    // ---------------------------------------------------------
    $edad = null;
    if ($fechaNacimiento !== '') {
        try {
            $hoy = new DateTime();
            $nacimiento = new DateTime($fechaNacimiento);
            $edad = $hoy->diff($nacimiento)->y;

            if ($edad < 18 || $edad > 70) {
                $errores[] = 'La edad del aspirante debe estar entre 18 y 70 años. Edad calculada: ' . $edad . ' años.';
            }
        } catch (Exception $e) {
            $errores[] = 'La fecha de nacimiento no es válida.';
        }
    }

    // ---------------------------------------------------------
    // 5. VALIDAR Y GUARDAR LA FOTOGRAFÍA
    // ---------------------------------------------------------
    $rutaFotoGuardada = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

        $nombreOriginal = $_FILES['foto']['name'];
        $tmpPath        = $_FILES['foto']['tmp_name'];

        $partesNombre = explode('.', $nombreOriginal);
        $extension    = strtolower(end($partesNombre));

        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($extension, $extensionesPermitidas)) {
            $errores[] = 'Formato de imagen no permitido. Usa jpg, jpeg, png, gif o webp.';
        } else {
            // Nombre de archivo único y seguro (evita sobrescribir o inyectar rutas)
            $nuevoNombre = md5(time() . $nombreOriginal) . '.' . $extension;
            $carpetaDestino = './uploaded_files/';
            $rutaDestino = $carpetaDestino . $nuevoNombre;

            if (move_uploaded_file($tmpPath, $rutaDestino)) {
                $rutaFotoGuardada = $rutaDestino;
            } else {
                $errores[] = 'Ocurrió un error al guardar la fotografía.';
            }
        }
    } else {
        $errores[] = 'Debes adjuntar una fotografía del aspirante.';
    }

    $datos = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'identificacion' => $identificacion,
        'fecha_nacimiento' => $fechaNacimiento,
        'edad' => $edad,
        'sexo' => $sexo,
        'foto' => $rutaFotoGuardada,
    ];
}
?>

<main class="flex-grow-1 py-5">
    <section class="container" style="max-width: 600px;">
        <div class="card shadow-sm">
            <div class="card-body p-4">

                <?php if (!empty($errores)): ?>
                    <h2 class="card-title text-danger mb-3">No se pudo completar el registro</h2>
                    <ul class="alert alert-danger">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="index.php" class="btn btn-secondary w-100">Volver al formulario</a>

                <?php else: ?>
                    <h2 class="card-title text-success mb-3">¡Aspirante Registrado con Éxito!</h2>
                    <table class="table table-bordered">
                        <tr><th>Nombre</th><td><?php echo $datos['nombre']; ?></td></tr>
                        <tr><th>Apellido</th><td><?php echo $datos['apellido']; ?></td></tr>
                        <tr><th>Identificación</th><td><?php echo $datos['identificacion']; ?></td></tr>
                        <tr><th>Fecha de Nacimiento</th><td><?php echo $datos['fecha_nacimiento']; ?></td></tr>
                        <tr><th>Edad</th><td><?php echo $datos['edad']; ?> años</td></tr>
                        <tr><th>Sexo</th><td><?php echo $datos['sexo']; ?></td></tr>
                    </table>

                    <?php if ($datos['foto']): ?>
                        <p class="fw-bold">Fotografía:</p>
                        <img src="<?php echo $datos['foto']; ?>" alt="Foto del aspirante" class="img-fluid rounded mb-3" style="max-width: 200px;">
                    <?php endif; ?>

                    <a href="index.php" class="btn btn-primary w-100">Registrar otro aspirante</a>
                <?php endif; ?>

            </div>
        </div>
    </section>
</main>

<?php
require 'includes/footer.php';
?>
