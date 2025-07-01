
    // Sample user data (replace with PHP backend)
    let users = [
      { id: 1, nombreCompleto: "Rodrigo Pérez", email: "rodrigo@correo.com", password: "password123", rol: "Administrador", estado: "Activo", telefono: "5551234567" },
      { id: 2, nombreCompleto: "Fernando Gómez", email: "fernando@correo.com", password: "password456", rol: "Usuario", estado: "Inactivo", telefono: "" },
      { id: 3, nombreCompleto: "Carlos López", email: "carlos@correo.com", password: "password789", rol: "Invitado", estado: "Activo", telefono: "5559876543" },
      { id: 4, nombreCompleto: "Ana Martínez", email: "ana@correo.com", password: "password012", rol: "Usuario", estado: "Activo", telefono: "5551112233" }
    ];

    let sortField = "nombreCompleto";
    let sortDirection = "asc";
    let currentPage = 1;
    const usersPerPage = 10;
    let filterRole = "";
    let filterStatus = "";

    // Initialize TomSelect
    let createRolSelect, createEstadoSelect, editRolSelect, editEstadoSelect;
    function initializeTomSelect() {
      createRolSelect = new TomSelect("#createRol", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Seleccionar rol..."
      });
      createEstadoSelect = new TomSelect("#createEstado", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Seleccionar estado..."
      });
      editRolSelect = new TomSelect("#editRol", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Seleccionar rol..."
      });
      editEstadoSelect = new TomSelect("#editEstado", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Seleccionar estado..."
      });
    }

    // Show toast notification
    function showToast(message, isError = false) {
      const toast = document.getElementById("toast");
      toast.textContent = message;
      toast.classList.add("show");
      if (isError) toast.classList.add("error");
      setTimeout(() => {
        toast.classList.remove("show");
        toast.classList.remove("error");
      }, 4000);
    }

    // Update stats
    function updateStats() {
      document.getElementById("totalUsers").textContent = users.length;
      document.getElementById("activeUsers").textContent = users.filter(u => u.estado === "Activo").length;
      document.getElementById("lastUpdate").textContent = new Date().toLocaleDateString("es-MX", {
        day: "2-digit",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit"
      });
    }

    // Render pagination
    function renderPagination(totalUsers) {
      const pagination = document.getElementById("pagination");
      pagination.innerHTML = "";
      const totalPages = Math.ceil(totalUsers / usersPerPage);

      if (totalPages <= 1) return;

      for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement("button");
        button.textContent = i;
        button.classList.add(i === currentPage ? "active" : "");
        button.addEventListener("click", () => {
          currentPage = i;
          renderTable();
        });
        pagination.appendChild(button);
      }
    }

    // Render user table
    function renderTable(search = "") {
      const tbody = document.querySelector("#userTable tbody");
      const loadingSpinner = document.getElementById("loadingSpinner");
      loadingSpinner.classList.remove("hidden");
      tbody.innerHTML = "";
      tbody.classList.add("loading");

      setTimeout(() => { // Simulate async fetch
        const filteredUsers = users.filter(user =>
          (user.nombreCompleto.toLowerCase().includes(search.toLowerCase()) ||
           user.email.toLowerCase().includes(search.toLowerCase())) &&
          (filterRole ? user.rol === filterRole : true) &&
          (filterStatus ? user.estado === filterStatus : true)
        );

        const sortedUsers = filteredUsers.sort((a, b) => {
          const valA = a[sortField]?.toLowerCase() || "";
          const valB = b[sortField]?.toLowerCase() || "";
          return sortDirection === "asc" ? valA.localeCompare(valB) : valB.localeCompare(valA);
        });

        const start = (currentPage - 1) * usersPerPage;
        const end = start + usersPerPage;
        const paginatedUsers = sortedUsers.slice(start, end);

        if (paginatedUsers.length === 0) {
          document.getElementById("noUsers").classList.remove("hidden");
        } else {
          document.getElementById("noUsers").classList.add("hidden");
          paginatedUsers.forEach(user => {
            const row = document.createElement("tr");
            row.classList.add("glass-card");
            row.innerHTML = `
              <td>${user.nombreCompleto}</td>
              <td>${user.email}</td>
              <td>
                <span class="cursor-pointer hover:underline" ondblclick="inlineEdit(${user.id}, 'rol')">${user.rol}</span>
                <select class="hidden w-full glass-card" onchange="saveInlineEdit(${user.id}, 'rol', this.value)">
                  <option value="Administrador" ${user.rol === "Administrador" ? "selected" : ""}>Administrador</option>
                  <option value="Usuario" ${user.rol === "Usuario" ? "selected" : ""}>Usuario</option>
                  <option value="Invitado" ${user.rol === "Invitado" ? "selected" : ""}>Invitado</option>
                </select>
              </td>
              <td>
                <span class="status-badge status-${user.estado.toLowerCase()} cursor-pointer" ondblclick="inlineEdit(${user.id}, 'estado')">${user.estado || "N/A"}</span>
                <select class="hidden w-full glass-card" onchange="saveInlineEdit(${user.id}, 'estado', this.value)">
                  <option value="Activo" ${user.estado === "Activo" ? "selected" : ""}>Activo</option>
                  <option value="Inactivo" ${user.estado === "Inactivo" ? "selected" : ""}>Inactivo</option>
                </select>
              </td>
              <td>
                <div class="flex gap-2">
                  <div class="group relative">
                    <button class="btn btn-primary text-sm py-1.5 px-3" onclick="openEditModal(${user.id})" aria-label="Editar usuario ${user.nombreCompleto}">
                      <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                      Editar
                    </button>
                    <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Editar usuario</span>
                  </div>
                  <div class="group relative">
                    <button class="btn btn-danger text-sm py-1.5 px-3" onclick="openDeleteModal(${user.id})" aria-label="Eliminar usuario ${user.nombreCompleto}">
                      <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                      Eliminar
                    </button>
                    <span class="tooltip top-[-2.5rem] left-1/2 transform -translate-x-1/2">Eliminar usuario</span>
                  </div>
                </div>
              </td>
            `;
            tbody.appendChild(row);
          });
        }

        renderPagination(filteredUsers.length);
        updateStats();
        loadingSpinner.classList.add("hidden");
        tbody.classList.remove("loading");
      }, 300);
    }

    // Inline editing
    function inlineEdit(userId, field) {
      const row = document.querySelector(`tr:has(button[onclick='openEditModal(${userId})'])`);
      const span = row.querySelector(`td:nth-child(${field === "rol" ? 3 : 4}) span`);
      const select = row.querySelector(`td:nth-child(${field === "rol" ? 3 : 4}) select`);
      span.classList.add("hidden");
      select.classList.remove("hidden");
      select.focus();
    }

    function saveInlineEdit(userId, field, value) {
      const user = users.find(u => u.id === userId);
      if (user) {
        user[field] = value;
        renderTable(document.getElementById("searchUsers").value);
        showToast(`Se actualizó el ${field} del usuario`);
      }
    }

    // Tab switching
    document.querySelectorAll(".tab").forEach(tab => {
      tab.addEventListener("click", () => {
        document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
        document.querySelectorAll(".tab-content").forEach(c => c.classList.remove("active"));
        tab.classList.add("active");
        document.getElementById(tab.getAttribute("data-tab")).classList.add("active");
      });
    });

    // Search functionality with debounce
    let searchTimeout;
    document.getElementById("searchUsers").addEventListener("input", (e) => {
      clearTimeout(searchTimeout);
      const clearButton = document.getElementById("clearSearch");
      clearButton.classList.toggle("hidden", !e.target.value);
      searchTimeout = setTimeout(() => {
        currentPage = 1;
        renderTable(e.target.value);
      }, 300);
    });

    document.getElementById("clearSearch").addEventListener("click", () => {
      const searchInput = document.getElementById("searchUsers");
      searchInput.value = "";
      searchInput.focus();
      document.getElementById("clearSearch").classList.add("hidden");
      currentPage = 1;
      renderTable();
    });

    // Filters
    document.getElementById("filterRole").addEventListener("change", (e) => {
      filterRole = e.target.value;
      currentPage = 1;
      renderTable(document.getElementById("searchUsers").value);
    });

    document.getElementById("filterStatus").addEventListener("change", (e) => {
      filterStatus = e.target.value;
      currentPage = 1;
      renderTable(document.getElementById("searchUsers").value);
    });

    document.getElementById("resetFilters").addEventListener("click", () => {
      filterRole = "";
      filterStatus = "";
      document.getElementById("filterRole").value = "";
      document.getElementById("filterStatus").value = "";
      currentPage = 1;
      renderTable(document.getElementById("searchUsers").value);
    });

    // Sorting
    document.querySelectorAll("th[data-sort]").forEach(th => {
      th.addEventListener("click", () => {
        const field = th.getAttribute("data-sort");
        if (sortField === field) {
          sortDirection = sortDirection === "asc" ? "desc" : "asc";
        } else {
          sortField = field;
          sortDirection = "asc";
        }
        renderTable(document.getElementById("searchUsers").value);
      });
    });

    // Open create user modal
    document.getElementById("openCreateModal").addEventListener("click", () => {
      document.querySelector(".tab[data-tab='create']").click();
    });

    // Keyboard shortcut for new user
    document.addEventListener("keydown", (e) => {
      if (e.ctrlKey && e.key === "n") {
        e.preventDefault();
        document.querySelector(".tab[data-tab='create']").click();
      }
    });

    // Open edit user modal
    function openEditModal(userId) {
      const user = users.find(u => u.id === userId);
      if (user) {
        document.getElementById("editUserId").value = user.id;
        document.getElementById("editNombreCompleto").value = user.nombreCompleto;
        document.getElementById("editEmail").value = user.email;
        document.getElementById("editPassword").value = "";
        editRolSelect.setValue(user.rol);
        editEstadoSelect.setValue(user.estado || "");
        document.getElementById("editTelefono").value = user.telefono || "";
        document.getElementById("editModal").classList.add("show");
        document.getElementById("editNombreCompleto").focus();
      }
    }

    // Open delete confirmation modal
    function openDeleteModal(userId) {
      const user = users.find(u => u.id === userId);
      if (user) {
        document.getElementById("deleteUserName").textContent = user.nombreCompleto;
        document.getElementById("deleteUserEmail").textContent = user.email;
        document.getElementById("confirmDelete").setAttribute("data-user-id", userId);
        document.getElementById("confirmDeleteInput").value = "";
        document.getElementById("confirmDelete").disabled = true;
        document.getElementById("deleteModal").classList.add("show");
        document.getElementById("confirmDeleteInput").focus();
      }
    }

    // Close modals
    document.getElementById("closeEditModal").addEventListener("click", () => {
      document.getElementById("editModal").classList.remove("show");
    });

    document.getElementById("cancelDelete").addEventListener("click", () => {
      document.getElementById("deleteModal").classList.remove("show");
    });

    // Modal focus trap
    function trapFocus(modal) {
      const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
      const firstElement = focusableElements[0];
      const lastElement = focusableElements[focusableElements.length - 1];

      modal.addEventListener("keydown", (e) => {
        if (e.key === "Tab") {
          if (e.shiftKey && document.activeElement === firstElement) {
            e.preventDefault();
            lastElement.focus();
          } else if (!e.shiftKey && document.activeElement === lastElement) {
            e.preventDefault();
            firstElement.focus();
          }
        }
        if (e.key === "Escape") {
          modal.classList.remove("show");
        }
      });
    }

    document.querySelectorAll(".modal").forEach(modal => trapFocus(modal));

    // Password toggle
    function setupPasswordToggle(inputId, toggleId) {
      const input = document.getElementById(inputId);
      const toggle = document.getElementById(toggleId);
      toggle.addEventListener("click", () => {
        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        toggle.querySelector("svg").setAttribute("d", isPassword ?
          "M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17a5 5 0 100-10 5 5 0 000 10zm0-8a3 3 0 110 6 3 3 0 010-6z" :
          "M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c-1.5-2.5-4-4-7-4s-5.5 1.5-7 4m14 0c-1.5 2.5-4 4-7 4s-5.5-1.5-7-4"
        );
      });
    }

    setupPasswordToggle("createPassword", "toggleCreatePassword");
    setupPasswordToggle("editPassword", "toggleEditPassword");

    // Delete confirmation input
    document.getElementById("confirmDeleteInput").addEventListener("input", (e) => {
      const confirmButton = document.getElementById("confirmDelete");
      const error = document.getElementById("confirmDeleteInput-error");
      if (e.target.value.toLowerCase() === "eliminar") {
        confirmButton.disabled = false;
        error.classList.add("hidden");
      } else {
        confirmButton.disabled = true;
        error.classList.remove("hidden");
      }
    });

    // Handle create form submission
    document.getElementById("createUserForm").addEventListener("submit", function(e) {
      e.preventDefault();
      let isValid = true;
      const requiredFields = [
        { id: "createNombreCompleto", error: "Este campo es obligatorio" },
        { id: "createEmail", error: "Ingrese un correo válido" },
        { id: "createPassword", error: "La contraseña debe tener al menos 8 caracteres" },
        { id: "createRol", error: "Seleccione un rol" }
      ];

      requiredFields.forEach(field => {
        const input = document.getElementById(field.id);
        const error = document.getElementById(`${field.id}-error`);
        if (!input.value) {
          input.classList.add("input-error");
          error.classList.remove("hidden");
          isValid = false;
        } else if (field.id === "createEmail" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
          input.classList.add("input-error");
          error.classList.remove("hidden");
          isValid = false;
        } else if (field.id === "createPassword" && input.value.length < 8) {
          input.classList.add("input-error");
          error.classList.remove("hidden");
          isValid = false;
        } else {
          input.classList.remove("input-error");
          error.classList.add("hidden");
        }
      });

      const telefono = document.getElementById("createTelefono");
      const telefonoError = document.getElementById("createTelefono-error");
      if (telefono.value && !/^[0-9]{10}$/.test(telefono.value)) {
        telefono.classList.add("input-error");
        telefonoError.classList.remove("hidden");
        isValid = false;
      } else {
        telefono.classList.remove("input-error");
        telefonoError.classList.add("hidden");
      }

      if (isValid) {
        const userData = {
          id: users.length + 1,
          nombreCompleto: document.getElementById("createNombreCompleto").value,
          email: document.getElementById("createEmail").value,
          password: document.getElementById("createPassword").value,
          rol: document.getElementById("createRol").value,
          estado: document.getElementById("createEstado").value || "N/A",
          telefono: document.getElementById("createTelefono").value || ""
        };
        users.push(userData);
        renderTable();
        document.querySelector(".tab[data-tab='list']").click();
        showToast("Usuario creado con éxito");
        this.reset();
        createRolSelect.clear();
        createEstadoSelect.clear();
      }
    });

    // Handle edit form submission
    document.getElementById("editUserForm").addEventListener("submit", function(e) {
      e.preventDefault();
      let isValid = true;
      const requiredFields = [
        { id: "editNombreCompleto", error: "Este campo es obligatorio" },
        { id: "editEmail", error: "Ingrese un correo válido" },
        { id: "editRol", error: "Seleccione un rol" }
      ];

      requiredFields.forEach(field => {
        const input = document.getElementById(field.id);
        const error = document.getElementById(`${field.id}-error`);
        if (!input.value) {
          input.classList.add("input-error");
          error.classList.remove("hidden");
          isValid = false;
        } else if (field.id === "editEmail" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
          input.classList.add("input-error");
          error.classList.remove("hidden");
          isValid = false;
        } else {
          input.classList.remove("input-error");
          error.classList.add("hidden");
        }
      });

      const password = document.getElementById("editPassword");
      const passwordError = document.getElementById("editPassword-error");
      if (password.value && password.value.length < 8) {
        password.classList.add("input-error");
        passwordError.classList.remove("hidden");
        isValid = false;
      } else {
        password.classList.remove("input-error");
        passwordError.classList.add("hidden");
      }

      const telefono = document.getElementById("editTelefono");
      const telefonoError = document.getElementById("editTelefono-error");
      if (telefono.value && !/^[0-9]{10}$/.test(telefono.value)) {
        telefono.classList.add("input-error");
        telefonoError.classList.remove("hidden");
        isValid = false;
      } else {
        telefono.classList.remove("input-error");
        telefonoError.classList.add("hidden");
      }

      if (isValid) {
        const userId = parseInt(document.getElementById("editUserId").value);
        const userData = {
          id: userId,
          nombreCompleto: document.getElementById("editNombreCompleto").value,
          email: document.getElementById("editEmail").value,
          password: document.getElementById("editPassword").value || users.find(u => u.id === userId).password,
          rol: document.getElementById("editRol").value,
          estado: document.getElementById("editEstado").value || "N/A",
          telefono: document.getElementById("editTelefono").value || ""
        };
        users = users.map(user => (user.id === userId ? userData : user));
        renderTable();
        document.getElementById("editModal").classList.remove("show");
        showToast("Usuario actualizado con éxito");
      }
    });

    // Handle delete confirmation
    document.getElementById("confirmDelete").addEventListener("click", () => {
      const userId = parseInt(document.getElementById("confirmDelete").getAttribute("data-user-id"));
      users = users.filter(user => user.id !== userId);
      renderTable();
      document.getElementById("deleteModal").classList.remove("show");
      showToast("Usuario eliminado con éxito");
    });

    // Export CSV (placeholder)
    document.getElementById("exportCsv").addEventListener("click", () => {
      const csv = ["ID,Nombre Completo,Email,Rol,Estado,Teléfono"];
      users.forEach(user => {
        csv.push(`${user.id},"${user.nombreCompleto}","${user.email}","${user.rol}","${user.estado || "N/A"}","${user.telefono || ""}"`);
      });
      const blob = new Blob([csv.join("\n")], { type: "text/csv" });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "usuarios_sigam.csv";
      a.click();
      URL.revokeObjectURL(url);
      showToast("Datos exportados como CSV");
    });

    // Initialize page
    initializeTomSelect();
    renderTable();