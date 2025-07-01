<?php
// reportes.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Generar Reporte Trimestral</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Iconos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../../css/elegir_reporte.css" rel="stylesheet">
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm p-4">
          <div class="text-center mb-4">
            <h3 class="fw-bold mb-1">Generar Reporte Trimestral</h3>
            <p class="text-muted">Selecciona el trimestre y el tipo de archivo</p>
          </div>
          <form action="generar_reporte.php" method="GET">
            <div class="mb-3">
              <label for="trimestre" class="form-label">Trimestre</label>
              <select name="trimestre" id="trimestre" class="form-select" required>
                <option value="">-- Selecciona --</option>
                <option value="ene-mar">Enero - Marzo</option>
                <option value="abr-jun">Abril - Junio</option>
                <option value="jul-sep">Julio - Septiembre</option>
                <option value="oct-dic">Octubre - Diciembre</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="tipo" class="form-label">Tipo de archivo</label>
              <select name="tipo" id="tipo" class="form-select" required>
                <option value="">-- Selecciona --</option>
                <option value="pdf">PDF <i class="bi bi-file-earmark-pdf"></i></option>
                <option value="excel">Excel <i class="bi bi-file-earmark-excel"></i></option>
              </select>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-download me-2"></i>Generar Reporte
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
