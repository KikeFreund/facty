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
                    <a class="nav-link <?php echo ($uri === 'informacion-personal') ? 'active' : ''; ?>" href="/informacion-personal">
                        <i class="fas fa-user me-1"></i>Información Personal
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'facturas') ? 'active' : ''; ?>" href="/facturas">
                        <i class="fas fa-file-invoice-dollar me-1"></i>Facturas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'lector-qr') ? 'active' : ''; ?>" href="/lector-qr">
                        <i class="fas fa-qrcode me-1"></i>Lector QR
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'generar-ticket') ? 'active' : ''; ?>" href="/generar-ticket">
                        <i class="fas fa-ticket-alt me-1"></i>Generar Ticket
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'visualizar-ticket') ? 'active' : ''; ?>" href="/visualizar-ticket">
                        <i class="fas fa-eye me-1"></i>Ver Ticket
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'registrar-datos-fiscales') ? 'active' : ''; ?>" href="/registrar-datos-fiscales">
                        <i class="fas fa-plus-circle me-1"></i>Registrar Datos Fiscales
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'editar-datos-fiscales') ? 'active' : ''; ?>" href="/editar-datos-fiscales">
                        <i class="fas fa-edit me-1"></i>Editar Datos Fiscales
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($uri === 'login') ? 'active' : ''; ?>" href="funciones/logout.php">
                        <i class="fas fa-sign-out-alt me-1"></i>Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
