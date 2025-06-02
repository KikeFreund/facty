<style>
    .navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .navbar-brand {
        font-weight: 600;
        font-size: 1.4rem;
        color: white !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .navbar-brand i {
        font-size: 1.6rem;
    }
    .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
        padding: 0.5rem 1rem !important;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .nav-link:hover {
        color: white !important;
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }
    .nav-link.active {
        background: rgba(255, 255, 255, 0.2);
        color: white !important;
    }
    .navbar-toggler {
        border: none;
        padding: 0.5rem;
    }
    .navbar-toggler:focus {
        box-shadow: none;
    }
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
</style>

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
                    <a class="nav-link <?php echo ($uri === 'reportes') ? 'active' : ''; ?>" href="/reportes">
                        <i class="fas fa-chart-bar me-1"></i>Reportes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'configuracion') ? 'active' : ''; ?>" href="/configuracion">
                        <i class="fas fa-cog me-1"></i>Configuración
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'login') ? 'active' : ''; ?>" href="/login">
                        <i class="fas fa-sign-in-alt me-1"></i>Iniciar sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
