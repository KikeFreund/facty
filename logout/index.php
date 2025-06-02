<head>
    <meta charset="UTF-8">
    <title>Buscar Facturación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('assets/img/laptop.jpg') no-repeat center center;
            background-size: cover;
            height: 300px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 5px solid #0d6efd;
            padding: 1rem;
            margin-top: 2rem;
            border-radius: .5rem;
        }
    </style>
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
