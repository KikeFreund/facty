<?php
$id_ticket = $_GET['id'] ?? null;
if (!$id_ticket) die("Falta el ID.");

$archivoQR = "https://movilistica.com/archivos/qrs/qr_$id_ticket.png";
$urlFactura = "https://tupagina.com/facturacion?id=$id_ticket";
$urlQR = "https://movilistica.com/$archivoQR";

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
  <h3>Datos para facturar.</h3>

  <style>
  .copiable {
    cursor: pointer;
    user-select: all;
    transition: background-color 0.2s ease;
  }
  .copiable:hover {
    background-color: #f1f1f1;
  }
</style>

<p class="copiable" onclick="copiarTexto(this)">Ticket: #<?= htmlspecialchars($id_ticket) ?></p>
<p class="copiable" onclick="copiarTexto(this)">Régimen: Persona Física</p>
<p class="copiable" onclick="copiarTexto(this)">RFC: ABC123456XYZ</p>

<script>
function copiarTexto(elemento) {
  const texto = elemento.innerText;
  navigator.clipboard.writeText(texto).then(() => {
    const original = elemento.innerText;
    elemento.innerText = '✅ Copiado';
    setTimeout(() => {
      elemento.innerText = original;
    }, 1500);
  }).catch(err => {
    alert("No se pudo copiar");
    console.error(err);
  });
}
</script>

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
    alert('sin un numero de telefono seleccionalo entre tus contactos.');
    const url = `https://wa.me/?text=${encodeURIComponent(mensaje)}`;
    window.open(url, '_blank');
 
  }
  const url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
  window.open(url, '_blank');
}
</script>
</body>
</html>
