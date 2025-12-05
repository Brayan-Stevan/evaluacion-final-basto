<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;
$con = $db->conectar();

$emisor = $_SESSION['id_user'];
$receptor = intval($_POST['receptor']); 
$monto = intval($_POST['monto']);

if ($monto <= 0) {
    die("Monto inválido");
}

// Obtener saldo del emisor
$sql = $con->prepare("SELECT Dinero FROM user WHERE id_user = ?");
$sql->execute([$emisor]);
$dataEmisor = $sql->fetch(PDO::FETCH_ASSOC);

if ($dataEmisor['Dinero'] < $monto) {
    die("Saldo insuficiente");
}

try {
    $con->beginTransaction();

    // Restar a emisor
    $sql1 = $con->prepare("UPDATE user SET Dinero = Dinero - ? WHERE id_user = ?");
    $sql1->execute([$monto, $emisor]);

    // Sumar a receptor
    $sql2 = $con->prepare("UPDATE user SET Dinero = Dinero + ? WHERE id_user = ?");
    $sql2->execute([$monto, $receptor]);

   
    $insert = $con->prepare("
        INSERT INTO movimientos (id_emisor, id_receptor, monto)
        VALUES (?, ?, ?)
    ");
    $insert->execute([$emisor, $receptor, $monto]);
    $con->commit();

    // Actualizar sesión
    $_SESSION['Dinero'] -= $monto;

    echo "<script>alert('Transferencia realizada correctamente'); window.location='index.php';</script>";

} catch (Exception $e) {
    $con->rollBack();
    die("Error en la transacción: " . $e->getMessage());
}
