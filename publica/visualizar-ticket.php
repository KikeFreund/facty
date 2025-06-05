<?php
$id_ticket = $_GET['id'] ?? null;
if (!$id_ticket) die("Falta el ID.");

$archivoQR = "qrs/qr_$id_ticket.png";
$urlFactura = "https://tupagina.com/facturacion?id=$id_ticket";
$urlQR = "https://movilistica.com/archivos/qrs/$archivoQR";

$mensaje = "Aquí tienes los datos para la factura solicitada:\n\nVer factura: $urlFactura\nCódigo QR: $urlQR";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>QR Factura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 text-center">
  <h3>Factura generada exitosamente</h3>
  <p>Ticket: #<?= htmlspecialchars($id_ticket) ?></p>

  <img src="<?= $archivoQR ?>" class="img-thumbnail mb-3" style="max-width: 250px;">

  <div class="mb-3">
    <label for="telefono" class="form-label">Número de WhatsApp (con código de país)</label>
    <input type="tel" class="form-control" id="telefono" placeholder="Ej. 5215555555555">
  </div>

  <button onclick="enviarWhatsApp()" class="btn btn-success">Enviar por WhatsApp</button>
</div>

<script>
function enviarWhatsApp() {
  const telefono = document.getElementById('telefono').value.trim();
  const mensaje = <?= json_encode($mensaje) ?>;
  if (telefono === '') {
    alert('Escribe un número válido.');
    return;
  }
  const url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
  window.open(url, '_blank');
}
</script>
</body>
</html>
