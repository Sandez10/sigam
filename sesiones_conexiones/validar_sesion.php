<?php
require_once 'sesion_config.php';
require_once '../database/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = trim($_POST['clave'] ?? '');

    if ($usuario === '' || $clave === '') {
        header('Location: ../index.php?error=Todos los campos son obligatorios');
        exit;
    }

    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT usrId, usr, clave, rol, estado, password_reset_required FROM usuarios WHERE usr = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario_data = $result->fetch_assoc();
        $stmt->close();

        if ($usuario_data && password_verify($clave, $usuario_data['clave'])) {
            if ($usuario_data['estado'] !== 'Activo') {
                header("Location: ../index.php?error=Usuario inactivo.");
                exit;
            }

            // Guardar datos importantes en sesión
            $_SESSION['user_id'] = $usuario_data['usrId'];
            $_SESSION['user_name'] = $usuario_data['usr'];
            $_SESSION['rol'] = $usuario_data['rol'];
            $_SESSION['password_reset_required'] = $usuario_data['password_reset_required'];

            header("Location: ../plataforma/principal.php");
            exit;
        } else {
            header("Location: ../index.php?error=Credenciales inválidas");
            exit;
        }
    } catch (Exception $e) {
        error_log("Error de conexión: " . $e->getMessage());
        header("Location: ../index.php?error=Error del servidor");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
