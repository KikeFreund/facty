
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .navbar {
            background-color: #2c3e50;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        .btn-logout {
            background-color: #e74c3c;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #c0392b;
            color: white;
            transform: scale(1.05);
        }
        .welcome-section {
            background-color: #f8f9fa;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
 

    <!-- Contenido Principal -->
    <div class="container">
        <div class="welcome-section text-center rounded shadow-sm">
            <h1 class="display-4">Bienvenido al Panel de Cliente</h1>
            <p class="lead">Aquí podrás gestionar tus servicios y consultar tu información</p>
        </div>

        <!-- Aquí puedes agregar más contenido según necesites -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-info-circle me-2"></i>Información Personal</h5>
                        <p class="card-text">Gestiona tu información personal y datos de contacto.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-cogs me-2"></i>Mis Servicios</h5>
                        <p class="card-text">Consulta y administra los servicios contratados.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-file-invoice me-2"></i>Facturas</h5>
                        <p class="card-text">Accede a tu historial de facturas y pagos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
