<!-- administrar_usuarios.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrar Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <!-- CSS personalizado -->
  <link rel="stylesheet" href="../css/usuario.css">

</head>
<body>
  <div class="container py-5">
  <div class="header-gradient d-flex justify-content-between align-items-center mb-4">
  <h2 class="header-title m-0"><i data-feather="users"></i> Administración de Usuarios</h2>
  <button class="btn btn-agregar" data-bs-toggle="modal" data-bs-target="#modalAgregar">
    <i data-feather="user-plus"></i> Agregar Usuario
  </button>
</div>
<table id="tablaUsuarios" class="table table-striped table-bordered">
  <thead class="gradient-header">
        <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Área</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
          <!-- Aquí van los datos dinámicos -->
          <tr>
            <td>Juan</td>
            <td>Pérez Ramírez</td>
            <td>Finanzas</td>
            <td>jperez</td>
            <td>Admin</td>
            <td>
              <button class="btn btn-warning btn-sm"><i data-feather="edit"></i></button>
              <button class="btn btn-danger btn-sm"><i data-feather="trash-2"></i></button>
            </td>
          </tr>
          <!-- Agrega más filas aquí -->
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Agregar -->
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" action="agregar_usuario.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLabel">Nuevo Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Apellido Paterno</label>
            <input type="text" name="apellido_paterno" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Apellido Materno</label>
            <input type="text" name="apellido_materno" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" name="usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Área</label>
            <input type="text" name="area" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="rol" class="form-select">
              <option value="usuario">Usuario</option>
              <option value="admin">Administrador</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#tablaUsuarios').DataTable({
        language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_",
                infoFiltered: "(filtrado de _MAX_ registros)",
                paginate: { previous: "Anterior", next: "Siguiente" }
            },
            paging: true,
            lengthMenu: [[10, 15, 30, -1], [10, 15, 30, "Todos"]],
            responsive: true
      });
      feather.replace();
    });

  </script>
</body>
</html>
