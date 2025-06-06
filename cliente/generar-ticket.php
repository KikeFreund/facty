<?php
// Aquí irían las consultas a la base de datos
$query_regimenes = ""; // SELECT * FROM regimenes_fiscales
$query_usos_cfdi = ""; // SELECT * FROM usos_cfdi
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Ticket de Facturación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Generar Ticket de Facturación</h3>
                    </div>
                    <div class="card-body">
                        <form action="procesar-ticket.php" method="POST" class="needs-validation" novalidate>
                            <!-- Monto -->
                            <div class="mb-4">
                                <label for="monto" class="form-label">Monto a Facturar</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           class="form-control" 
                                           id="monto" 
                                           name="monto" 
                                           step="0.01" 
                                           min="0" 
                                           required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa un monto válido
                                    </div>
                                </div>
                            </div>

                            <!-- Datos Fiscales -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">Datos Fiscales</h5>
                                
                                <!-- Régimen Fiscal -->
                                <div class="mb-3">
                                    <label for="regimen_fiscal" class="form-label">Régimen Fiscal</label>
                                    <select class="form-select" id="regimen_fiscal" name="regimen_fiscal" required>
                                        <option value="">Selecciona un régimen fiscal</option>
                                        <?php
                                        // Aquí iría el while para los regímenes fiscales
                                        // while($regimen = $result_regimenes->fetch_assoc()) {
                                        //     echo "<option value='{$regimen['id']}'>{$regimen['descripcion']}</option>";
                                        // }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor selecciona un régimen fiscal
                                    </div>
                                </div>

                                <!-- RFC -->
                                <div class="mb-3">
                                    <label for="rfc" class="form-label">RFC</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="rfc" 
                                           name="rfc" 
                                           pattern="^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$"
                                           required>
                                    <div class="invalid-feedback">
                                        Ingresa un RFC válido
                                    </div>
                                </div>

                                <!-- Uso de CFDI -->
                                <div class="mb-3">
                                    <label for="uso_cfdi" class="form-label">Uso de CFDI</label>
                                    <select class="form-select" id="uso_cfdi" name="uso_cfdi" required>
                                        <option value="">Selecciona un uso de CFDI</option>
                                        <?php
                                        // Aquí iría el while para los usos de CFDI
                                        // while($uso = $result_usos_cfdi->fetch_assoc()) {
                                        //     echo "<option value='{$uso['clave']}'>{$uso['clave']} - {$uso['descripcion']}</option>";
                                        // }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor selecciona un uso de CFDI
                                    </div>
                                </div>

                                <!-- Nombre o Razón Social -->
                                <div class="mb-3">
                                    <label for="razon_social" class="form-label">Nombre o Razón Social</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="razon_social" 
                                           name="razon_social" 
                                           required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa el nombre o razón social
                                    </div>
                                </div>

                                <!-- Correo Electrónico -->
                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="correo" 
                                           name="correo" 
                                           required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa un correo electrónico válido
                                    </div>
                                </div>
                            </div>

                            <!-- Dirección Fiscal -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">Dirección Fiscal</h5>
                                
                                <div class="row g-3">
                                    <!-- Calle y Número -->
                                    <div class="col-md-8">
                                        <label for="calle" class="form-label">Calle y Número</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="calle" 
                                               name="calle" 
                                               required>
                                        <div class="invalid-feedback">
                                            Por favor ingresa la calle y número
                                        </div>
                                    </div>

                                    <!-- Código Postal -->
                                    <div class="col-md-4">
                                        <label for="cp" class="form-label">Código Postal</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="cp" 
                                               name="cp" 
                                               pattern="[0-9]{5}"
                                               required>
                                        <div class="invalid-feedback">
                                            Ingresa un código postal válido
                                        </div>
                                    </div>

                                    <!-- Colonia -->
                                    <div class="col-md-6">
                                        <label for="colonia" class="form-label">Colonia</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="colonia" 
                                               name="colonia" 
                                               required>
                                        <div class="invalid-feedback">
                                            Por favor ingresa la colonia
                                        </div>
                                    </div>

                                    <!-- Municipio/Alcaldía -->
                                    <div class="col-md-6">
                                        <label for="municipio" class="form-label">Municipio/Alcaldía</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="municipio" 
                                               name="municipio" 
                                               required>
                                        <div class="invalid-feedback">
                                            Por favor ingresa el municipio o alcaldía
                                        </div>
                                    </div>

                                    <!-- Estado -->
                                    <div class="col-md-6">
                                        <label for="estado" class="form-label">Estado</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="estado" 
                                               name="estado" 
                                               required>
                                        <div class="invalid-feedback">
                                            Por favor ingresa el estado
                                        </div>
                                    </div>

                                    <!-- Teléfono -->
                                    <div class="col-md-6">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" 
                                               class="form-control" 
                                               id="telefono" 
                                               name="telefono" 
                                               required>
                                        <div class="invalid-feedback">
                                            Por favor ingresa un teléfono válido
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Limpiar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Generar Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Validación del formulario
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()

    // Validación del RFC
    document.getElementById('rfc').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });

    // Validación del código postal
    document.getElementById('cp').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 5);
    });
    </script>
</body>
</html>