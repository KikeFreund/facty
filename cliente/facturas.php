<?php
require('assets/php/conexiones/conexionMySqli.php');
$ticket_id = $_GET['ticket_id'] ?? '';

// ───────────────────────────────── FORMULARIO DE BÚSQUEDA
?>

<body class="bg-light">

<div class="container py-5">
  <h2 class="mb-4 text-center">Consultar facturas por Ticket</h2>

  <form class="row g-3 mb-4" method="GET">
    <div class="col-auto">
      <input type="text" name="ticket_id" class="form-control" placeholder="ID del ticket"
             value="<?= htmlspecialchars($ticket_id) ?>" required>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
  </form>

<?php
// ───────────────────────────────── RESULTADOS (si se envió un ticket)
if ($ticket_id !== '') {
    $stmt = $conn->prepare("SELECT id, nombre_archivo, archivo_pdf, archivo_xml, creado_en
                            FROM facturas WHERE ticket_id = ?");
    $stmt->bind_param("s", $ticket_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) { ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>PDF</th>
                <th>XML</th>
                <th>Fecha de carga</th>
              </tr>
            </thead>
            <tbody>
            <?php while ($f = $res->fetch_assoc()) { ?>
              <tr>
                <td><?= $f['id'] ?></td>
                <td><?= htmlspecialchars($f['nombre_archivo']) ?></td>
                <td>
                  <a href="<?= htmlspecialchars($f['archivo_pdf']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                    Ver / Descargar PDF
                  </a>
                </td>
                <td>
                  <a href="<?= htmlspecialchars($f['archivo_xml']) ?>" download class="btn btn-sm btn-outline-secondary">
                    Descargar XML
                  </a>
                </td>
                <td><?= $f['creado_en'] ?></td>
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
