
    // Initialize Lucide icons
    lucide.createIcons();

    // Sample data
    const datosPorTrimestre = {
      "2025": {
        "ene-mar": [],
        "abr-jun": [],
        "jul-sep": [
          ["1", "Rodrigo Pérez", "C", 70, 90, 0, 0, 0, 0, 160],
          ["2", "Fernando Gómez", "C", 70, 90, 0, 0, 0, 0, 160],
          ["3", "Carlos Ruiz", "C", 70, 90, 0, 0, 0, 0, 160]
        ],
        "oct-dic": []
      },
      "2024": {
        "ene-mar": [["4", "Eduardo López", "M", 80, 100, 0, 0, 0, 0, 180]],
        "abr-jun": [],
        "jul-sep": [],
        "oct-dic": []
      },
      "2023": { "ene-mar": [], "abr-jun": [], "jul-sep": [], "oct-dic": [] },
      "2022": { "ene-mar": [], "abr-jun": [], "jul-sep": [], "oct-dic": [] },
      "2021": { "ene-mar": [], "abr-jun": [], "jul-sep": [], "oct-dic": [] },
      "2020": { "ene-mar": [], "abr-jun": [], "jul-sep": [], "oct-dic": [] }
    };

    let tabla, trimestreSelect, yearSelect, gradoFilter, nombreFilter;

    // Debounce function
    function debounce(func, wait) {
      let timeout;
      return function executedFunction(...args) {
        const later = () => {
          clearTimeout(timeout);
          func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
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

    // Calculate totals and update summary
    function calculateTotals(data) {
      const totals = [0, 0, 0, 0, 0, 0, 0];
      data.forEach(row => {
        totals[0] += parseFloat(row[3]) || 0; // Cápitas
        totals[1] += parseFloat(row[4]) || 0; // Seguro
        totals[2] += parseFloat(row[5]) || 0; // Iniciación
        totals[3] += parseFloat(row[6]) || 0; // Aumento
        totals[4] += parseFloat(row[7]) || 0; // Exaltación
        totals[5] += parseFloat(row[8]) || 0; // Afiliación
        totals[6] += parseFloat(row[9]) || 0; // Subtotal
      });
      document.getElementById("totalPayments").textContent = `$${totals[6].toFixed(2)}`;
      document.getElementById("recordCount").textContent = data.length;
      return totals.map(total => total.toFixed(2));
    }

    // Format currency
    function formatCurrency(value) {
      return `$${parseFloat(value).toFixed(2)}`;
    }

    // Show progress bar
    function showProgress() {
      const progress = document.getElementById("exportProgress");
      const bar = document.getElementById("progressBar");
      progress.classList.add("active");
      bar.style.width = "0%";
      setTimeout(() => {
        bar.style.width = "100%";
      }, 50);
      setTimeout(() => {
        progress.classList.remove("active");
        bar.style.width = "0%";
      }, 1000);
    }

    // Initialize DataTable
    function initializeDataTable(data) {
      const totals = calculateTotals(data);
      tabla = $('#tablaPagos').DataTable({
        data: data,
        columns: [
          { title: "No" },
          { title: "Nombre del Hermano" },
          { title: "Grado" },
          { title: "Cápitas", render: data => formatCurrency(data) },
          { title: "Seguro Masónico", render: data => formatCurrency(data) },
          { title: "Iniciación", render: data => formatCurrency(data) },
          { title: "Aumento de Salario", render: data => formatCurrency(data) },
          { title: "Exaltación", render: data => formatCurrency(data) },
          { title: "Afiliación y/o regularización", render: data => formatCurrency(data) },
          { title: "Subtotal", render: data => formatCurrency(data) }
        ],
        language: {
          search: "Buscar:",
          lengthMenu: "Mostrar _MENU_ registros",
          info: "Mostrando _START_ a _END_ de _TOTAL_",
          infoFiltered: "(filtrado de _MAX_ registros)",
          paginate: { previous: "Anterior", next: "Siguiente" },
          emptyTable: `
            <div class="empty-state">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6m4 4H3m3-8v6m12-6v6"/>
              </svg>
              <p>No hay pagos registrados para este trimestre y año</p>
            </div>
          `
        },
        paging: true,
        lengthMenu: [[10, 15, 30, -1], [10, 15, 30, "Todos"]],
        responsive: true,
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        footerCallback: function(row, data, start, end, display) {
          const api = this.api();
          api.columns([3, 4, 5, 6, 7, 8, 9]).every(function(index) {
            const colIndex = index - 3;
            $(api.column(index).footer()).html(
              index === 3 ? `<strong>Total:</strong>` : formatCurrency(totals[colIndex])
            );
          });
        },
        drawCallback: function() {
          $(this).find('tbody tr').css('animation', 'fadeInUp 0.4s ease');
        },
        initComplete: function() {
          this.api().columns([1, 2]).every(function(index) {
            const column = this;
            const select = $(`<select class="column-filter" aria-label="Filtrar ${index === 1 ? 'Nombre del Hermano' : 'Grado'}"><option value="">Todos</option></select>`)
              .appendTo($(column.header()).append('<div class="filter-container"></div>').find('.filter-container'))
              .on('change', function() {
                const val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? `^${val}$` : '', true, false).draw();
              });
            const options = [];
            column.data().unique().sort().each(function(d) {
              if (d) options.push({ value: d, text: d });
            });
            new TomSelect(select[0], {
              options: options,
              create: false,
              sortField: { field: "text", direction: "asc" },
              placeholder: `Filtrar ${index === 1 ? 'Nombre' : 'Grado'}...`
            });
          });
        }
      });
      $('#tablaPagos').append(
        '<tfoot><tr><th>Total:</th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot>'
      );
    }

    // Initialize TomSelect
    function initializeTomSelect() {
      trimestreSelect = new TomSelect("#trimestre", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Seleccionar trimestre...",
        options: [
          { value: "ene-mar", text: "Ene - Mar" },
          { value: "abr-jun", text: "Abr - Jun" },
          { value: "jul-sep", text: "Jul - Sep" },
          { value: "oct-dic", text: "Oct - Dic" }
        ],
        value: "jul-sep"
      });
      yearSelect = new TomSelect("#year", {
        create: false,
        sortField: { field: "text", direction: "desc" },
        placeholder: "Seleccionar año...",
        options: [
          { value: "2025", text: "2025" },
          { value: "2024", text: "2024" },
          { value: "2023", text: "2023" },
          { value: "2022", text: "2022" },
          { value: "2021", text: "2021" },
          { value: "2020", text: "2020" }
        ],
        value: "2025"
      });
    }

    // Update table data
    const updateTable = debounce(function() {
      const trimestre = trimestreSelect.getValue();
      const year = yearSelect.getValue();
      const data = datosPorTrimestre[year][trimestre] || [];
      tabla.clear().rows.add(data).draw();
      calculateTotals(data);
      showToast("Reporte actualizado");
    }, 300);

    // Export to CSV
    function exportToCsv(data, trimestre, year) {
      const headers = ["No", "Nombre del Hermano", "Grado", "Cápitas", "Seguro Masónico", "Iniciación", "Aumento de Salario", "Exaltación", "Afiliación y/o regularización", "Subtotal"];
      const totals = calculateTotals(data);
      const csvRows = [
        headers.join(","),
        ...data.map(row => row.map(cell => `"${cell}"`).join(",")),
        ["Total:","","",...totals.map(total => `"${total}"`)]
      ];
      const csv = csvRows.join("\n");
      const blob = new Blob([csv], { type: "text/csv" });
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.setAttribute("href", url);
      a.setAttribute("download", `Relacion_Pagos_${trimestre}_${year}.csv`);
      a.click();
      window.URL.revokeObjectURL(url);
    }

    // Export to PDF
    function exportToPdf(data, trimestre, year) {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      doc.setFont("Roboto", "normal");
      doc.setFontSize(14);
      doc.text("Relación de Pagos - Gran Logia del Estado de Guerrero", 20, 20);
      doc.setFontSize(10);
      doc.text(`Trimestre: ${trimestre.toUpperCase()} | Año: ${year}`, 20, 30);
      doc.autoTable({
        head: [["No", "Nombre del Hermano", "Grado", "Cápitas", "Seguro Masónico", "Iniciación", "Aumento de Salario", "Exaltación", "Afiliación y/o regularización", "Subtotal"]],
        body: data,
        foot: [["Total:", "", "", ...calculateTotals(data)]],
        startY: 40,
        styles: { font: "Roboto", fontSize: 8, cellPadding: 2 },
        headStyles: { fillColor: [52, 152, 219], textColor: [255, 255, 255] },
        footStyles: { fillColor: [39, 174, 96], textColor: [255, 255, 255] },
        alternateRowStyles: { fillColor: [245, 245, 245] },
        columnStyles: {
          0: { cellWidth: 10 },
          1: { cellWidth: 40 },
          2: { cellWidth: 15 },
          3: { cellWidth: 20 },
          4: { cellWidth: 20 },
          5: { cellWidth: 20 },
          6: { cellWidth: 20 },
          7: { cellWidth: 20 },
          8: { cellWidth: 20 },
          9: { cellWidth: 20 }
        }
      });
      doc.save(`Relacion_Pagos_${trimestre}_${year}.pdf`);
    }

    $(document).ready(function() {
      initializeTomSelect();
      initializeDataTable(datosPorTrimestre["2025"]["jul-sep"]);

      // Filter change
      $('#trimestre, #year').on('change', updateTable);

      // Reset filters
      $('#resetFilters').on('click', function() {
        trimestreSelect.setValue("jul-sep");
        yearSelect.setValue("2025");
        updateTable();
        showToast("Filtros restablecidos");
      });

      // Export CSV
      $('#exportCsv').on('click', function() {
        const trimestre = trimestreSelect.getValue();
        const year = yearSelect.getValue();
        const data = datosPorTrimestre[year][trimestre] || [];
        if (!data.length) {
          showToast("No hay datos para exportar", true);
          return;
        }
        $(this).addClass("loading");
        showProgress();
        setTimeout(() => {
          exportToCsv(data, trimestre, year);
          showToast("Exportado a CSV con éxito");
          $(this).removeClass("loading");
        }, 1000);
      });

      // Export PDF
      $('#exportPdf').on('click', function() {
        const trimestre = trimestreSelect.getValue();
        const year = yearSelect.getValue();
        const data = datosPorTrimestre[year][trimestre] || [];
        if (!data.length) {
          showToast("No hay datos para exportar", true);
          return;
        }
        $(this).addClass("loading");
        showProgress();
        setTimeout(() => {
          exportToPdf(data, trimestre, year);
          showToast("Exportado a PDF con éxito");
          $(this).removeClass("loading");
        }, 1000);
      });

      // Keyboard shortcuts
      $(document).on('keydown', e => {
        if (e.ctrlKey && e.key === "f") {
          e.preventDefault();
          trimestreSelect.focus();
        }
        if (e.ctrlKey && e.key === "e") {
          e.preventDefault();
          $('#exportCsv').trigger('click');
        }
      });

      // Focus first filter
      trimestreSelect.focus();

      // Mobile sidebar toggle (placeholder)
      /*
      $('.hamburger').on('click', () => {
        const sidebar = $('.sidebar');
        sidebar.css('display', sidebar.css('display') === 'block' ? 'none' : 'block');
      });
      */
    });