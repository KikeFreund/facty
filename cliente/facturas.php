<?php
require('assets/php/conexiones/conexionMySqli.php');
$cliente_id = $_SESSION['id_usuario'];

// ───────────────────────────────── FORMULARIO DE BÚSQUEDA
?>

<body class="bg-light">

<div class="container py-5">
  <!-- <h2 class="mb-4 text-center">Consultar facturas por Ticket</h2> -->

  <!-- <form class="row g-3 mb-4" method="GET">
    <div class="col-auto">
      <input type="text" name="ticket_id" class="form-control" placeholder="ID del ticket"
             value="<?= htmlspecialchars($ticket_id) ?>" required>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
  </form> -->

<?php
// ───────────────────────────────── RESULTADOS (si se envió un ticket)
if ($cliente_id !== '') {
    $stmt = $conn->prepare("SELECT f.id, f.nombre_archivo, f.archivo_pdf, f.archivo_xml, f.creado_en, 
                                   t.id as ticket_id, t.monto as ticket_titulo, t.estado as ticket_estado
                            FROM facturas f
                            LEFT JOIN ticket t ON f.ticket_id = t.id
                            WHERE t.id_cliente = ?
                            ORDER BY f.creado_en DESC");
    $stmt->bind_param("s", $cliente_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) { ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Ticket</th>
                <th>PDF</th>
                <th>XML</th>
                <th>Fecha de carga</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            <?php while ($f = $res->fetch_assoc()) { ?>
              <tr>
                <td><?= $f['id'] ?></td>
                <td><?= htmlspecialchars($f['nombre_archivo']) ?></td>
                <td>
                  <div class="d-flex flex-column">
                    <strong>#<?= $f['ticket_id'] ?></strong>
                    <small class="text-muted"><?= htmlspecialchars($f['ticket_titulo']) ?></small>
                    <span class="badge bg-<?= $f['ticket_estado'] === 'completado' ? 'success' : ($f['ticket_estado'] === 'en_proceso' ? 'warning' : 'secondary') ?>">
                      <?= ucfirst(str_replace('_', ' ', $f['ticket_estado'])) ?>
                    </span>
                  </div>
                </td>
                <td>
                  <a href="https://www.movilistica.com/<?= htmlspecialchars($f['archivo_pdf']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-file-pdf me-1"></i>Ver PDF
                  </a>
                </td>
                <td>
                  <a href="https://www.movilistica.com/<?= htmlspecialchars($f['archivo_xml']) ?>" download class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-file-code me-1"></i>XML
                  </a>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($f['creado_en'])) ?></td>
                <td>
                  <a href="/visualizar-ticket?id=<?= $f['ticket_id'] ?>" class="btn btn-sm btn-info">
                    <i class="fas fa-ticket-alt me-1"></i>Ver Ticket
                  </a>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
<?php
    } else {
        echo '<div class="alert alert-warning">No se encontraron facturas para ese ticket.</div>';
    }
    $stmt->close();
}
?>
</div>

</body>
