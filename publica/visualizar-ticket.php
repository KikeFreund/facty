<?php
$id_ticket = $_GET['id'] ?? null;
if (!$id_ticket) die("Falta el ID.");

$archivoQR = "https://movilistica.com/archivos/qrs/qr_$id_ticket.png";
$urlFactura = "https://tupagina.com/facturacion?id=$id_ticket";
$urlQR = "https://movilistica.com/$archivoQR";

$mensaje = "Aquí tienes los datos para la factura solicitada:\n\nVer factura: $urlFactura\nCódigo QR: $urlQR";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>QR Factura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0 text-center">Datos para Facturación</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 text-center mb-3">
                                <img src="<?= $archivoQR ?>" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                            <div class="col-md-6">
                                <div class="d-grid gap-2">
                                    <button onclick="copiarTodo()" class="btn btn-outline-primary">
                                        <i class="bi bi-clipboard"></i> Copiar Todos los Datos
                                    </button>
                                    <button onclick="enviarWhatsApp()" class="btn btn-success">
                                        <i class="bi bi-whatsapp"></i> Enviar por WhatsApp
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Datos Fiscales -->
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">Datos Fiscales</h5>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ID de Ticket</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)"><?= htmlspecialchars($id_ticket) ?></p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Régimen Fiscal</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">Persona Física con actividades empresariales y/o profesionales</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">RFC</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">ABC123456XYZ</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Uso de CFDI</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">G01 - Adquisición de mercancías</p>
                            </div>

                            <!-- Datos de Contacto -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2">Datos de Contacto</h5>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nombre o Razón Social</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">Juan Pérez García</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Correo Electrónico</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">correo@ejemplo.com</p>
                            </div>

                            <!-- Dirección Fiscal -->
                            <div class="col-12 mt-4">
                                <h5 class="border-bottom pb-2">Dirección Fiscal</h5>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Calle y Número</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">Av. Reforma 123</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Colonia</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">Centro</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Código Postal</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">06000</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Municipio/Alcaldía</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">Cuauhtémoc</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">Ciudad de México</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">País</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">México</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <p class="copiable form-control" onclick="copiarTexto(this)">5555555555</p>
                            </div>
                        </div>

                        <!-- WhatsApp Input -->
                        <div class="mt-4">
                            <label for="telefono" class="form-label">Enviar por WhatsApp (con código de país)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                <input type="tel" class="form-control" id="telefono" placeholder="Ej. 5215555555555">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .copiable {
        cursor: pointer;
        user-select: all;
        transition: all 0.2s ease;
        background-color: #f8f9fa;
        margin-bottom: 0;
        padding: 0.375rem 0.75rem;
    }
    .copiable:hover {
        background-color: #e9ecef;
    }
    .card {
        border-radius: 15px;
    }
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
    </style>

    <script>
    function copiarTexto(elemento) {
        const texto = elemento.innerText;
        navigator.clipboard.writeText(texto).then(() => {
            const original = elemento.innerText;
            elemento.innerText = '✅ Copiado';
            elemento.style.backgroundColor = '#d4edda';
            setTimeout(() => {
                elemento.innerText = original;
                elemento.style.backgroundColor = '#f8f9fa';
            }, 1500);
        }).catch(err => {
            alert("No se pudo copiar");
            console.error(err);
        });
    }

    function copiarTodo() {
        const datos = {
            'ID de Ticket': '<?= htmlspecialchars($id_ticket) ?>',
            'Régimen Fiscal': 'Persona Física con actividades empresariales y/o profesionales',
            'RFC': 'ABC123456XYZ',
            'Uso de CFDI': 'G01 - Adquisición de mercancías',
            'Nombre o Razón Social': 'Juan Pérez García',
            'Correo Electrónico': 'correo@ejemplo.com',
            'Calle y Número': 'Av. Reforma 123',
            'Colonia': 'Centro',
            'Código Postal': '06000',
            'Municipio/Alcaldía': 'Cuauhtémoc',
            'Estado': 'Ciudad de México',
            'País': 'México',
            'Teléfono': '5555555555'
        };

        const texto = Object.entries(datos)
            .map(([key, value]) => `${key}: ${value}`)
            .join('\n');

        navigator.clipboard.writeText(texto).then(() => {
            alert('Todos los datos han sido copiados al portapapeles');
        }).catch(err => {
            alert("No se pudieron copiar los datos");
            console.error(err);
        });
    }

    function enviarWhatsApp() {
        const telefono = document.getElementById('telefono').value.trim();
        const mensaje = <?= json_encode($mensaje) ?>;
        
        if (telefono === '') {
            const url = `https://wa.me/?text=${encodeURIComponent(mensaje)}`;
            window.open(url, '_blank');
            return;
        }
        
        const url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
        window.open(url, '_blank');
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
