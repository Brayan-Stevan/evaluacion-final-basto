<?php
session_start();
require_once("database/connection.php");
$db = new Database;
$con = $db->conectar();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recibir datos del formulario
        $documento = trim($_POST['documento']);
        $nombre = trim($_POST['nombre']);
        $apellido = trim($_POST['apellido']);
        $correo = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);
        $dinero = trim($_POST['dinero']);

        // Verificar que no exista el usuario o el correo
        $sql = $con->prepare("SELECT * FROM user WHERE id_user = '$documento' OR correo = '$correo'");
        $sql->execute();
        $fila = $sql->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            echo json_encode(["error" => "El documento o correo ya están registrados"]);
            exit;

        } else if ($documento == '' || $nombre == "" || $apellido == "" || $correo == "" || $contrasena == "" || $dinero == "") {
            echo json_encode(["error" => "Por favor diligencie todos los datos"]);
            exit;
            
        } else {
            $pass_cifrado = password_hash($contrasena, PASSWORD_DEFAULT, array("cost" => 12));

            $id_tipo_user = 2; // Cliente

            $sql = $con->prepare("INSERT INTO user (id_user, nombre, apellido, correo, contrasena, id_tipo_user, dinero)
            VALUES ('$documento', '$nombre', '$apellido', '$correo', '$pass_cifrado', '$id_tipo_user', '$dinero')");
            $sql->execute();
            echo json_encode(["message" => "Usuario registrado correctamente."]);
            exit;
        }
        
    } else {
        echo json_encode(['error' => 'Método no permitido.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}
?>
