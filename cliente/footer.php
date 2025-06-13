<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Información de copyright -->
            <div class="col-md-4">
                <div class="mb-3">
                    <h6 class="text-light mb-2">
                        <i class="fas fa-file-invoice"></i> FactyFlow
                    </h6>
                    <p class="text-muted small">
                        Sistema integral de facturación y gestión de tickets fiscales
                    </p>
                </div>
                <p class="text-muted small">
                    <i class="fas fa-copyright"></i>
                    <?php echo date('Y'); ?> FactyFlow | Todos los derechos reservados
                </p>
            </div>
            
            <!-- Enlaces principales -->
            <div class="col-md-2">
                <h6 class="text-light mb-3">Navegación</h6>
                <div class="footer-links">
                    <a href="/" class="text-light d-block mb-2">
                        <i class="fas fa-home me-1"></i> Inicio
                    </a>
                    <a href="/lista-tickets" class="text-light d-block mb-2">
                        <i class="fas fa-ticket-alt me-1"></i> Mis Tickets
                    </a>
                    <a href="/facturas" class="text-light d-block mb-2">
                        <i class="fas fa-file-invoice-dollar me-1"></i> Facturas
                    </a>
                    <a href="/informacion-personal" class="text-light d-block mb-2">
                        <i class="fas fa-user me-1"></i> Perfil
                    </a>
                </div>
            </div>
            
            <!-- Gestión de datos -->
            <div class="col-md-2">
                <h6 class="text-light mb-3">Datos Fiscales</h6>
                <div class="footer-links">
                    <a href="/registrar-datos-fiscales" class="text-light d-block mb-2">
                        <i class="fas fa-plus-circle me-1"></i> Registrar Datos
                    </a>
                    <a href="/editar-datos-fiscales" class="text-light d-block mb-2">
                        <i class="fas fa-edit me-1"></i> Editar Datos
                    </a>
                    <a href="/informacion-personal" class="text-light d-block mb-2">
                        <i class="fas fa-list me-1"></i> Ver Todos
                    </a>
                </div>
            </div>
            
            <!-- Herramientas -->
            <div class="col-md-2">
                <h6 class="text-light mb-3">Herramientas</h6>
                <div class="footer-links">
                    <a href="/generar-ticket" class="text-light d-block mb-2">
                        <i class="fas fa-plus me-1"></i> Nuevo Ticket
                    </a>
                    <a href="/lector-qr" class="text-light d-block mb-2">
                        <i class="fas fa-qrcode me-1"></i> Lector QR
                    </a>
                    <a href="/visualizar-ticket" class="text-light d-block mb-2">
                        <i class="fas fa-eye me-1"></i> Ver Ticket
                    </a>
                </div>
            </div>
            
            <!-- Soporte y ayuda -->
            <div class="col-md-2">
                <h6 class="text-light mb-3">Soporte</h6>
                <div class="footer-links">
                    <a href="#" onclick="mostrarAyuda()" class="text-light d-block mb-2">
                        <i class="fas fa-question-circle me-1"></i> Ayuda
                    </a>
                    <a href="#" onclick="mostrarContacto()" class="text-light d-block mb-2">
                        <i class="fas fa-envelope me-1"></i> Contacto
                    </a>
                    <a href="#" onclick="mostrarFAQ()" class="text-light d-block mb-2">
                        <i class="fas fa-info-circle me-1"></i> FAQ
                    </a>
                    <a href="funciones/logout.php" class="text-light d-block mb-2">
                        <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Línea separadora -->
        <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
        
        <!-- Información adicional -->
        <div class="row">
            <div class="col-md-6">
                <p class="text-muted small mb-0">
                    <i class="fas fa-shield-alt me-1"></i>
                    Tus datos están protegidos con encriptación SSL
                </p>
            </div>
            <div class="col-md-6 text-end">
                <p class="text-muted small mb-0">
                    <i class="fas fa-clock me-1"></i>
                    Última actualización: <?php echo date('d/m/Y H:i'); ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Modal de Ayuda -->
<div class="modal fade" id="modalAyuda" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-question-circle me-2"></i>Centro de Ayuda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-ticket-alt me-2"></i>Gestión de Tickets</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-arrow-right me-1"></i>Crear tickets de facturación</li>
                            <li><i class="fas fa-arrow-right me-1"></i>Ver historial de tickets</li>
                            <li><i class="fas fa-arrow-right me-1"></i>Descargar facturas</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-user me-2"></i>Datos Fiscales</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-arrow-right me-1"></i>Registrar datos fiscales</li>
                            <li><i class="fas fa-arrow-right me-1"></i>Editar información</li>
                            <li><i class="fas fa-arrow-right me-1"></i>Gestionar múltiples perfiles</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Contacto -->
<div class="modal fade" id="modalContacto" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-envelope me-2"></i>Contacto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><i class="fas fa-envelope me-2"></i><strong>Email:</strong> soporte@factyflow.com</p>
                <p><i class="fas fa-phone me-2"></i><strong>Teléfono:</strong> +52 (55) 1234-5678</p>
                <p><i class="fas fa-clock me-2"></i><strong>Horario:</strong> Lunes a Viernes 9:00 - 18:00</p>
                <p><i class="fas fa-map-marker-alt me-2"></i><strong>Ubicación:</strong> Ciudad de México, México</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de FAQ -->
<div class="modal fade" id="modalFAQ" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>Preguntas Frecuentes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                ¿Cómo crear un ticket de facturación?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ve a "Generar Ticket" en el menú principal, completa los datos requeridos y sube la imagen del ticket.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                ¿Cómo registrar mis datos fiscales?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Accede a "Registrar Datos Fiscales" y completa todos los campos con tu información fiscal.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                ¿Cuánto tiempo tarda la facturación?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                El proceso de facturación tarda entre 24-48 horas hábiles una vez que se suben los archivos.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarAyuda() {
    new bootstrap.Modal(document.getElementById('modalAyuda')).show();
}

function mostrarContacto() {
    new bootstrap.Modal(document.getElementById('modalContacto')).show();
}

function mostrarFAQ() {
    new bootstrap.Modal(document.getElementById('modalFAQ')).show();
}
</script>


