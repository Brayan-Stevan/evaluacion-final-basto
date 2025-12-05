<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;
$con = $db->conectar();

$id_admin = $_SESSION['id_user'];

// Obtener datos del admin
$sql = $con->prepare("SELECT Dinero FROM user WHERE id_user = ?");
$sql->execute([$id_admin]);
$admin = $sql->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['consignar'])) {
    $monto = floatval($_POST['monto']);

    if ($monto > 0) {

        // SUMAR DINERO AL CLIENTE
        $sql = $con->prepare("UPDATE user SET Dinero = Dinero + ? WHERE id_user = ?");
        $sql->execute([$monto, $id_admin]);
        header("Location: index.php?success=1");
        exit();

    } else {
        $error = "Monto inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Retirar dinero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <a class="navbar-brand fw-bold" href="index.php">← Volver</a>

<h3 class="mb-4 text-center">Consignar Dinero</h3>

<div class="card p-4 shadow">
    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Saldo actual:</label>
            <input type="text" class="form-control" value="$<?= number_format($admin['Dinero'], 2) ?>" disabled>
        </div>

        <div class="mb-3">
            <label>Monto a Consignar</label>
            <input type="number" name="monto" class="form-control" placeholder="Ej: 20000" required>
        </div>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <button type="submit" name="consignar" class="btn btn-success w-100">Consignar</button>
    </form>
</div>

</body>
</html>
