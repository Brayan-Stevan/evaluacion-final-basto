<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;
$con = $db->conectar();

$id_cliente   = $_SESSION['id_user'];

// Obtener datos del cliente
$sqlA = $con->prepare("SELECT Dinero FROM user WHERE id_user = ?");
$sqlA->execute([$id_cliente]);
$cliente = $sqlA->fetch(PDO::FETCH_ASSOC);

$sql = $con->prepare("SELECT id_user, nombre, apellido, Dinero FROM user WHERE id_user = ?");
$sql->execute([$id_cliente]);
$clie = $sql->fetch(PDO::FETCH_ASSOC);

// Consultar usuarios tipo cliente (tipo = 2)

if (isset($_POST['cerrar'])) {
  session_unset();   // elimina las variables de sesión
  session_destroy(); // destruye la sesión
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
        <a href="retirar_admin.php?id=<?= $id_admin ?>" class="btn btn-warning btn-sm">Retirar</a>
        <a href="consignar_admin.php?id=<?= $id_admin ?>" class="btn btn-warning btn-sm">Consignar</a>
            <span class="badge bg-primary ms-2">
                <?= $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] ?>
            </span>
            <span class="fw-bold">Admin</span>
            <span class="badge bg-success ms-2">$<?= number_format($cliente['Dinero'], 2) ?></span>
        </div>
    </nav>

    <div class="container mt-5">

        <h2 class="mb-4 text-center fw-bold">NEQUI</h2>

        <div class="card shadow">
            <div class="card-body">

                <table class="table table-striped table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($cliente as $cli): ?>
                            <tr>
                                <td><?= $cli['id_user'] ?></td>
                                <td><?= $cli['nombre'] ?></td>
                                <td><?= $cli['apellido'] ?></td>
                                <td><?= $cli['correo'] ?></td>
                                <td>
                                    <a href="transaccion_cliente.php?id=<?= $cli['id_user'] ?>" class="btn btn-success btn-sm">Transaccion</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</body>

</html>