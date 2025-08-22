<?php
/**
 * Ejemplo de integración de contactos frecuentes simplificados en la generación de tickets
 * Este archivo muestra cómo usar la funcionalidad de contactos frecuentes con estructura simplificada
 */

require_once('../funciones/buscar_contacto_frecuente.php');

// Ejemplo de función para generar ticket con búsqueda automática de contacto
function generarTicketConContactoFrecuente($datos_ticket) {
    
    // 1. Buscar si existe un contacto frecuente con ese teléfono
    $contacto_encontrado = null;
    if (!empty($datos_ticket['telefono_empresa'])) {
        $contacto_encontrado = buscarContactoFrecuente($datos_ticket['telefono_empresa']);
    }
    
    // 2. Preparar los datos del ticket
    $datos_finales = [];
    
    if ($contacto_encontrado) {
        // Usar datos del contacto frecuente (estructura simplificada)
        $datos_finales = [
            'nombre_empresa' => $contacto_encontrado['nombre_empresa'],
            'telefono' => $contacto_encontrado['telefono'],
            'categoria' => $contacto_encontrado['categoria'],
            'notas' => $contacto_encontrado['notas'],
            'fuente_datos' => 'contacto_frecuente',
            'id_contacto' => $contacto_encontrado['id']
        ];
        
        // Agregar nota sobre el origen de los datos
        $datos_finales['nota_origen'] = "Datos obtenidos de contacto frecuente: {$contacto_encontrado['nombre_empresa']}";
        
    } else {
        // Usar datos proporcionados por el cliente
        $datos_finales = [
            'nombre_empresa' => $datos_ticket['nombre_empresa'] ?? 'No especificado',
            'telefono' => $datos_ticket['telefono_empresa'] ?? '',
            'categoria' => $datos_ticket['categoria'] ?? 'General',
            'notas' => $datos_ticket['notas'] ?? '',
            'fuente_datos' => 'cliente',
            'id_contacto' => null
        ];
        
        // Opción para sugerir agregar como contacto frecuente
        if (!empty($datos_ticket['telefono_empresa']) && !empty($datos_ticket['nombre_empresa'])) {
            $datos_finales['sugerir_contacto'] = true;
        }
    }
    
    // 3. Agregar datos del ticket
    $datos_finales['monto'] = $datos_ticket['monto'];
    $datos_finales['descripcion'] = $datos_ticket['descripcion'];
    $datos_finales['metodo_pago'] = $datos_ticket['metodo_pago'];
    $datos_finales['uso_cfdi'] = $datos_ticket['uso_cfdi'];
    
    return $datos_finales;
}

// Ejemplo de uso en un formulario de generación de ticket
function mostrarFormularioTicket() {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Generar Ticket - Con Contactos Frecuentes Simplificados</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container py-5">
            <h2 class="text-center mb-4">Generar Nuevo Ticket</h2>
            
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form id="formTicket" method="POST">
                                
                                <!-- Campo de teléfono con búsqueda automática -->
                                <div class="mb-3">
                                    <label for="telefono_empresa" class="form-label">
                                        <i class="bi bi-telephone me-2"></i>Teléfono de la empresa
                                    </label>
                                    <div class="input-group">
                                        <input type="tel" 
                                               class="form-control" 
                                               id="telefono_empresa" 
                                               name="telefono_empresa" 
                                               placeholder="555-123-4567"
                                               onblur="buscarContactoFrecuente(this.value)">
                                        <button class="btn btn-outline-secondary" 
                                                type="button"
                                                onclick="buscarContactoFrecuente(document.getElementById('telefono_empresa').value)">
                                            <i class="bi bi-search"></i> Buscar
                                        </button>
                                    </div>
                                    <small class="text-muted">Ingresa el teléfono para buscar contactos frecuentes</small>
                                </div>
                                
                                <!-- Resultado de búsqueda de contacto -->
                                <div id="resultadoBusqueda" class="mb-3" style="display: none;">
                                    <div class="alert alert-info">
                                        <h6><i class="bi bi-check-circle me-2"></i>Contacto encontrado</h6>
                                        <div id="datosContacto"></div>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="usarDatosContacto()">
                                            <i class="bi bi-check me-2"></i>Usar estos datos
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Campos del ticket -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nombre_empresa" class="form-label">Nombre de la empresa</label>
                                            <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="monto" class="form-label">Monto</label>
                                            <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="metodo_pago" class="form-label">Método de pago</label>
                                            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="1">Efectivo</option>
                                                <option value="2">Tarjeta de crédito</option>
                                                <option value="3">Tarjeta de débito</option>
                                                <option value="4">Transferencia</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="uso_cfdi" class="form-label">Uso de CFDI</label>
                                            <select class="form-select" id="uso_cfdi" name="uso_cfdi" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="G01">G01 - Adquisición de mercancías</option>
                                                <option value="G02">G02 - Devoluciones, descuentos o bonificaciones</option>
                                                <option value="G03">G03 - Gastos en general</option>
                                                <option value="I01">I01 - Construcciones</option>
                                                <option value="I02">I02 - Mobiliario y equipo de oficina por inversiones</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Opción para agregar como contacto frecuente -->
                                <div id="opcionContactoFrecuente" class="mb-3" style="display: none;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agregar_contacto" name="agregar_contacto">
                                        <label class="form-check-label" for="agregar_contacto">
                                            <i class="bi bi-star me-2"></i>Agregar como contacto frecuente
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Generar Ticket
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        // Variable global para almacenar el contacto encontrado
        let contactoEncontrado = null;
        
        // Función para buscar contacto frecuente
        function buscarContactoFrecuente(telefono) {
            if (!telefono) return;
            
            // Aquí harías una llamada AJAX a tu backend
            // Por ahora simulamos la respuesta
            fetch(`../funciones/buscar_contacto_frecuente.php?telefono=${encodeURIComponent(telefono)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.contacto) {
                        mostrarContactoEncontrado(data.contacto);
                    } else {
                        ocultarContactoEncontrado();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    ocultarContactoEncontrado();
                });
        }
        
        // Función para mostrar el contacto encontrado (estructura simplificada)
        function mostrarContactoEncontrado(contacto) {
            contactoEncontrado = contacto;
            
            document.getElementById('datosContacto').innerHTML = `
                <strong>${contacto.nombre_empresa}</strong><br>
                <small class="text-muted">
                    ${contacto.telefono} • ${contacto.categoria || 'Sin categoría'}<br>
                    ${contacto.notas ? `📝 ${contacto.notas}` : ''}
                </small>
            `;
            
            document.getElementById('resultadoBusqueda').style.display = 'block';
        }
        
        // Función para ocultar el contacto encontrado
        function ocultarContactoEncontrado() {
            contactoEncontrado = null;
            document.getElementById('resultadoBusqueda').style.display = 'none';
        }
        
        // Función para usar los datos del contacto
        function usarDatosContacto() {
            if (!contactoEncontrado) return;
            
            // Llenar automáticamente los campos
            document.getElementById('nombre_empresa').value = contactoEncontrado.nombre_empresa;
            
            // Mostrar opción para agregar como contacto frecuente
            document.getElementById('opcionContactoFrecuente').style.display = 'block';
            
            // Marcar checkbox como marcado
            document.getElementById('agregar_contacto').checked = true;
            
            // Ocultar resultado de búsqueda
            document.getElementById('resultadoBusqueda').style.display = 'none';
        }
        
        // Manejar envío del formulario
        document.getElementById('formTicket').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Aquí procesarías el formulario
            const formData = new FormData(this);
            
            // Si se encontró un contacto, agregar información adicional
            if (contactoEncontrado) {
                formData.append('id_contacto', contactoEncontrado.id);
                formData.append('fuente_datos', 'contacto_frecuente');
            }
            
            // Enviar datos al backend
            console.log('Datos del ticket:', Object.fromEntries(formData));
            
            // Aquí harías el envío real al backend
            alert('Ticket generado exitosamente');
        });
        </script>
    </body>
    </html>
    <?php
}

// Ejecutar el ejemplo si se accede directamente
if (basename(__FILE__) == basename($_SERVER['SCRIPT_NAME'])) {
    mostrarFormularioTicket();
}
?>
