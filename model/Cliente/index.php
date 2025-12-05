<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;
$con = $db->conectar();

$id_cliente  = $_SESSION['id_user'];


$sql = $con->prepare("SELECT id_user, nombre, apellido, Dinero FROM user WHERE id_user = ?");
$sql->execute([$id_cliente]);
$clientedatos = $sql->fetch(PDO::FETCH_ASSOC);


$sqlA = $con->prepare("SELECT Dinero FROM user WHERE id_user = ?");
$sqlA->execute([$id_cliente]);
$clientedinero = $sqlA->fetch(PDO::FETCH_ASSOC);

$sql = $con->prepare(" SELECT 
        movimientos.id_movimiento,
        movimientos.monto,
        movimientos.fecha,

        user.nombre AS nombre_emisor,
        user.apellido AS apellido_emisor,

        user2.nombre AS nombre_receptor,
        user2.apellido AS apellido_receptor

        FROM movimientos
        INNER JOIN user ON movimientos.id_emisor = user.id_user
        INNER JOIN user AS user2 ON movimientos.id_receptor = user2.id_user

        WHERE movimientos.id_emisor = ? OR movimientos.id_receptor = ?
        ORDER BY movimientos.fecha DESC
");
$sql->execute([$id_cliente, $id_cliente]);
$clie = $sql->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['cerrar'])) {
  session_unset();   
  session_destroy();
  header("Location: ../../index.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Usuarios Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-4 mb-4">
        <form method="POST">
          <button type="submit" name="cerrar" class="jugar4 mt-1 btn btn-danger boton-custom w-100 btn-sm">Cerrar sesión</button>
        </form>
        <a href="retirar_admin.php?id=<?= $id_cliente ?>" class="btn btn-warning btn-sm">Retirar</a>
        <a href="consignar_admin.php?id=<?= $id_cliente ?>" class="btn btn-warning btn-sm">Consignar</a>
            <span class="badge bg-primary ms-2">
                <?php echo $clientedatos['apellido']; ?>
            </span>
            <span class="fw-bold">Admin</span>
            <span class="badge bg-success ms-2">$<?= number_format($clientedinero['Dinero'], 2) ?></span>
        </div>
    </nav>

    <div class="container mt-5">

        <h2 class="mb-4 text-center fw-bold">NEQUI - MOVIMIENTOS DE <?php echo $clientedatos['nombre']; ?> </h2>

        <div class="card shadow">
            <div class="card-body">

                <table class="table table-striped table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID-Movimiento</th>
                            <th>De</th>
                            <th>Para</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($clie as $mov): ?>
                            <tr>
                                <td><?= $mov['id_movimiento'] ?></td>
                                <td><?= $mov['nombre_emisor'] ?></td>
                                <td><?= $mov['nombre_receptor'] ?></td>
                                <td>$<?= number_format($mov['monto'], 2) ?></td>
                                <td><?= $mov['fecha'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</body>

</html>