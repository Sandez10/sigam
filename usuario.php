<?php
require_once 'database/conexion.php'; // Tu conexión a la base de datos

$usuario = 'noadmin';
$password_plano = 'admin123';
$rol = 'admin';
$estado = 'Activo';
$password_reset_required = 0;

// Hashear la contraseña
$clave_hashed = password_hash($password_plano, PASSWORD_DEFAULT);

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("INSERT INTO usuarios (usr, clave, rol, estado, password_reset_required) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $usuario, $clave_hashed, $rol, $estado, $password_reset_required);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Usuario agregado correctamente.";
    } else {
        echo "Error al agregar usuario.";
    }

    $stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
