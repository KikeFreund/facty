<?php
// Aquí irían las consultas a la base de datos
$query_regimenes = ""; // SELECT * FROM regimenes_fiscales
$query_usos_cfdi = ""; // SELECT * FROM usos_cfdi
$id_usuario=$_SESSION['id_usuario'];
$query_datos_fiscales = "SELECT * FROM datosFiscales WHERE id_usuario = '$id_usuario'"; // SELECT * FROM datos_fiscales WHERE id_usuario = ?
$result_datos_fiscales = $query_datos_fiscales->get_result();
?>

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
                                
                                <!-- Select de Datos Fiscales -->
                                <div class="mb-3">
                                    <label for="datos_fiscales" class="form-label">Seleccionar Datos Fiscales</label>
                                    <select class="form-select" id="datos_fiscales" name="datos_fiscales" required onchange="cargarDatosFiscales(this.value)">
                                        <option value="">Selecciona tus datos fiscales</option>
                                        <?php
                                        // Aquí iría el while para los datos fiscales
                                        while($datos = $result_datos_fiscales->fetch_assoc()) {
                                            echo "<option value='{$datos['id']}'>{$datos['razonSocial']} - {$datos['rfc']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor selecciona tus datos fiscales
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

                                <!-- Campos ocultos para los datos fiscales -->
                                <input type="hidden" id="rfc" name="rfc">
                                <input type="hidden" id="razon_social" name="razon_social">
                                <input type="hidden" id="regimen_fiscal" name="regimen_fiscal">
                                <input type="hidden" id="correo" name="correo">
                                <input type="hidden" id="calle" name="calle">
                                <input type="hidden" id="cp" name="cp">
                                <input type="hidden" id="colonia" name="colonia">
                                <input type="hidden" id="municipio" name="municipio">
                                <input type="hidden" id="estado" name="estado">
                                <input type="hidden" id="telefono" name="telefono">

                                <!-- Vista previa de datos fiscales -->
                                <div id="vista_previa" class="card bg-light mb-3" style="display: none;">
                                    <div class="card-body">
                                        <h6 class="card-title">Datos Fiscales Seleccionados</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>RFC:</strong> <span id="preview_rfc"></span></p>
                                                <p class="mb-1"><strong>Razón Social:</strong> <span id="preview_razon_social"></span></p>
                                                <p class="mb-1"><strong>Régimen Fiscal:</strong> <span id="preview_regimen_fiscal"></span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Correo:</strong> <span id="preview_correo"></span></p>
                                                <p class="mb-1"><strong>Teléfono:</strong> <span id="preview_telefono"></span></p>
                                                <p class="mb-1"><strong>Dirección:</strong> <span id="preview_direccion"></span></p>
                                            </div>
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

    // Función para cargar los datos fiscales
    function cargarDatosFiscales(id) {
        if (!id) {
            document.getElementById('vista_previa').style.display = 'none';
            return;
        }

        // Aquí iría la llamada AJAX para obtener los datos fiscales
        fetch(`obtener_datos_fiscales.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                // Llenar los campos ocultos
                document.getElementById('rfc').value = data.rfc;
                document.getElementById('razon_social').value = data.razon_social;
                document.getElementById('regimen_fiscal').value = data.regimen_fiscal;
                document.getElementById('correo').value = data.correo;
                document.getElementById('calle').value = data.calle;
                document.getElementById('cp').value = data.cp;
                document.getElementById('colonia').value = data.colonia;
                document.getElementById('municipio').value = data.municipio;
                document.getElementById('estado').value = data.estado;
                document.getElementById('telefono').value = data.telefono;

                // Actualizar la vista previa
                document.getElementById('preview_rfc').textContent = data.rfc;
                document.getElementById('preview_razon_social').textContent = data.razon_social;
                document.getElementById('preview_regimen_fiscal').textContent = data.regimen_fiscal;
                document.getElementById('preview_correo').textContent = data.correo;
                document.getElementById('preview_telefono').textContent = data.telefono;
                document.getElementById('preview_direccion').textContent = 
                    `${data.calle}, ${data.colonia}, ${data.municipio}, ${data.estado}, CP ${data.cp}`;

                // Mostrar la vista previa
                document.getElementById('vista_previa').style.display = 'block';
            })
            .catch(error => {
                console.error('Error al cargar los datos fiscales:', error);
                alert('Error al cargar los datos fiscales. Por favor, intenta de nuevo.');
            });
    }
    </script>
</body>
