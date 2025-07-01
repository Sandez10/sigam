<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Relación de Pagos para SIGAM - Gran Logia del Estado de Guerrero" />
  <title>Relación de Pagos - SIGAM</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/reportes.css"/>
</head>
<body>
  <!-- Decorative Elements -->
  <div class="fixed top-1/4 right-10 w-16 h-16 rounded-full floating delay-1"></div>
  <div class="fixed bottom-1/4 right-20 w-20 h-20 rounded-full floating"></div>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md">
          <img src="../../img/sigam_transparente.png" alt="Logo SIGAM" class="w-10 h-10 object-contain">
          <!--<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
          <li><a href="../../plataforma/principal.php" class="block p-2 rounded-lg hover:bg-[var(--border-color)]">Inicio</a></li>
          <li><a href="../../usuarios/all_usuarios.php" class="block p-2 rounded-lg hover:bg-[var(--border-color)]">Usuarios</a></li>
          <li><a href="../../formulario/form_tes.php" class="block p-2 rounded-lg hover:bg-[var(--border-color)]">Registro</a></li>
          <li><a href="#" class="block p-2 rounded-lg bg-[var(--secondary-color)] text-white" aria-current="page">Reportes</a></li>
          <li><a href="logout.php" class="block p-2 rounded-lg bg-[var(--error-color)] text-white mt-4">Cerrar Sesión</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <!-- Header -->
      <header class="header glass-card">
        <div>
          <h1 class="text-2xl font-bold text-[var(--primary-color)]">Relación de Pagos</h1>
          <p class="text-sm text-[var(--text-light)]">Gran Logia del Estado de Guerrero</p>
        </div>
        <div class="flex gap-3">
          <button class="hamburger" title="Abrir menú" aria-label="Abrir menú de navegación">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
          <a href="../principal.php" class="btn btn-secondary" title="Volver al inicio">
            <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Regresar
          </a>
        </div>
      </header>

      <!-- Report Section -->
      <div class="glass-card p-6 mt-6">
        <!-- Summary Card -->
        <div class="summary-card glass-card">
          <div class="summary-item">
            <h4 class="text-sm font-medium text-[var(--text-light)]">Total Pagos</h4>
            <p class="text-2xl font-bold text-[var(--primary-color)]" id="totalPayments">$480.00</p>
          </div>
          <div class="summary-item">
            <h4 class="text-sm font-medium text-[var(--text-light)]">Registros</h4>
            <p class="text-2xl font-bold text-[var(--primary-color)]" id="recordCount">3</p>
          </div>
        </div>

        <!-- Export Toolbar -->
        <div class="glass-card p-4 mb-6 sticky top-20 z-10">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold">Opciones de Exportación</h3>
            <div class="flex gap-3">
              <button id="exportCsv" class="btn btn-export" aria-label="Exportar a CSV">
                <svg class="inline-block w-5 h-5 mr-1" data-lucide="file-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                CSV
              </button>
              <button id="exportPdf" class="btn btn-export" aria-label="Exportar a PDF">
                <svg class="inline-block w-5 h-5 mr-1" data-lucide="file-down" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                PDF
              </button>
            </div>
          </div>
          <div class="progress" id="exportProgress">
            <div class="progress-bar" id="progressBar"></div>
          </div>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-2 gap-4 mb-6">
          <div class="group relative">
            <label for="trimestre" class="block mb-1 font-medium">Trimestre</label>
            <select id="trimestre" class="w-full" aria-label="Seleccionar trimestre"></select>
            <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Seleccione el trimestre del reporte</span>
          </div>
          <div class="group relative">
            <label for="year" class="block mb-1 font-medium">Año</label>
            <select id="year" class="w-full" aria-label="Seleccionar año"></select>
            <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Seleccione el año del reporte</span>
          </div>
        </div>
        <div class="flex justify-end mb-4">
          <button id="resetFilters" class="btn btn-secondary" aria-label="Restablecer filtros">
            <svg class="inline-block w-5 h-5 mr-1" data-lucide="rotate-ccw" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 4v6h6M3 15a9 9 0 109-9"></path></svg>
            Restablecer
          </button>
        </div>

        <!-- Table -->
        <div class="table-responsive">
          <table id="tablaPagos" class="table dataTable table-striped align-middle text-center w-100"></table>
        </div>
      </div>

      <!-- Toast Notification -->
      <div id="toast" class="toast" role="alert" aria-live="assertive"></div>
    </main>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
  <script src="https://unpkg.com/lucide@0.4.0/dist/umd/lucide.min.js"></script>
  <script src="../../js/reporte.js"></script>
 </body>
</html>
