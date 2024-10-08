<?php
session_start();
require '../includes/db.php'; 
require '../controllers/AuthController.php'; 

$error_message = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role']; 

    // Validar que el nombre de usuario no exista
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $existing_user = $stmt->fetch();

    if ($existing_user) {
        $error_message = 'El nombre de usuario o correo electrónico ya está en uso.';
    } elseif (!isValidPassword($password)) {
        $error_message = 'La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, un número y un símbolo.';
    } else {
        // Llamar a la función de registro
        $message = registerUser($pdo, $username, $password, $email, $role); 
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        .login-container {
            display: flex;
            height: 100vh;
        }
        .login-image {
            background-image: url('../assets/img/login-image.png'); 
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
                <h2>Regístrate</h2>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($message)): ?>
                    <div class="alert alert-success">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="register.php">
                    <div class="form-group">
                        <label for="username">Nombre de usuario</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <input type="hidden" name="role" value="user"> <!-- Se puede ajustar según el rol -->
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <p class="mt-3">¿Ya tienes una cuenta? <a href="../index.php">Inicia sesión aquí</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>












