
    // Initialize TomSelect dropdowns
    let nombreHermanoSelect, estadoSelect, gradoSelect, trimestreSelect;
    function initializeTomSelect() {
      nombreHermanoSelect = new TomSelect("#nombreHermano", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Buscar o seleccionar hermano...",
        options: [
          { value: "Rodrigo", text: "Rodrigo" },
          { value: "Fernando", text: "Fernando" },
          { value: "Carlos", text: "Carlos" },
          { value: "Eduardo", text: "Eduardo" },
          { value: "Héctor", text: "Héctor" }
        ]
      });
      estadoSelect = new TomSelect("#estado", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Seleccionar estado...",
        options: [
          { value: "Activo", text: "Activo" },
          { value: "Inactivo", text: "Inactivo" }
        ]
      });
      gradoSelect = new TomSelect("#grado", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Seleccionar grado...",
        options: [
          { value: "Aprendiz", text: "Aprendiz" },
          { value: "Compañero", text: "Compañero" },
          { value: "Maestro", text: "Maestro" }
        ]
      });
      trimestreSelect = new TomSelect("#trimestre", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Seleccionar trimestre...",
        options: [
          { value: "Ene - Mar", text: "Ene - Mar" },
          { value: "Abr - Jun", text: "Abr - Jun" },
          { value: "Jul - Sep", text: "Jul - Sep" },
          { value: "Oct - Dic", text: "Oct - Dic" }
        ]
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

    // Calculate total amount
    function calculateTotal() {
      const fields = ["capitas", "seguro", "iniciacion", "aumentoSalario", "exaltacion", "regularizacion"];
      const total = fields.reduce((sum, id) => {
        const value = parseFloat(document.getElementById(id).value) || 0;
        return sum + value;
      }, 0);
      document.getElementById("totalAmount").textContent = total.toFixed(2);
    }

    // Collapsible sections
    document.querySelectorAll(".collapsible-header").forEach(header => {
      header.addEventListener("click", () => {
        const content = header.nextElementSibling;
        const icon = header.querySelector("svg");
        content.classList.toggle("open");
        icon.classList.toggle("rotate-180");
      });
    });

    // Form validation and submission
    document.getElementById("tesoreriaForm").addEventListener("submit", function(e) {
      e.preventDefault();
      let isValid = true;
      const requiredFields = [
        { id: "logia", error: "Este campo es obligatorio" },
        { id: "numeroLogia", error: "Ingrese un número válido" },
        { id: "oriente", error: "Este campo es obligatorio" },
        { id: "nombreHermano", error: "Seleccione un hermano" }
      ];

      requiredFields.forEach(field => {
        const input = document.getElementById(field.id);
        const error = document.getElementById(`${field.id}-error`);
        const value = input.value.trim();
        if (!value || (field.id === "numeroLogia" && value <= 0)) {
          input.classList.add("input-error");
          error.classList.remove("hidden");
          isValid = false;
        } else {
          input.classList.remove("input-error");
          error.classList.add("hidden");
        }
      });

      if (isValid) {
        const formData = {
          logia: document.getElementById("logia").value.toUpperCase(),
          numeroLogia: document.getElementById("numeroLogia").value,
          oriente: document.getElementById("oriente").value.toUpperCase(),
          nombreHermano: document.getElementById("nombreHermano").value,
          estado: document.getElementById("estado").value || "N/A",
          grado: document.getElementById("grado").value || "N/A",
          trimestre: document.getElementById("trimestre").value || "N/A",
          capitas: parseFloat(document.getElementById("capitas").value) || 0,
          seguro: parseFloat(document.getElementById("seguro").value) || 0,
          iniciacion: parseFloat(document.getElementById("iniciacion").value) || 0,
          aumentoSalario: parseFloat(document.getElementById("aumentoSalario").value) || 0,
          exaltacion: parseFloat(document.getElementById("exaltacion").value) || 0,
          regularizacion: parseFloat(document.getElementById("regularizacion").value) || 0,
          total: parseFloat(document.getElementById("totalAmount").textContent)
        };

        // Simulate async submission
        this.classList.add("loading");
        document.querySelectorAll("button[type='submit']").forEach(btn => btn.disabled = true);
        setTimeout(() => {
          console.log("Form Data:", formData);
          showToast("Registro guardado con éxito");
          this.reset();
          nombreHermanoSelect.clear();
          estadoSelect.clear();
          gradoSelect.clear();
          trimestreSelect.clear();
          calculateTotal();
          this.classList.remove("loading");
          document.querySelectorAll("button[type='submit']").forEach(btn => btn.disabled = false);
        }, 1000);
      } else {
        showToast("Por favor, corrija los errores en el formulario", true);
      }
    });

    // Form reset
    document.getElementById("tesoreriaForm").addEventListener("reset", function() {
      document.querySelectorAll(".input-error").forEach(input => input.classList.remove("input-error"));
      document.querySelectorAll(".error-message").forEach(error => error.classList.add("hidden"));
      nombreHermanoSelect.clear();
      estadoSelect.clear();
      gradoSelect.clear();
      trimestreSelect.clear();
      calculateTotal();
      showToast("Formulario limpiado");
    });

    // Real-time input formatting and validation
    document.getElementById("logia").addEventListener("input", function() {
      this.value = this.value.toUpperCase();
      validateField(this, "logia-error", !!this.value, "Este campo es obligatorio");
    });

    document.getElementById("oriente").addEventListener("input", function() {
      this.value = this.value.toUpperCase();
      validateField(this, "oriente-error", !!this.value, "Este campo es obligatorio");
    });

    document.getElementById("numeroLogia").addEventListener("input", function() {
      validateField(this, "numeroLogia-error", this.value > 0, "Ingrese un número válido");
    });

    document.getElementById("nombreHermano").addEventListener("change", function() {
      validateField(this, "nombreHermano-error", !!this.value, "Seleccione un hermano");
    });

    // Financial fields total calculation
    ["capitas", "seguro", "iniciacion", "aumentoSalario", "exaltacion", "regularizacion"].forEach(id => {
      document.getElementById(id).addEventListener("input", function() {
        this.value = this.value < 0 ? 0 : this.value;
        calculateTotal();
      });
    });

    function validateField(input, errorId, isValid, errorMessage) {
      const error = document.getElementById(errorId);
      if (!isValid) {
        input.classList.add("input-error");
        error.classList.remove("hidden");
        error.textContent = errorMessage;
      } else {
        input.classList.remove("input-error");
        error.classList.add("hidden");
      }
    }

    // Keyboard shortcuts
    document.addEventListener("keydown", (e) => {
      if (e.ctrlKey && e.key === "s") {
        e.preventDefault();
        document.getElementById("tesoreriaForm").dispatchEvent(new Event("submit"));
      }
      if (e.ctrlKey && e.key === "t") {
        e.preventDefault();
        document.getElementById("logia").focus();
      }
    });

    // Mobile sidebar toggle (placeholder)
    /*
    document.querySelector(".hamburger").addEventListener("click", () => {
      const sidebar = document.querySelector(".sidebar");
      sidebar.style.display = sidebar.style.display === "block" ? "none" : "block";
    });
    */

    // Focus first field on load
    document.getElementById("logia").focus();

    // Initialize page
    initializeTomSelect();
    calculateTotal();