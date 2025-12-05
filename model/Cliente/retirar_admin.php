<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;
$con = $db->conectar();

$id_cliente = $_SESSION['id_user'];

$sql = $con->prepare("SELECT Dinero FROM user WHERE id_user = ?");
$sql->execute([$id_cliente]);
$cliente = $sql->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['retirar'])) {
    $monto = floatval($_POST['monto']);

    // Validar monto
    if ($monto > 0 && $monto <= $cliente['Dinero']) {

        // RESTAR DINERO AL CLIENTE
        $sql = $con->prepare("UPDATE user SET Dinero = Dinero - ? WHERE id_user = ?");
        $sql->execute([$monto, $id_cliente]);

        // REGISTRAR EN MOVIMIENTOS (monto NEGATIVO)
        $mov = $con->prepare("
            INSERT INTO movimientos (id_emisor, id_receptor, monto)
            VALUES (?, ?, ?)
        ");
        $mov->execute([$id_cliente, $id_cliente, -$monto]);

        header("Location: index.php?success=1");
        exit();
    } else {
        $error = "Monto inválido o saldo insuficiente.";
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

<h3 class="mb-4 text-center">Retirar dinero</h3>

<div class="card p-4 shadow">
    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Saldo actual:</label>
            <input type="text" class="form-control" value="$<?= number_format($cliente['Dinero'], 2) ?>" disabled>
        </div>

        <div class="mb-3">
            <label>Monto a retirar</label>
            <input type="number" name="monto" class="form-control" placeholder="Ej: 20000" required>
        </div>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <button type="submit" name="retirar" class="btn btn-danger w-100">Retirar</button>
    </form>
</div>

</body>
</html>
