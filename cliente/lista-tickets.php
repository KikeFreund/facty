<?php
require('assets/php/conexiones/conexionMySqli.php');
$cliente_id = $_SESSION['id_usuario'];
?>

<body class="bg-light">

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h2 class="mb-3">
                <i class="fas fa-ticket-alt me-2"></i>Mis Tickets
            </h2>
            <p class="text-muted">Aquí puedes ver todos tus tickets de facturación</p>
        </div>
        <div class="col-auto">
            <a href="/generar-ticket" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Nuevo Ticket
            </a>
        </div>
    </div>

<?php
if ($cliente_id !== '') {
    // Consulta para obtener todos los tickets del cliente
    $stmt = $conn->prepare("SELECT t.id, t.monto, t.fecha, t.numeroTicket, t.usoCfdi, t.metodoPago,
                                   df.razonSocial, df.rfc, uc.descripcion as uso_cfdi_desc,
                                   mp.nombre as metodo_pago_nombre,
                                   (SELECT COUNT(*) FROM facturas f WHERE f.ticket_id = t.id) as num_facturas
                            FROM ticket t
                            LEFT JOIN datosFiscales df ON t.id_datos = df.id
                            LEFT JOIN usosCfdi uc ON t.usoCfdi = uc.id
                            LEFT JOIN metodosPago mp ON t.metodoPago = mp.id
                            WHERE t.id_cliente = ?
                            ORDER BY t.fecha DESC");
    
    if ($stmt === false) {
        echo '<div class="alert alert-danger">Error en la consulta SQL: ' . $conn->error . '</div>';
    } else {
        $stmt->bind_param("s", $cliente_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) { ?>
            <div class="row">
                <?php while ($ticket = $res->fetch_assoc()) { ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-ticket-alt me-1"></i>Ticket #<?= $ticket['id'] ?>
                                    </h6>
                                    <span class="badge bg-light text-dark">
                                        <?= $ticket['num_facturas'] ?> factura<?= $ticket['num_facturas'] != 1 ? 's' : '' ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h5 class="card-title text-primary">$<?= number_format($ticket['monto'], 2) ?></h5>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($ticket['fecha'])) ?>
                                    </small>
                                </div>
                                
                                <?php if ($ticket['numeroTicket']) { ?>
                                    <div class="mb-2">
                                        <small class="text-muted">Número de Ticket:</small>
                                        <div class="fw-bold"><?= htmlspecialchars($ticket['numeroTicket']) ?></div>
                                    </div>
                                <?php } ?>
                                
                                <div class="mb-2">
                                    <small class="text-muted">Datos Fiscales:</small>
                                    <div class="fw-bold"><?= htmlspecialchars($ticket['razonSocial']) ?></div>
                                    <small class="text-muted"><?= htmlspecialchars($ticket['rfc']) ?></small>
                                </div>
                                
                                <div class="mb-2">
                                    <small class="text-muted">Uso CFDI:</small>
                                    <div class="fw-bold"><?= htmlspecialchars($ticket['uso_cfdi_desc']) ?></div>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted">Método de Pago:</small>
                                    <div class="fw-bold"><?= htmlspecialchars($ticket['metodo_pago_nombre']) ?></div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-grid gap-2">
                                    <a href="/visualizar-ticket?id=<?= $ticket['id'] ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Ver Detalles
                                    </a>
                                    <?php if ($ticket['num_facturas'] > 0) { ?>
                                        <a href="/facturas?ticket_id=<?= $ticket['id'] ?>" 
                                           class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-file-invoice me-1"></i>Ver Facturas
                                        </a>
                                    <?php } else { ?>
                                        <button class="btn btn-outline-warning btn-sm" disabled>
                                            <i class="fas fa-clock me-1"></i>Pendiente de Facturación
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            
            <!-- Resumen estadístico -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4 class="mb-0"><?= $res->num_rows ?></h4>
                            <small>Total de Tickets</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <?php
                            $stmt->execute();
                            $res2 = $stmt->get_result();
                            $total_facturas = 0;
                            while ($t = $res2->fetch_assoc()) {
                                $total_facturas += $t['num_facturas'];
                            }
                            ?>
                            <h4 class="mb-0"><?= $total_facturas ?></h4>
                            <small>Total de Facturas</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <?php
                            $stmt->execute();
                            $res3 = $stmt->get_result();
                            $total_monto = 0;
                            while ($t = $res3->fetch_assoc()) {
                                $total_monto += $t['monto'];
                            }
                            ?>
                            <h4 class="mb-0">$<?= number_format($total_monto, 2) ?></h4>
                            <small>Monto Total</small>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php
        } else {
            echo '<div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    <h5>No tienes tickets aún</h5>
                    <p>Comienza creando tu primer ticket de facturación</p>
                    <a href="/generar-ticket" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Crear Primer Ticket
                    </a>
                  </div>';
        }
        $stmt->close();
    }
}
?>
</div>

</body>
