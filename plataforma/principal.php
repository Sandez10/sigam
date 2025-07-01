<?php
require_once '../sesiones_conexiones/sesion_config.php';
require_once '../database/conexion.php';

// Redirigir si no hay sesión activa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../");
    exit;
}

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    // Corregido: tabla 'usuarios' (no 'users')
    $stmt = $conn->prepare("SELECT usr, rol, password_reset_required FROM usuarios WHERE usrId = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        session_destroy();
        header("Location: ../");
        exit;
    }

    $_SESSION['user_name'] = $user['usr'];
    $_SESSION['rol'] = $user['rol'];
    $_SESSION['password_reset_required'] = $user['password_reset_required'];

    if ($user['password_reset_required'] == 1) {
        header("Location: reset_password.php");
        exit;
    }
} catch (Exception $e) {
    error_log("Error en principal.php: " . $e->getMessage());
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIGAM | Panel Principal</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/principal01.css"> 
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen">

<!-- Navigation -->
<nav class="nav-gradient text-white shadow-xl">
  <div class="container mx-auto px-6 py-4">
    <div class="flex items-center justify-between">
<div class="flex items-center space-x-4">
  <div class="flex items-center space-x-3">
    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center shadow-lg">
    <img src="../img/sigam_transparente.png" alt="Logo SIGAM" class="w-10 h-10 object-contain">
<!--      <i data-lucide="shield" class="w-6 h-6 text-indigo-600"></i>-->
    </div>
  </div>
  <div>
    <h1 class="text-xl font-bold">SIGAM</h1>
    <p class="text-xs opacity-90">Sistema Integral de Gestión Administrativa</p>
  </div>
</div>
      
      <div class="flex items-center space-x-6">
        <div class="hidden md:flex items-center space-x-2 bg-white/20 px-4 py-2 rounded-full">
          <span class="text-sm font-medium"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
          <div class="w-8 h-8 rounded-full bg-white text-indigo-600 flex items-center justify-center font-bold shadow">
            <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
          </div>
        </div>
        <a href="logout.php" class="flex items-center space-x-2 bg-white text-indigo-600 px-4 py-2 rounded-lg font-medium shadow hover:shadow-md transition-all">
          <i data-lucide="log-out" class="w-5 h-5"></i>
          <span>Salir</span>
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="container mx-auto px-6 py-12">
  <div class="text-center max-w-3xl mx-auto">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
      Hola, <span class="text-indigo-600"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
    </h1>
    <p class="text-xl text-gray-600 mb-8">
      Bienvenido al panel de control de SIGAM. ¿Qué deseas hacer hoy?
    </p>
    
    <div class="flex flex-wrap justify-center gap-4 mb-12">
      <div class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-full flex items-center">
        <i data-lucide="user" class="w-5 h-5 mr-2"></i>
        <span class="text-sm font-medium"><?php echo ucfirst($_SESSION['rol']); ?></span>
      </div>
      <div class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-full flex items-center">
        <i data-lucide="clock" class="w-5 h-5 mr-2"></i>
        <span class="text-sm font-medium"><?php echo date('d/m/Y'); ?></span>
      </div>
    </div>
  </div>
</section>

<!-- Features Grid -->
<section class="container mx-auto px-6 pb-16">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <!-- Nuevo Registro -->
    <a href="../formulario/form_tes.php" class="glass-card p-8 text-center group">
      <div class="feature-icon bg-blue-100 text-blue-600 mx-auto group-hover:bg-blue-600 group-hover:text-white">
        <i data-lucide="file-plus" class="w-6 h-6"></i>
      </div>
      <h3 class="text-xl font-bold text-gray-800 mb-2">Nuevo Registro</h3>
      <p class="text-gray-600 mb-4">Registra movimientos de tesorería</p>
      <div class="text-blue-500 font-medium flex items-center justify-center group-hover:text-blue-600">
        <span>Acceder</span>
        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
      </div>
    </a>

    <?php if ($_SESSION['rol'] === 'admin'): ?>
    <!-- Administrar Usuarios -->
    <a href="../usuarios/all_usuarios.php" class="glass-card p-8 text-center group">
      <div class="feature-icon bg-indigo-100 text-indigo-600 mx-auto group-hover:bg-indigo-600 group-hover:text-white">
        <i data-lucide="users" class="w-6 h-6"></i>
      </div>
      <h3 class="text-xl font-bold text-gray-800 mb-2">Usuarios</h3>
      <p class="text-gray-600 mb-4">Administra usuarios del sistema</p>
      <div class="text-indigo-500 font-medium flex items-center justify-center group-hover:text-indigo-600">
        <span>Acceder</span>
        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
      </div>
    </a>
    <?php endif; ?>

    <!-- Historial -->
    <a href="../formulario/reportes/reporte1.php" class="glass-card p-8 text-center group">
      <div class="feature-icon bg-green-100 text-green-600 mx-auto group-hover:bg-green-600 group-hover:text-white">
        <i data-lucide="database" class="w-6 h-6"></i>
      </div>
      <h3 class="text-xl font-bold text-gray-800 mb-2">Historial</h3>
      <p class="text-gray-600 mb-4">Consulta registros anteriores</p>
      <div class="text-green-500 font-medium flex items-center justify-center group-hover:text-green-600">
        <span>Acceder</span>
        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
      </div>
    </a>

    <!-- Reportes -->
    <a href="../formulario/reportes/elegir_reporte.php" class="glass-card p-8 text-center group">
      <div class="feature-icon bg-purple-100 text-purple-600 mx-auto group-hover:bg-purple-600 group-hover:text-white">
        <i data-lucide="bar-chart-2" class="w-6 h-6"></i>
      </div>
      <h3 class="text-xl font-bold text-gray-800 mb-2">Reportes</h3>
      <p class="text-gray-600 mb-4">Genera PDF o Excel</p>
      <div class="text-purple-500 font-medium flex items-center justify-center group-hover:text-purple-600">
        <span>Acceder</span>
        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
      </div>
    </a>
  </div>
</section>

<!-- Floating Elements -->
<div class="fixed bottom-0 left-0 w-full h-48 bg-gradient-to-t from-indigo-50 to-transparent z-0"></div>
<div class="fixed top-1/4 right-10 w-16 h-16 rounded-full bg-blue-200 opacity-20 floating z-0"></div>
<div class="fixed top-1/3 left-20 w-24 h-24 rounded-full bg-indigo-200 opacity-20 floating delay-1 z-0"></div>
<div class="fixed bottom-1/4 right-1/4 w-20 h-20 rounded-full bg-purple-200 opacity-20 floating delay-2 z-0"></div>


<script>
  lucide.createIcons();
  
  // Efecto de carga para las tarjetas
  document.querySelectorAll('.glass-card').forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.animation = `fadeInUp 0.5s ease-out ${index * 0.1}s forwards`;
  });
</script>

</body>
</html>