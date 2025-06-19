<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Empresa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h1 class="mb-4 text-center">Bienvenido al Panel de Empresa</h1>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">Ver Tickets</h5>
            <p class="card-text">Consulta los tickets que te han dado los clientes.</p>
            <a href="ver-tickets.php" class="btn btn-primary">Ir a Tickets</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">Registrar Datos Fiscales</h5>
            <p class="card-text">Registra los datos fiscales de tu empresa para facturación.</p>
            <a href="registrar-datos-fiscales.php" class="btn btn-primary">Registrar</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">Editar Datos</h5>
            <p class="card-text">Edita el nombre, dirección y teléfono de tu empresa.</p>
            <a href="editar-datos.php" class="btn btn-primary">Editar</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">Lector QR</h5>
            <p class="card-text">Accede al lector de códigos QR para procesar tickets.</p>
            <a href="lector-qr.php" class="btn btn-primary">Lector QR</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
