<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['rol_activo']) || ($_SESSION['rol_activo'] != 1 && $_SESSION['rol_activo'] != 2)) {
    header("Location: index.php?error=acceso_denegado");
    exit();
}

if (!isset($_SESSION['usuario_activo']) || $_SESSION['usuario_activo'] != 1) {
    header("Location: index.php?error=usuario_inactivo");
    exit();
}

require_once 'conexion.php';

$error = '';
$usuario = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = (int)$_GET['id'];
    
    // Si la petición es GET, obtener el usuario
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $query = "SELECT * FROM usuario WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $usuario = $result->fetch_assoc();
                if ($usuario['activo'] == 0) {
                    header("Location: index.php?error=usuario_inactivo");
                    exit;
                }
            } else {
                header("Location: index.php");
                exit;
            }
            $stmt->close();
        }
    }
} else {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $nickname = trim($_POST['nickname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $id_rol = $_POST['id_rol'] ?? '';

    // Guardar los datos para mostrarlos en el formulario si hay error
    $usuario = [
        'id_usuario' => $id_usuario,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'nickname' => $nickname,
        'email' => $email,
        'id_rol' => $id_rol
    ];

    if (empty($nombre) || empty($apellido) || empty($nickname) || empty($email) || empty($id_rol)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $query = "UPDATE usuario SET nombre = ?, apellido = ?, nickname = ?, email = ?, id_rol = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssssii", $nombre, $apellido, $nickname, $email, $id_rol, $id_usuario);
            if ($stmt->execute()) {
                header("Location: index.php");
                exit;
            } else {
                $error = "Error al actualizar el usuario: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Error de preparación de consulta: " . $conn->error;
        }
    }
}

$query_roles = "SELECT id_rol, nombre FROM rol";
$result_roles = $conn->query($query_roles);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="admin-container">
        <h1 class="page-title">Editar Usuario</h1>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="admin-card">
            <h2>Modificar datos de usuario</h2>
            <form action="editar.php?id=<?php echo $id_usuario; ?>" method="POST" class="form-grid">
                <div class="form-group">
                    <label for="nombre">Nombre <span style="color: var(--accent-rose);">*</span></label>
                    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="apellido">Apellido <span style="color: var(--accent-rose);">*</span></label>
                    <input type="text" id="apellido" name="apellido" required value="<?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="nickname">Nickname <span style="color: var(--accent-rose);">*</span></label>
                    <input type="text" id="nickname" name="nickname" required value="<?php echo htmlspecialchars($usuario['nickname'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email <span style="color: var(--accent-rose);">*</span></label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group form-group-full">
                    <label for="id_rol">Rol <span style="color: var(--accent-rose);">*</span></label>
                    <select id="id_rol" name="id_rol" required>
                        <option value="">Seleccione un rol...</option>
                        <?php if ($result_roles && $result_roles->num_rows > 0): ?>
                            <?php while ($rol = $result_roles->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($rol['id_rol']); ?>" <?php echo (isset($usuario['id_rol']) && $usuario['id_rol'] == $rol['id_rol']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($rol['nombre']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="form-actions form-group-full" style="gap: 15px;">
                    <button type="submit" class="btn-primary">Actualizar</button>
                    <a href="index.php" class="btn-primary" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); text-decoration: none; display: inline-flex; align-items: center; justify-content: center; box-shadow: none;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
