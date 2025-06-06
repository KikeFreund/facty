<?php
 require('assets/php/conexiones/conexionMySqli.php');
// Aquí irían las consultas a la base de datos
$query_regimenes = ""; // SELECT * FROM regimenes_fiscales
$query_usos_cfdi = "SELECT * FROM usosCfdi"; // SELECT * FROM usos_cfdi
$result_usos_cfdi = $conn->query($query_usos_cfdi);
$id_usuario=$_SESSION['id_usuario'];
$query_datos_fiscales = "SELECT * FROM datosFiscales WHERE id_usuario = '$id_usuario'"; // SELECT * FROM datos_fiscales WHERE id_usuario = ?
$result_datos_fiscales =  $conn->query($query_datos_fiscales);
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

                            <!-- Imagen del Ticket -->
                            <div class="mb-4">
                                <label for="imagen_ticket" class="form-label">Imagen del Ticket</label>
                                <input type="file" 
                                       class="form-control" 
                                       id="imagen_ticket" 
                                       name="imagen_ticket" 
                                       accept=".jpg,.jpeg,.png"
                                       onchange="previewImage(this)">
                                <div class="invalid-feedback">
                                    Por favor selecciona una imagen válida
                                </div>
                                <small class="form-text text-muted">
                                    Formatos aceptados: JPG, JPEG, PNG. Tamaño máximo: 5MB
                                </small>
                                <!-- Vista previa de la imagen -->
                                <div id="preview_container" class="mt-2" style="display: none;">
                                    <img id="preview_image" class="img-thumbnail" style="max-height: 200px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeImage()">
                                        <i class="bi bi-trash"></i> Eliminar imagen
                                    </button>
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
                                        while($uso = $result_usos_cfdi->fetch_assoc()) {
                                            echo "<option value='{$uso['clave']}'>{$uso['clave']} - {$uso['descripcion']}</option>";
                                        }
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
                                    <div id="vista_previa_content">
                                        <!-- El contenido se actualizará dinámicamente -->
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
        const vistaPrevia = document.getElementById('vista_previa');
        const vistaPreviaContent = document.getElementById('vista_previa_content');
        
        if (!id) {
            vistaPrevia.style.display = 'none';
            return;
        }

        // Mostrar indicador de carga
        vistaPrevia.style.display = 'block';
        vistaPreviaContent.innerHTML = '<div class="text-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';

        // Llamada AJAX para obtener los datos fiscales
        fetch(`../funciones/obtener_datos_fiscales.php?id=${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }

                console.log('Datos recibidos:', data); // Debug

                // Llenar los campos ocultos
                document.getElementById('rfc').value = data.rfc || '';
                document.getElementById('razon_social').value = data.razon_social || '';
                document.getElementById('regimen_fiscal').value = data.regimen_fiscal || '';
                document.getElementById('correo').value = data.correo || '';
                document.getElementById('calle').value = data.calle || '';
                document.getElementById('cp').value = data.cp || '';
                document.getElementById('colonia').value = data.colonia || '';
                document.getElementById('municipio').value = data.municipio || '';
                document.getElementById('estado').value = data.estado || '';
                document.getElementById('telefono').value = data.telefono || '';

                // Construir la dirección solo si tenemos los datos necesarios
                const direccion = [
                    data.calle,
                    data.colonia,
                    data.municipio,
                    data.estado,
                    data.cp ? `CP ${data.cp}` : ''
                ].filter(Boolean).join(', ');

                // Actualizar la vista previa
                vistaPreviaContent.innerHTML = `
                    <div class="card-body">
                        <h6 class="card-title">Datos Fiscales Seleccionados</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>RFC:</strong> ${data.rfc || 'No disponible'}</p>
                                <p class="mb-1"><strong>Razón Social:</strong> ${data.razon_social || 'No disponible'}</p>
                                <p class="mb-1"><strong>Régimen Fiscal:</strong> ${data.regimen_fiscal || 'No disponible'}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Correo:</strong> ${data.correo || 'No disponible'}</p>
                                <p class="mb-1"><strong>Teléfono:</strong> ${data.telefono || 'No disponible'}</p>
                                <p class="mb-1"><strong>Dirección:</strong> ${direccion || 'No disponible'}</p>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error al cargar los datos fiscales:', error);
                vistaPreviaContent.innerHTML = `
                    <div class="card-body">
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-exclamation-triangle"></i> Error al cargar los datos fiscales: ${error.message}
                        </div>
                    </div>
                `;
            });
    }

    // Validación del monto
    document.getElementById('monto').addEventListener('input', function(e) {
        if (this.value < 0) {
            this.value = 0;
        }
    });

    // Función para previsualizar la imagen
    function previewImage(input) {
        const previewContainer = document.getElementById('preview_container');
        const previewImage = document.getElementById('preview_image');
        const file = input.files[0];

        // Validar el tipo de archivo
        if (file) {
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                alert('Por favor selecciona una imagen en formato JPG, JPEG o PNG');
                input.value = '';
                previewContainer.style.display = 'none';
                return;
            }

            // Validar el tamaño (5MB máximo)
            if (file.size > 5 * 1024 * 1024) {
                alert('La imagen no debe superar los 5MB');
                input.value = '';
                previewContainer.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    }

    // Función para eliminar la imagen
    function removeImage() {
        const input = document.getElementById('imagen_ticket');
        const previewContainer = document.getElementById('preview_container');
        input.value = '';
        previewContainer.style.display = 'none';
    }
    </script>
</body>
