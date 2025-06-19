<?php

require_once 'assets/php/conexiones/conexionMySqli.php';
//session_start();
$empresa_id = $_SESSION['id_usuario'] ?? null;

if (!$empresa_id) {
    echo '<div class="alert alert-danger text-center">No has iniciado sesión.</div>';
    include 'footer.php';
    exit;
}

$query = "SELECT t.id, t.monto, t.fecha, t.numeroTicket, t.descripcion, t.id_cliente, df.razonSocial, df.rfc
          FROM ticket t
          LEFT JOIN datosFiscales df ON t.id_datos = df.id
          WHERE t.id_empresa = ?
          ORDER BY t.fecha DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $empresa_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="container py-5">
    <h2 class="mb-4 text-center">Tickets Recibidos</h2>
    <?php if ($res->num_rows > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Datos Fiscales</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($ticket = $res->fetch_assoc()): ?>
                <tr>
                    <td>#<?= $ticket['id'] ?></td>
                    <td><?= htmlspecialchars($ticket['id_cliente']) ?></td>
                    <td>$<?= number_format($ticket['monto'], 2) ?></td>
                    <td><?= htmlspecialchars($ticket['descripcion']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($ticket['fecha'])) ?></td>
                    <td>
                        <?= htmlspecialchars($ticket['razonSocial']) ?><br>
                        <small class="text-muted">RFC: <?= htmlspecialchars($ticket['rfc']) ?></small>
                    </td>
                    <td>
                        <a href="../pages/visualizar-ticket.php?id=<?= $ticket['id'] ?>" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>
            <h5>No se encontraron tickets</h5>
            <p>Cuando recibas tickets de tus clientes, aparecerán aquí.</p>
        </div>
    <?php endif; ?>
</div>

