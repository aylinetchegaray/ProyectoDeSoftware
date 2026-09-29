<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['usuario_activo']) && $_SESSION['usuario_activo'] == 0) {
    session_destroy();
    die("<div style='font-family: sans-serif; padding: 20px; color: #f43f5e; font-weight: bold;'>Esta cuenta se encuentra inactiva o ha sido dada de baja. Acceso denegado. <a href='login.php'>Volver</a></div>");
}
require_once 'conexion.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $nickname = trim($_POST['nickname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $id_rol = $_POST['id_rol'] ?? '';

    if (empty($nombre) || empty($apellido) || empty($nickname) || empty($email) || empty($id_rol)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $query = "INSERT INTO usuario (nombre, apellido, nickname, email, id_rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssssi", $nombre, $apellido, $nickname, $email, $id_rol);
            if ($stmt->execute()) {
                header("Location: index.php?success=1");
                exit;
            } else {
                $error = "Error al guardar el usuario: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Error de preparación de consulta: " . $conn->error;
        }
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success = "Usuario registrado exitosamente.";
}

$query_roles = "SELECT id_rol, nombre FROM rol";
$result_roles = $conn->query($query_roles);

$vista_inactivos = isset($_GET['vista']) && $_GET['vista'] === 'inactivos';
$activo_filter = $vista_inactivos ? 0 : 1;

$query = "SELECT usuario.*, rol.nombre AS rol_nombre FROM usuario JOIN rol ON usuario.id_rol = rol.id_rol WHERE usuario.activo = $activo_filter ORDER BY usuario.id_usuario DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="admin-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 class="page-title" style="margin-bottom: 0;">Gestión de Usuarios</h1>
            <div style="color: var(--text-secondary); font-size: 0.9rem;">
                Hola, <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong> (<?php echo htmlspecialchars($_SESSION['rol_nombre']); ?>)
                <a href="logout.php" style="margin-left: 15px; color: var(--accent-rose); text-decoration: none; font-weight: 600;">Cerrar sesión</a>
            </div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <!-- Top Box: Form -->
        <?php if ($_SESSION['rol_activo'] == 1): ?>
        <div class="admin-card">
            <h2>Crear usuario</h2>
            <form method="POST" action="index.php" class="form-grid">
                <div class="form-group">
                    <label for="nombre">Nombre <span style="color: var(--accent-rose);">*</span></label>
                    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="apellido">Apellido <span style="color: var(--accent-rose);">*</span></label>
                    <input type="text" id="apellido" name="apellido" required value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="nickname">Nickname <span style="color: var(--accent-rose);">*</span></label>
                    <input type="text" id="nickname" name="nickname" required value="<?php echo htmlspecialchars($_POST['nickname'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email <span style="color: var(--accent-rose);">*</span></label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group form-group-full">
                    <label for="id_rol">Rol <span style="color: var(--accent-rose);">*</span></label>
                    <select id="id_rol" name="id_rol" required>
                        <option value="">Seleccione un rol...</option>
                        <?php if ($result_roles && $result_roles->num_rows > 0): ?>
                            <?php while ($rol = $result_roles->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($rol['id_rol']); ?>" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == $rol['id_rol']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($rol['nombre']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="form-actions form-group-full">
                    <button type="submit" class="btn btn-primary">Crear usuario</button>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- Bottom Box: Table -->
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-xl);">
                <h2 style="margin: 0;"><?php echo $vista_inactivos ? 'Usuarios dados de baja' : 'Listado de usuarios'; ?></h2>
                <?php if ($_SESSION['rol_activo'] == 1): ?>
                    <?php if ($vista_inactivos): ?>
                        <a href="index.php" class="btn-edit" style="margin-bottom: 0; padding: 8px 16px;">Ver usuarios activos</a>
                    <?php else: ?>
                        <a href="index.php?vista=inactivos" class="btn-delete" style="margin-bottom: 0; padding: 8px 16px;">Ver dados de baja</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Nickname</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($row['apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nickname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><span class="badge"><?php echo htmlspecialchars($row['rol_nombre']); ?></span></td>
                                    <td class="table-actions text-center">
                                        <?php if ($vista_inactivos): ?>
                                            <?php if ($_SESSION['rol_activo'] == 1): ?>
                                            <a href="restaurar.php?id=<?php echo $row['id_usuario']; ?>" class="btn-edit" title="Restaurar" onclick="return confirm('¿Está seguro de que desea restaurar este usuario?');">Restaurar</a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ($_SESSION['rol_activo'] == 1 || $_SESSION['rol_activo'] == 2): ?>
                                            <a href="editar.php?id=<?php echo $row['id_usuario']; ?>" class="btn-edit" title="Editar">Editar</a>
                                            <?php endif; ?>
                                            <?php if ($_SESSION['rol_activo'] == 1): ?>
                                            <a href="eliminar.php?id=<?php echo $row['id_usuario']; ?>" class="btn-delete" title="Dar de baja" onclick="return confirm('¿Está seguro de que desea dar de baja este usuario?');">Dar de baja</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center empty-state">No hay usuarios registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
