<?php
session_start();
require 'includes/db.php';
require 'controllers/AuthController.php'; 

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Llamar a la función para autenticar el usuario
    $role = loginUser($pdo);
    
    if ($role === 'admin') {
        // Redirigir al panel de administración
        header("Location: views/admin.php");
        exit;
    } elseif ($role === 'user') {
        // Redirigir al panel de usuario
        header("Location: views/user.php");
        exit;
    } else {
        // Si loginUser devuelve un error, lo asignamos al mensaje de error
        $error_message = 'Nombre de usuario o contraseña incorrectos.'; // Mensaje de error
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .login-container {
            display: flex;
            height: 100vh;
        }
        .login-image {
            background-image: url('assets/img/login-image.png'); 
            background-size: cover;
            background-position: center;
            width: 50%;
        }
        .login-form {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            width: 80%;
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-form">
            <div class="login-box">
                <h2>Iniciar Sesión</h2>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="index.php">
                    <div class="form-group">
                        <label for="username">Nombre de usuario</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    <p class="mt-3">¿No tienes una cuenta? <a href="views/register.php">Regístrate aquí</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>












