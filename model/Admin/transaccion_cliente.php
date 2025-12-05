<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;
$con = $db->conectar();

$id_receptor = $_GET['id'];

if (!$id_receptor) {
    die("ID no válido");
}

$id_emisor = $_SESSION['id_user'];

// Obtener info del receptor
$sql = $con->prepare("SELECT id_user, nombre, apellido, dinero FROM user WHERE id_user = ?");
$sql->execute([$id_receptor]);
$receptor = $sql->fetch(PDO::FETCH_ASSOC);

// Obtener dinero del emisor (admin)
$sql2 = $con->prepare("SELECT dinero, nombre, apellido FROM user WHERE id_user = ?");
$sql2->execute([$id_emisor]);
$emisor = $sql2->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enviar Dinero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<a class="navbar-brand fw-bold" href="index.php">← Volver</a>

<div class="container mt-5">
    <div class="card shadow p-4">

        <h3 class="text-center mb-4">Transferencia de Dinero</h3>

        <p><strong>De:</strong> <?= $emisor['nombre'] . " " . $emisor['apellido'] ?>  
        — <span class="text-success">$<?= $emisor['dinero'] ?></span></p>

        <p><strong>Para:</strong> <?= $receptor['nombre'] . " " . $receptor['apellido'] ?></p>

        <form action="procesar_transaccion.php" method="POST">

            <input type="hidden" name="receptor" value="<?= $id_receptor ?>">

            <label class="form-label">Monto a transferir</label>
            <input type="number" name="monto" placeholder="Ej:20000" class="form-control mb-3" min="1" required>

            <button class="btn btn-primary w-100">Enviar</button>
        </form>

    </div>
</div>

</body>
</html>

