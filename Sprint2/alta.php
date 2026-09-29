<?php
require_once 'conexion.php';

$error = '';

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
                header("Location: index.php");
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

$query_roles = "SELECT id_rol, nombre FROM rol";
$result_roles = $conn->query($query_roles);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Usuario</title>
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Agregar Nuevo Usuario</h1>
    </header>
    <main>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form action="alta.php" method="POST" class="form">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="nickname">Nickname:</label>
                <input type="text" id="nickname" name="nickname" required value="<?php echo htmlspecialchars($_POST['nickname'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="id_rol">Rol:</label>
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
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
