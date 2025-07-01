<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Gestión de usuarios para SIGAM - Gran Logia del Estado de Guerrero" />
  <title>Gestión de Usuarios - SIGAM</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/usuario.css"/>

</head>
<body>
  <!-- Decorative Elements -->
  <div class="fixed bottom-0 left-0 w-full h-32 floating"></div>
  <div class="fixed top-1/4 right-10 w-20 h-20 rounded-full floating delay-1"></div>
  <div class="fixed top-1/3 left-20 w-16 h-16 rounded-full floating delay-2"></div>
  <div class="fixed bottom-1/4 right-1/4 w-24 h-24 rounded-full floating delay-3"></div>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md">
            <img src="../img/sigam_transparente.png" alt="Logo SIGAM" class="w-10 h-10 object-contain">
         <!-- <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" fill="#3498db"/>
            <path d="M10 12l2 2 4-4" stroke="#f8f9fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8 6h8" stroke="#2980b9" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M8 9h4" stroke="#2980b9" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M15 17a2 2 0 100-4 2 2 0 000 4z" fill="#2980b9"/>
            <path d="M15 15h4M15 15v4" stroke="#2980b9" stroke-width="1.5" stroke-linecap="round"/>
          </svg>-->
        </div>
        <h1 class="text-lg font-bold text-[var(--primary-color)]">SIGAM</h1>
      </div>
      <p class="text-xs opacity-90">Sistema Integral de Gestión Administrativa</p>
      <nav>
        <ul class="space-y-2">
          <li><a href="../plataforma/principal.php" class="block p-2 rounded-lg hover:bg-[var(--border-color)]">Inicio</a></li>
          <li><a href="#" class="block p-2 rounded-lg bg-[var(--secondary-color)] text-white">Usuarios</a></li>
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
          <h1 class="text-2xl font-bold text-[var(--primary-color)]">Gestión de Usuarios</h1>
          <p class="text-sm text-[var(--text-light)]">Gran Logia del Estado de Guerrero</p>
        </div>
        <div class="flex gap-3">
          <button id="openCreateModal" class="btn btn-primary" title="Crear nuevo usuario (Ctrl+N)">
            <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Usuario
          </button>
          <a href="../principal.php" class="btn btn-secondary" title="Volver al inicio">
            <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Regresar
          </a>
        </div>
      </header>

      <!-- Stats -->
      <div class="grid grid-cols-3 gap-4 my-6">
        <div class="glass-card p-4">
          <p class="text-sm text-[var(--text-light)]">Total Usuarios</p>
          <p class="text-2xl font-semibold" id="totalUsers">0</p>
        </div>
        <div class="glass-card p-4">
          <p class="text-sm text-[var(--text-light)]">Usuarios Activos</p>
          <p class="text-2xl font-semibold" id="activeUsers">0</p>
        </div>
        <div class="glass-card p-4">
          <p class="text-sm text-[var(--text-light)]">Última Actualización</p>
          <p class="text-2xl font-semibold" id="lastUpdate">-</p>
        </div>
      </div>

      <!-- Tabs -->
      <div class="flex border-b mb-6">
        <div class="tab active" data-tab="list">Lista de Usuarios</div>
        <div class="tab" data-tab="create">Crear Usuario</div>
      </div>

      <!-- Tab Content: User List -->
      <div id="list" class="tab-content active">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
          <div class="flex gap-4 flex-wrap">
            <div class="relative">
              <input type="text" id="searchUsers" class="w-full max-w-sm glass-card pl-10 pr-10 py-2.5 text-sm" placeholder="Buscar por nombre o correo..." aria-label="Buscar usuarios">
              <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-[var(--text-light)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
              <button id="clearSearch" class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden">
                <svg class="w-5 h-5 text-[var(--text-light)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
              </button>
            </div>
            <select id="filterRole" class="glass-card px-4 py-2.5 text-sm">
              <option value="">Filtrar por Rol</option>
              <option value="Administrador">Administrador</option>
              <option value="Usuario">Usuario</option>
              <option value="Invitado">Invitado</option>
            </select>
            <select id="filterStatus" class="glass-card px-4 py-2.5 text-sm">
              <option value="">Filtrar por Estado</option>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
            <button id="resetFilters" class="btn btn-secondary text-sm py-2">Restablecer</button>
          </div>
          <button id="exportCsv" class="btn btn-secondary text-sm py-2">
            <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Exportar CSV
          </button>
        </div>
        <div class="glass-card p-6">
          <table id="userTable">
            <thead>
              <tr>
                <th data-sort="nombreCompleto">Nombre Completo <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg></th>
                <th data-sort="email">Correo Electrónico <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg></th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <div id="noUsers" class="text-center text-[var(--text-light)] mt-6 hidden">No se encontraron usuarios</div>
          <div class="pagination" id="pagination"></div>
        </div>
        <div id="loadingSpinner" class="text-center my-4 hidden"><span class="spinner"></span></div>
      </div>

      <!-- Tab Content: Create User Form -->
      <div id="create" class="tab-content">
        <div class="glass-card p-6">
          <h3 class="text-xl font-semibold mb-6">Crear Nuevo Usuario</h3>
          <form id="createUserForm" class="grid grid-cols-1 gap-8 text-sm" novalidate>
            <div class="grid grid-cols-2 gap-6">
              <div>
                <label for="createNombreCompleto" class="block mb-1 font-medium">Nombre Completo</label>
                <input id="createNombreCompleto" type="text" class="w-full glass-card" placeholder="Ingrese nombre completo" required />
                <p class="error-message hidden" id="createNombreCompleto-error">Este campo es obligatorio</p>
              </div>
              <div>
                <label for="createEmail" class="block mb-1 font-medium">Correo Electrónico</label>
                <input id="createEmail" type="email" class="w-full glass-card" placeholder="ejemplo@correo.com" required />
                <p class="error-message hidden" id="createEmail-error">Ingrese un correo válido</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
              <div>
                <label for="createPassword" class="block mb-1 font-medium">Contraseña</label>
                <div class="relative">
                  <input id="createPassword" type="password" class="w-full glass-card pr-12" placeholder="Ingrese contraseña" required />
                  <button type="button" id="toggleCreatePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg class="w-5 h-5 text-[var(--text-light)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c-1.5-2.5-4-4-7-4s-5.5 1.5-7 4m14 0c-1.5 2.5-4 4-7 4s-5.5-1.5-7-4"/></svg>
                  </button>
                </div>
                <p class="error-message hidden" id="createPassword-error">La contraseña debe tener al menos 8 caracteres</p>
              </div>
              <div>
                <label for="createRol" class="block mb-1 font-medium">Rol</label>
                <select id="createRol" class="w-full" required>
                  <option value="">-- Seleccionar Rol --</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Usuario">Usuario</option>
                  <option value="Invitado">Invitado</option>
                </select>
                <p class="error-message hidden" id="createRol-error">Seleccione un rol</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
              <div>
                <label for="createEstado" class="block mb-1 font-medium">Estado</label>
                <select id="createEstado" class="w-full">
                  <option value="">-- Seleccionar Estado --</option>
                  <option value="Activo">Activo</option>
                  <option value="Inactivo">Inactivo</option>
                </select>
              </div>
              <div>
                <label for="createTelefono" class="block mb-1 font-medium">Teléfono (Opcional)</label>
                <input id="createTelefono" type="tel" class="w-full glass-card" placeholder="Ej. 555-123-4567" pattern="[0-9]{10}" />
                <p class="error-message hidden" id="createTelefono-error">Ingrese un número de teléfono válido (10 dígitos)</p>
              </div>
            </div>
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
      </div>

      <!-- Edit User Modal -->
      <div id="editModal" class="modal">
        <div class="modal-content glass-card">
          <h3 class="text-xl font-semibold text-[var(--primary-color)] mb-6">Editar Usuario</h3>
          <form id="editUserForm" class="grid grid-cols-1 gap-8 text-sm" novalidate>
            <input type="hidden" id="editUserId">
            <div class="grid grid-cols-2 gap-6">
              <div>
                <label for="editNombreCompleto" class="block mb-1 font-medium">Nombre Completo</label>
                <input id="editNombreCompleto" type="text" class="w-full glass-card" placeholder="Ingrese nombre completo" required />
                <p class="error-message hidden" id="editNombreCompleto-error">Este campo es obligatorio</p>
              </div>
              <div>
                <label for="editEmail" class="block mb-1 font-medium">Correo Electrónico</label>
                <input id="editEmail" type="email" class="w-full glass-card" placeholder="ejemplo@correo.com" required />
                <p class="error-message hidden" id="editEmail-error">Ingrese un correo válido</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
              <div>
                <label for="editPassword" class="block mb-1 font-medium">Nueva Contraseña (Opcional)</label>
                <div class="relative">
                  <input id="editPassword" type="password" class="w-full glass-card pr-12" placeholder="Ingrese nueva contraseña" />
                  <button type="button" id="toggleEditPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg class="w-5 h-5 text-[var(--text-light)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c-1.5-2.5-4-4-7-4s-5.5 1.5-7 4m14 0c-1.5 2.5-4 4-7 4s-5.5-1.5-7-4"/></svg>
                  </button>
                </div>
                <p class="error-message hidden" id="editPassword-error">La contraseña debe tener al menos 8 caracteres</p>
              </div>
              <div>
                <label for="editRol" class="block mb-1 font-medium">Rol</label>
                <select id="editRol" class="w-full" required>
                  <option value="">-- Seleccionar Rol --</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Usuario">Usuario</option>
                  <option value="Invitado">Invitado</option>
                </select>
                <p class="error-message hidden" id="editRol-error">Seleccione un rol</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
              <div>
                <label for="editEstado" class="block mb-1 font-medium">Estado</label>
                <select id="editEstado" class="w-full">
                  <option value="">-- Seleccionar Estado --</option>
                  <option value="Activo">Activo</option>
                  <option value="Inactivo">Inactivo</option>
                </select>
              </div>
              <div>
                <label for="editTelefono" class="block mb-1 font-medium">Teléfono (Opcional)</label>
                <input id="editTelefono" type="tel" class="w-full glass-card" placeholder="Ej. 555-123-4567" pattern="[0-9]{10}" />
                <p class="error-message hidden" id="editTelefono-error">Ingrese un número de teléfono válido (10 dígitos)</p>
              </div>
            </div>
            <div class="flex justify-end gap-4 mt-6">
              <button type="button" id="closeEditModal" class="btn btn-secondary">Cancelar</button>
              <button type="submit" class="btn btn-primary">
                <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Guardar
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div id="deleteModal" class="modal">
        <div class="modal-content glass-card">
          <h3 class="text-xl font-semibold text-[var(--primary-color)] mb-4">Confirmar Eliminación</h3>
          <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-[var(--border-color)] rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-[var(--text-light)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
              <p class="text-[var(--text-color)]">¿Estás seguro de que deseas eliminar a <span id="deleteUserName" class="font-semibold"></span>?</p>
              <p class="text-sm text-[var(--text-light)]">Correo: <span id="deleteUserEmail"></span></p>
            </div>
          </div>
          <div>
            <label for="confirmDeleteInput" class="block mb-1 font-medium">Escribe "eliminar" para confirmar</label>
            <input id="confirmDeleteInput" type="text" class="w-full glass-card" placeholder="eliminar" />
            <p class="error-message hidden" id="confirmDeleteInput-error">Debes escribir 'eliminar' para confirmar</p>
          </div>
          <div class="flex justify-end gap-4 mt-6">
            <button id="cancelDelete" class="btn btn-secondary">Cancelar</button>
            <button id="confirmDelete" class="btn btn-danger" disabled>
              <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
              Eliminar
            </button>
          </div>
        </div>
      </div>

      <!-- Toast Notification -->
      <div id="toast" class="toast" role="alert" aria-live="assertive"></div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="../js/all_usr.js"> </script>
</body>
</html>