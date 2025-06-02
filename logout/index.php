<head>
    <meta charset="UTF-8">
    <title>Buscar Facturación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

    <!-- Encabezado visual -->
    <div class="hero">
        <h1 class="display-4">Consulta para Facturación</h1>
    </div>

    <div class="container mt-5">

        <!-- Formulario de búsqueda -->
        <div class="text-center mb-4">
            <h2>Buscar datos para facturación</h2>
            <p>Ingresa el ID de datos fiscales.</p>
        </div>

        <form action="factura.php" method="GET" class="mx-auto" style="max-width: 500px;">
            <div class="input-group mb-3">
                <input type="text" name="id" class="form-control" placeholder="ID de facturación" required>
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </form>

        <!-- Contenido adicional -->
        <div class="row mt-5">
            <div class="col-md-6">
                <img src="assets/img/papeles.jpg" class="img-fluid rounded shadow" alt="Facturación electrónica">
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <h5>¿Qué es la facturación?</h5>
                    <p>La facturación electrónica es el proceso mediante el cual las empresas emiten comprobantes digitales de sus transacciones. Este sistema permite un mejor control fiscal, reducción de papel y mayor seguridad.</p>
                    <ul>
                        <li>Comprobantes fiscales válidos</li>
                        <li>Consulta rápida y segura</li>
                        <li>Historial disponible</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</body>
