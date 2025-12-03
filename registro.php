<?php
session_start();
require_once("database/connection.php");
$db = new Database;
$con = $db-> conectar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reporte Usuarios</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="stylesheet" href="controller/css/style3.css">
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
                <div class="text-center mt-2">
                    <img src="controller/img/riot_icono1.png" alt="Logo" width="120" class="img-fluid">
                </div>
                <h2 class="mb-4 text-center fw-bold mt-3">REGISTRATE</h2>
                <form id="registro" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 col-md-8 text-center mx-auto">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="number" class="form-control" id="documento" name="documento" class="form-control" placeholder="Tu Documento" required>
                    </div>
                    <div class="mb-3 col-md-8 text-center mx-auto">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" class="form-control" placeholder="Tu Nombre" required>
                    </div>
                    <div class="mb-3 col-md-8 text-center mx-auto">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" class="form-control" placeholder="Tu Apellido" required>
                    </div>
                    <div class="mb-3 col-md-8 text-center mx-auto">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" class="form-control" placeholder="example@mail.com" required>
                    </div>
                    <div class="mb-3 col-md-8 text-center mx-auto">
                        <label for="dinero" class="form-label">Dinero</label>
                        <input type="number" class="form-control" id="dinero" name="dinero" class="form-control" placeholder="Ingresa Dinero" required>
                    </div>
                    <div class="mb-3 col-md-8 text-center mx-auto">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" class="form-control" placeholder="********" required>
                    </div>
                    <button type="submit" class="btn btn-custom w-75 d-block mx-auto mt-4 mb-2">Crear Cuenta</button>
                    <button type="button" onclick="window.location.href='index.php'" class="btn btn-outline-secondary w-75 d-block mx-auto mt-2 volver">Volver</button>
                </form>
            </div>

            <!-- Lado Derecho (Video) -->
            <div class="col-md-6 p-0 right-section">
                <video id="videoFondo" autoplay muted loop>
                    <source src="controller/multimedia/Animaciones/Valo-login.mp4" type="video/mp4">
                    Tu navegador no soporta el video.
                </video>
                <button id="toggleSound"
                    class="btn btn-light rounded-circle position-absolute bottom-0 end-0 m-3 shadow">
                    <i class="bi bi-volume-mute-fill"></i>
                </button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const form = document.getElementById('registro');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('documento', document.getElementById('documento').value);
            formData.append('nombre', document.getElementById('nombre').value);
            formData.append('apellido', document.getElementById('apellido').value);
            formData.append('correo', document.getElementById('correo').value);
            formData.append('dinero', document.getElementById('dinero').value);
            formData.append('contrasena', document.getElementById('contrasena').value);

            try {
                const response = await fetch('registrar_usuarios.php', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (result.message) {
                    alert(result.message);
                    limpiarFormulario();
                    window.location.href = 'index.php';

                } else if (result.error) {
                    alert(result.error);
                }
            } catch (error) {
                console.error(error);
                alert('Error al conectar con el servidor.');
            }
        });

        function limpiarFormulario() {
            document.getElementById('documento').value = '';
            document.getElementById('nombre').value = '';
            document.getElementById('apellido').value = '';
            document.getElementById('correo').value = '';
            document.getElementById('contrasena').value = '';
            document.getElementById('dinero').value = '';
        }
    </script>
</body>

</html>