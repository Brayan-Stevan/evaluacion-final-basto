<?php
session_start();
require_once("database/connection.php");
$db = new Database;
$con = $db->conectar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Inicio Usuarios</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="shortcut icon" href="controller/multimedia/img/icono_valorant.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="login-custom1">
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Lado Izquierdo (Formulario) -->
            <div class="col-md-6 left-section">
                <div class="text-center">
                    <img src="controller/img/logo-black1.png" alt="Logo" width="300" class="img-fluid">
                </div>
                <div class="text-center mt-3">
                    <img src="controller/img/riot_icono1.png" alt="Logo" width="120" class="img-fluid">
                </div>
                <h2 class="jugar mb-4 text-center fw-bold mt-2">INICIAR SESIÓN</h2>

                <form id="login" method="POST">
                    <div class="mb-2 col-md-8 text-center mx-auto">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="number" class="form-control py-2" id="documento" name="documento" class="form-control" placeholder="Tú Documento" required>
                    </div>
                    <div class="mb-2 col-md-8 text-center mx-auto">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="password" class="form-control py-2" id="contrasena" name="contrasena" class="form-control" placeholder="********" required>
                    </div>
                    <div class="mad">
                        <div class="mb-2 col-md-3 ms-auto">
                            <a href="registro.php" class="link-secondary text-decoration-none">Crear cuenta</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-custom w-75 d-block mx-auto mt-3 mb-2 ">Iniciar Sesión</button>
                    <button type="button" onclick="window.location.href='index.php'" class="btn btn-outline-secondary w-75 d-block mx-auto mt-2 volver">Volver</button>
                </form>
            </div>

            <!-- Lado Derecho (Video) -->
            <div class="col-md-6 p-0 right-section">
                <video id="videoFondo" autoplay muted loop>
                    <source src="controller/multimedia/Animaciones/valorant-login.mp4" type="video/mp4">
                    Tu navegador no soporta el video.
                </video>
                <button id="toggleSound"
                    class="btn btn-light rounded-circle position-absolute bottom-0 end-0 m-3 shadow">
                    <i class="bi bi-volume-mute-fill"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('login');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('documento', document.getElementById('documento').value);
            formData.append('contrasena', document.getElementById('contrasena').value);

            try {
                const response = await fetch('iniciar_sesion.php', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (result.entrar) {
                    window.location.href = result.redirect; // redirige según el tipo
                } else if (result.error) {
                    alert(result.error);
                    limpiarFormulario();
                }
            } catch (error) {
                console.error(error);
                alert('Error al conectar con el servidor.');
            }
        });

        function limpiarFormulario() {
            document.getElementById('documento').value = '';
            document.getElementById('contrasena').value = '';
        }
    </script>
</body>

</html>