<?php
session_start();
require_once("database/connection.php");
$db = new Database;
$con = $db->conectar();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $documento = trim($_POST['documento']);
        $contra = trim($_POST['contrasena']);

        $sql = $con->prepare("SELECT * FROM user WHERE id_user = ?");
        $sql->execute([$documento]);
        $fila = $sql->fetch(PDO::FETCH_ASSOC);

        if ($fila) {

            if (password_verify($contra, $fila['contrasena'])) {

                $_SESSION['documento'] = $fila['id_user'];
                $_SESSION['nombre'] = $fila['nombre'];
                $_SESSION['apellido'] = $fila['apellido'];
                $_SESSION['tipo'] = $fila['id_tipo_user'];
                $_SESSION['dinero'] = $fila['Dinero'];
                $_SESSION['id_user'] = $fila['id_user'];

                

                if ($fila['id_tipo_user'] == 1) {
                    echo json_encode([
                        "entrar" => "Bienvenido administrador",
                        "redirect" => "model/Admin/index.php"
                    ]);
                    exit();
                }

                if ($fila['id_tipo_user'] == 2) {
                    echo json_encode([
                        "entrar" => "Bienvenido usuario",
                        "redirect" => "model/Cliente/index.php"
                    ]);
                    exit();
                }
            } else {
                echo json_encode(["error" => "Usuario o contraseña incorrectos."]);
                exit();
            }
        } else {
            echo json_encode(["error" => "El Usuario No Existe"]);
            exit();
        }
    } else {
        echo json_encode(['error' => 'Método no permitido.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}
?>
