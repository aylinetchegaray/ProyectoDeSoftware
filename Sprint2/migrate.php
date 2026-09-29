<?php
require_once 'conexion.php';
$conn->query("ALTER TABLE usuario ADD COLUMN activo TINYINT(1) DEFAULT 1;");
echo "Migracion completada";
?>
