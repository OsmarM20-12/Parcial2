<?php

$host = "localhost";
$usuario = "root";
$password = "1234";
$baseDatos = "postes_db";

try {
    $conexion = new PDO(
        "mysql:host=$host;dbname=$baseDatos;charset=utf8mb4",
        $usuario,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if (isset($_POST["guardar"])) {

    $numero = $_POST["numero_poste"];
    $fecha = $_POST["fecha_registro"];
    $direccion = $_POST["direccion"];
    $departamento = $_POST["departamento"];
    $municipio = $_POST["municipio"];
    $referencia = $_POST["referencia"];
    $latitud = $_POST["latitud"];
    $longitud = $_POST["longitud"];

    $sql = "INSERT INTO postes
    (numero_poste, fecha_registro, direccion, departamento, municipio, referencia, latitud, longitud)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $consulta = $conexion->prepare($sql);

    $consulta->execute([
        $numero,
        $fecha,
        $direccion,
        $departamento,
        $municipio,
        $referencia,
        $latitud,
        $longitud
    ]);

    header("Location: postes.php");
    exit;
}

$consulta = $conexion->query("SELECT * FROM postes ORDER BY id DESC");
$postes = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Postes</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="contenedor">

    <div class="titulo">
        <h1>Registro de Postes</h1>
    </div>

    <div class="formulario">

        <h2>Nuevo poste</h2>

        <form method="POST" action="postes.php">

            <div class="campo">
                <label>No. de poste</label>
                <input type="text" name="numero_poste" required>
            </div>

            <div class="campo">
                <label>Fecha de registro</label>
                <input type="date" name="fecha_registro" required>
            </div>

            <div class="campo">
                <label>Dirección</label>
                <input type="text" name="direccion" required>
            </div>

            <div class="campo">
                <label>Departamento</label>

                <select name="departamento" required>
                    <option value="Zacapa">Zacapa</option>
                </select>
            </div>

            <div class="campo">
                <label>Municipio</label>

                <select name="municipio" required>
                    <option value="">Seleccione</option>
                    <option value="Zacapa">Zacapa</option>
                    <option value="Estanzuela">Estanzuela</option>
                    <option value="Río Hondo">Río Hondo</option>
                    <option value="Gualán">Gualán</option>
                    <option value="Teculután">Teculután</option>
                    <option value="Usumatlán">Usumatlán</option>
                    <option value="Cabañas">Cabañas</option>
                    <option value="San Diego">San Diego</option>
                    <option value="La Unión">La Unión</option>
                    <option value="Huité">Huité</option>
                    <option value="San Jorge">San Jorge</option>
                </select>
            </div>

            <div class="campo">
                <label>Referencia</label>
                <input type="text" name="referencia">
            </div>

            <div class="campo">
                <label>Latitud</label>
                <input type="number" step="any" name="latitud">
            </div>

            <div class="campo">
                <label>Longitud</label>
                <input type="number" step="any" name="longitud">
            </div>

            <button type="submit" name="guardar">
                Guardar
            </button>

        </form>

    </div>

    <div class="registros">

        <div class="encabezado-tabla">
            <h2>Postes registrados</h2>
            <span><?php echo count($postes); ?> registros</span>
        </div>

        <div class="tabla">

            <table>

                <thead>

                <tr>
                    <th>No. Poste</th>
                    <th>Fecha</th>
                    <th>Dirección</th>
                    <th>Municipio</th>
                    <th>Referencia</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                </tr>

                </thead>

                <tbody>

                <?php foreach ($postes as $poste) { ?>

                    <tr>
                        <td><?php echo $poste["numero_poste"]; ?></td>
                        <td><?php echo $poste["fecha_registro"]; ?></td>
                        <td><?php echo $poste["direccion"]; ?></td>
                        <td><?php echo $poste["municipio"]; ?></td>
                        <td><?php echo $poste["referencia"]; ?></td>
                        <td><?php echo $poste["latitud"]; ?></td>
                        <td><?php echo $poste["longitud"]; ?></td>
                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>