<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['rol_activo']) || $_SESSION['rol_activo'] != 1) {
    header("Location: index.php?error=acceso_denegado");
    exit();
}

if (!isset($_SESSION['usuario_activo']) || $_SESSION['usuario_activo'] != 1) {
    header("Location: index.php?error=usuario_inactivo");
    exit();
}

require_once 'conexion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = (int)$_GET['id'];
    
    $query = "UPDATE usuario SET activo = 1 WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: index.php?vista=inactivos");
exit;
?>
