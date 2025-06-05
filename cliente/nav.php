<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-file-invoice"></i>
            FactyFlow
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === '' || $uri === 'index') ? 'active' : ''; ?>" href="/">
                        <i class="fas fa-home me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'reportes') ? 'active' : ''; ?>" href="/lector-qr">
                        <i class="fas fa-chart-bar me-1"></i>QR
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'configuracion') ? 'active' : ''; ?>" href="/configuracion">
                        <i class="fas fa-cog me-1"></i>Configuración
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'login') ? 'active' : ''; ?>" href="funciones/logout.php">
                        <i class="fas fa-sign-in-alt me-1"></i>Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
