<form action="funciones/subir_factura.php" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-white shadow-sm">
  <h4 class="mb-4">Subir factura (PDF + XML)</h4>

  <div class="mb-3">
    <label for="nombre_archivo" class="form-label">Nombre del archivo</label>
    <input type="text" class="form-control" id="nombre_archivo" name="nombre_archivo" placeholder="Ej. factura_abril_001" required>
  </div>

  <div class="mb-3">
    <label for="ticket_id" class="form-label">ID del Ticket</label>
    <input type="text" class="form-control" id="ticket_id" name="ticket_id" placeholder="Ej. 12345" required>
  </div>

  <div class="mb-3">
    <label for="archivo_pdf" class="form-label">Archivo PDF de la factura</label>
    <input class="form-control" type="file" id="archivo_pdf" name="archivo_pdf" accept=".pdf" required>
  </div>

  <div class="mb-3">
    <label for="archivo_xml" class="form-label">Archivo XML de la factura</label>
    <input class="form-control" type="file" id="archivo_xml" name="archivo_xml" accept=".xml" required>
  </div>

  <button type="submit" class="btn btn-primary">Subir archivos</button>
</form>
