<?php
session_start();
require_once 'conexion.php';

if (isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = trim($_POST['nickname'] ?? '');
    
    if (empty($nickname)) {
        $error = "Por favor ingresa tu nickname.";
    } else {
        $query = "SELECT u.id_usuario, u.nickname, u.nombre, u.activo, r.id_rol, r.nombre AS rol_nombre 
                  FROM usuario u 
                  JOIN rol r ON u.id_rol = r.id_rol 
                  WHERE u.nickname = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("s", $nickname);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $usuario = $result->fetch_assoc();
                // Iniciar sesión
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nickname'] = $usuario['nickname'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['rol_activo'] = $usuario['id_rol'];
                $_SESSION['rol_nombre'] = $usuario['rol_nombre'];
                $_SESSION['usuario_activo'] = $usuario['activo'];
                
                header("Location: index.php");
                exit;
            } else {
                $error = "Nickname incorrecto o no existe.";
            }
            $stmt->close();
        } else {
            $error = "Error de conexión con la base de datos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
    <style>
        .login-container {
            max-width: 400px;
            margin: 10vh auto;
            padding: 0 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="admin-card">
            <h2 class="page-title" style="margin-bottom: 20px; font-size: 1.5rem;">Iniciar Sesión</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php" class="form-group">
                <label for="nickname">Nickname de acceso</label>
                <input type="text" id="nickname" name="nickname" required placeholder="Ej: aetchegaray" style="margin-bottom: 20px;">
                
                <button type="submit" class="btn-primary" style="width: 100%;">Ingresar al Sistema</button>
            </form>
            <div style="margin-top: 20px; text-align: center; color: var(--text-muted); font-size: 0.85rem;">
                <p>Usa uno de los nicknames de prueba:<br>aetchegaray (Admin)<br>lmartinez (Editor)<br>sgomez (Lector)</p>
            </div>
        </div>
    </div>
</body>
</html>
