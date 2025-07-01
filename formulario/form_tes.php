<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Registro de Tesorería para SIGAM - Gran Logia del Estado de Guerrero" />
  <title>Registro de Tesorería - SIGAM</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/formulario.css" />
</head>
<body>
  <!-- Decorative Elements -->
  <div class="fixed bottom-0 left-20 w-full h-32 floating"></div>
  <div class="fixed top-1/4 right-10 w-20 h-20 rounded-full floating delay-1"></div>
  <div class="fixed top-1/3 left-40 w-16 h-16 rounded-full floating delay-2"></div>
  <div class="fixed bottom-1/4 right-1/4 w-24 h-24 rounded-full floating delay-3"></div>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md">
          <img src="../img/sigam_transparente.png" alt="Logo SIGAM" class="w-10 h-10 object-contain">
          <!--
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" fill="#3498db"/>
            <path d="M10 12l2 2 4-4" stroke="#f8f9fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8 6h8" stroke="#2980b9" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M8 9h4" stroke="#2980b9" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M15 17a2 2 0 100-4 2 2 0 000 4z" fill="#2980b9"/>
            <path d="M15 15h4M15 15v4" stroke="#2980b9" stroke-width="1.5" stroke-linecap="round"/>
          </svg>-->
        </div>
        <h2 class="text-lg font-bold text-[var(--primary-color)]">SIGAM</h2>
      </div>
            <p class="text-xs opacity-90">Sistema Integral de Gestión Administrativa</p>

      <nav>
        <ul class="space-y-2">
          <li><a href="../plataforma/principal.php" class="block p-2 rounded-lg hover:bg-[var(--border-color)]">Inicio</a></li>
          <li><a href="../usuarios/all_usuarios.php" class="block p-2 rounded-lg hover:bg-[var(--border-color)]">Usuarios</a></li>
          <li><a href="#" class="block p-2 rounded-lg bg-[var(--secondary-color)] text-white" aria-current="page">Tesorería</a></li>
          <li><a href="#" class="block p-2 rounded-lg hover:bg-[var(--border-color)]">Reportes</a></li>
          <li><a href="logout.php" class="block p-2 rounded-lg bg-[var(--error-color)] text-white mt-4">Cerrar Sesión</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <!-- Header -->
      <header class="header glass-card">
        <div>
          <h1 class="text-2xl font-bold text-[var(--primary-color)]">Registro de Tesorería</h1>
          <p class="text-sm text-[var(--text-light)]">Gran Logia del Estado de Guerrero</p>
        </div>
        <div class="flex gap-3">
          <button class="hamburger" title="Abrir menú" aria-label="Abrir menú de navegación">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
          <a href="../principal.php" class="btn btn-secondary" title="Volver al inicio">
            <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Regresar
          </a>
        </div>
      </header>

      <!-- Form -->
      <div class="glass-card p-6 mt-6">
        <h3 class="text-xl font-semibold mb-6">Registrar Contribución</h3>
        <form id="tesoreriaForm" class="grid grid-cols-1 gap-8 text-sm" novalidate>
          <!-- Logia Details -->
          <div class="collapsible">
            <div class="collapsible-header">
              <h4 class="font-medium">Detalles de la Logia</h4>
              <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
            <div class="collapsible-content open">
              <div class="grid grid-cols-2 gap-6 p-4">
                <div class="group relative">
                  <label for="logia" class="block mb-1 font-medium">Log.·.</label>
                  <input id="logia" type="text" class="w-full glass-card" placeholder="Ingrese nombre de la logia" required />
                  <p class="error-message hidden" id="logia-error">Este campo es obligatorio</p>
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Nombre de la Logia (ej. Luz y Verdad)</span>
                </div>
                <div class="group relative">
                  <label for="numeroLogia" class="block mb-1 font-medium">N° Logia</label>
                  <input id="numeroLogia" type="number" class="w-full glass-card" placeholder="Número de logia" min="1" required />
                  <p class="error-message hidden" id="numeroLogia-error">Ingrese un número válido</p>
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Número único de la Logia</span>
                </div>
                <div class="group relative col-span-2">
                  <label for="oriente" class="block mb-1 font-medium">Or.·.</label>
                  <input id="oriente" type="text" class="w-full glass-card" placeholder="Ingrese oriente" required />
                  <p class="error-message hidden" id="oriente-error">Este campo es obligatorio</p>
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Ubicación del Oriente (ej. Acapulco)</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Member Details -->
          <div class="collapsible">
            <div class="collapsible-header">
              <h4 class="font-medium">Detalles del Hermano</h4>
              <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
            <div class="collapsible-content open">
              <div class="grid grid-cols-2 gap-6 p-4">
                <div class="group relative">
                  <label for="nombreHermano" class="block mb-1 font-medium">Nombre del H.·.</label>
                  <select id="nombreHermano" class="w-full" required></select>
                  <p class="error-message hidden" id="nombreHermano-error">Seleccione un hermano</p>
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Seleccione el nombre del hermano</span>
                </div>
                <div class="group relative">
                  <label for="estado" class="block mb-1 font-medium">Estado</label>
                  <select id="estado" class="w-full"></select>
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Estado actual del hermano</span>
                </div>
                <div class="group relative">
                  <label for="grado" class="block mb-1 font-medium">Grado</label>
                  <select id="grado" class="w-full"></select>
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Grado masónico del hermano</span>
                </div>
                <div class="group relative">
                  <label for="trimestre" class="block mb-1 font-medium">Trimestre</label>
                  <select id="trimestre" class="w-full"></select>
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Trimestre de la contribución</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Financial Contributions -->
          <div class="collapsible">
            <div class="collapsible-header">
              <h4 class="font-medium">Contribuciones Financieras</h4>
              <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
            <div class="collapsible-content open">
              <div class="grid grid-cols-2 gap-6 p-4">
                <div class="group relative">
                  <label for="capitas" class="block mb-1 font-medium">Capitas ($)</label>
                  <input id="capitas" type="number" class="w-full glass-card" placeholder="0.00" min="0" step="0.01" />
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Contribución por capitas</span>
                </div>
                <div class="group relative">
                  <label for="seguro" class="block mb-1 font-medium">Seguro Mas.·. ($)</label>
                  <input id="seguro" type="number" class="w-full glass-card" placeholder="0.00" min="0" step="0.01" />
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Seguro masónico</span>
                </div>
                <div class="group relative">
                  <label for="iniciacion" class="block mb-1 font-medium">Iniciación ($)</label>
                  <input id="iniciacion" type="number" class="w-full glass-card" placeholder="0.00" min="0" step="0.01" />
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Contribución por iniciación</span>
                </div>
                <div class="group relative">
                  <label for="aumentoSalario" class="block mb-1 font-medium">Aumento Salario ($)</label>
                  <input id="aumentoSalario" type="number" class="w-full glass-card" placeholder="0.00" min="0" step="0.01" />
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Contribución por aumento de salario</span>
                </div>
                <div class="group relative">
                  <label for="exaltacion" class="block mb-1 font-medium">Exaltación ($)</label>
                  <input id="exaltacion" type="number" class="w-full glass-card" placeholder="0.00" min="0" step="0.01" />
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Contribución por exaltación</span>
                </div>
                <div class="group relative">
                  <label for="regularizacion" class="block mb-1 font-medium">Regularización / Afiliación ($)</label>
                  <input id="regularizacion" type="number" class="w-full glass-card" placeholder="0.00" min="0" step="0.01" />
                  <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Contribución por regularización o afiliación</span>
                </div>
              </div>
              <div class="total-amount mt-4">
                Total: $<span id="totalAmount">0.00</span>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end gap-4 mt-6">
            <button type="reset" class="btn btn-secondary">
              <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
              Limpiar
            </button>
            <button type="submit" class="btn btn-primary">
              <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
              Guardar
            </button>
          </div>
        </form>
      </div>

      <!-- Toast Notification -->
      <div id="toast" class="toast" role="alert" aria-live="assertive"></div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
  <script src="../js/form.js"> </script>
</body>
</html>