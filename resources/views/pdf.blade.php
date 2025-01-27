<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hoja de Mediciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }
    .container-pdf {
      max-width: 794px;
      margin: auto;
      background-color: #fff;
      padding: 20px;
      border: 1px solid #ddd;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .page {
      page-break-after: always;
      padding: 20px;
    }
    .header, .footer {
      text-align: center;
      font-size: 0.9rem;
      color: #6c757d;
    }
    .header {
      margin-bottom: 20px;
    }
    .footer {
      margin-top: 20px;
    }
    .header-logo {
      max-width: 250px;
      height: auto;
      float: right;
    }
    .header-content {
      font-size: 1rem;
      text-align: left;
    }
    .header-content h1 {
      font-size: 1.5rem;
      margin: 0;
    }
    .header-content p {
      margin: 0;
    }
    .table {
      margin-top: 20px;
      width: 100%;
      border-collapse: collapse;
    }
    .table colgroup col:first-child {
      width: 33.33%;
    }
    .table colgroup col:last-child {
      width: 66.67%;
    }
    .table th, .table td {
      padding: 8px;
      text-align: left;
    }
    .table th {
      background-color: #f8f9fa;
      font-weight: bold;
    }
    .table tr {
      border-bottom: 1px solid #ddd;
    }
    .image-container {
      position: relative;
      margin-top: 20px;
    }
    .image-container img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }
    .photo-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .photo-grid img {
      width: 100%;
      height: calc((794px - 60px) / 2);
      object-fit: cover;
      border: 1px solid #ddd;
    }
    .signature-container {
      text-align: center;
      margin-top: 20px;
    }
    .signature-container img {
      width: 150px;
      height: 50px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    @media print {
      .container-pdf {
        border: none;
        box-shadow: none;
      }
      .page {
        page-break-after: always;
      }
      .header, .footer {
        position: fixed;
        width: 100%;
        left: 0;
        color: #6c757d;
      }
      .header {
        top: 0;
      }
      .footer {
        bottom: 0;
      }
    }

    .measurement {
      position: absolute;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 5px 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 0.9rem;
      font-weight: bold;
      color: #000;
    }
    .measurement-top-left {
      top: 23px;
      left: 90px;
    }
    .measurement-top-right {
      top: 23px;
      right: 90px;
    }
    .measurement-side-left {
      top: 51%;
      left: -20px;
      transform: translateY(-50%);
    }
    .measurement-side-right {
      top: 51%;
      right: -20px;
      transform: translateY(-50%);
    }
    .measurement-bottom-center {
      bottom: 15px;
      left: 50%;
      transform: translateX(-50%);
    }

  </style>
</head>
<body>
  <div class="container container-pdf">
    <!-- Página 1 -->
    <div class="page">
      <div class="row mb-4 align-items-center">
        <div class="col-6 header-content">
          <h1>Hoja de Mediciones</h1>
          <p>Portales de Galicia Automáticos, S.L.</p>
          <p>Pol. Ind. Bergondo, Parc. A2-A3-A4-N9</p>
        </div>
        <div class="col-6">
          <img src="/logo.png" alt="Logo Portagal" class="header-logo">
        </div>
      </div>
      <h2 class="mt-5">Puerta</h2>
      <table class="table">
        <colgroup>
          <col>
          <col>
        </colgroup>
        <tbody>
          <tr>
            <td>Referencia</td>
            <td>{{ $record->referencia }}</td>
          </tr>
          <tr>
            <td>Tipo de puerta</td>
            <td>{{ $record->puertas->nombre }}</td>
          </tr>
          <tr>
            <td>Fecha de medición</td>
            <td>{{ $record->created_at }}</td>
          </tr>
          <tr>
            <td>Técnico</td>
            <td>Carlos García</td>
          </tr>
        </tbody>
      </table>
      <h2 class="mt-5">Cliente</h2>
      <table class="table">
        <colgroup>
          <col>
          <col>
        </colgroup>
        <tbody>
          <tr>
            <td>Nombre</td>
            <td>{{ $record->nombre_cliente }}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>{{ $record->email }}</td>
          </tr>
          <tr>
            <td>Dirección</td>
            <td>Calle Principal 123, Ciudad</td>
          </tr>
          <tr>
            <td>Coordenadas</td>
            <td>40.7128,74.0060</td>
          </tr>
        </tbody>
      </table>
      <div class="signature-container mt-5">
        <p class="mb-2">Firma</p>
        <img src="https://placehold.co/150x50" alt="Firma">
      </div>
      <div class="footer">Pag. 1</div>
    </div>

    <!-- Página 2 -->
    <div class="page">
      <h2>Mediciones</h2>
      <div class="image-container">
        <img src="/corredera.jpg" alt="Puerta Corredera">
        <div class="measurement measurement-top-left">200cm</div>
        <div class="measurement measurement-top-right">210cm</div>
        <div class="measurement measurement-side-left">190cm</div>
        <div class="measurement measurement-side-right">185cm</div>
        <div class="measurement measurement-bottom-center">350cm</div>
      </div>
      <h3>Medidas</h3>
      <table class="table">
        <colgroup>
          <col>
          <col>
        </colgroup>
        <tbody>
          <tr>
            <td>Dirección de apertura</td>
            <td>Izquierda</td>
          </tr>
          <tr>
            <td>Solape lado motor</td>
            <td>15cm</td>
          </tr>
          <tr>
            <td>Solape lado que cierra</td>
            <td>10cm</td>
          </tr>
          <tr>
            <td>Puerta corre por el exterior</td>
            <td>Sí</td>
          </tr>
          <tr>
            <td>Medida rabo superior</td>
            <td>12cm</td>
          </tr>
          <tr>
            <td>Medida rabo inferior</td>
            <td>10cm</td>
          </tr>
          <tr>
            <td>Caída de la puerta</td>
            <td>2cm</td>
          </tr>
        </tbody>
      </table>
      <h3>Cortes (Faltan)</h3>
      <table class="table">
        <colgroup>
          <col>
          <col>
        </colgroup>
        <tbody>
          <tr>
            <td>Dirección de apertura</td>
            <td>Izquierda</td>
          </tr>
          <tr>
            <td>Solape lado motor</td>
            <td>15cm</td>
          </tr>
          <tr>
            <td>Solape lado que cierra</td>
            <td>10cm</td>
          </tr>
          <tr>
            <td>Puerta corre por el exterior</td>
            <td>Sí</td>
          </tr>
          <tr>
            <td>Medida rabo superior</td>
            <td>12cm</td>
          </tr>
          <tr>
            <td>Medida rabo inferior</td>
            <td>10cm</td>
          </tr>
        </tbody>
      </table>
      <h3>Tipo de cierre</h3>
      Añadir dibujo que corresponda
      <div class="footer">© 2025 Portagal</div>
    </div>

    <!-- Página 3 -->
    <div class="page">
      <h2>Accesorios y opciones</h2>
      <h3>Peatonal insertada</h3>
      <table class="table">
        <colgroup>
          <col>
          <col>
        </colgroup>
        <tbody>
          <tr>
            <td>Seguridad</td>
            <td>Alta</td>
          </tr>
          <tr>
            <td>Apertura</td>
            <td>Automática</td>
          </tr>
          <tr>
            <td>Posición</td>
            <td>Central</td>
          </tr>
          <tr>
            <td>Cerradura</td>
            <td>Magnética</td>
          </tr>
        </tbody>
      </table>
      <h3>Opciones</h3>
      <table class="table">
        <colgroup>
          <col>
          <col>
        </colgroup>
        <tbody>
          <tr>
            <td>Orientación</td>
            <td>Horizontal</td>
          </tr>
          <tr>
            <td>Buzón</td>
            <td>No</td>
          </tr>
          <tr>
            <td>Bate contra U</td>
            <td>Sí</td>
          </tr>
        </tbody>
      </table>
      <h3>Apertura</h3>
      <table class="table">
        <colgroup>
          <col>
          <col>
        </colgroup>
        <tbody>
          <tr>
            <td>Funcionamiento</td>
            <td>Eléctrico</td>
          </tr>
          <tr>
            <td>Motor</td>
            <td>Incluido</td>
          </tr>
          <tr>
            <td>Tipo de Motor</td>
            <td>Deslizante</td>
          </tr>
          <tr>
            <td>Modelo de Motor</td>
            <td>Motor-X1</td>
          </tr>
        </tbody>
      </table>
      <h3>Accesorios</h3>
      <table class="table">
        <colgroup>
          <col>
          <col>
        </colgroup>
        <tbody>
          <tr>
            <td>Mandos</td>
            <td>2 unidades</td>
          </tr>
          <tr>
            <td>Fotocélulas</td>
            <td>Incluidas</td>
          </tr>
          <tr>
            <td>Antena Exterior</td>
            <td>Incluida</td>
          </tr>
          <tr>
            <td>Led</td>
            <td>No</td>
          </tr>
          <tr>
            <td>Teclado Inalámbrico</td>
            <td>Sí</td>
          </tr>
        </tbody>
      </table>
      <div class="footer">© 2025 Portagal</div>
    </div>

    <!-- Página 4 -->
    <div class="page">
      <h2>Obra y montaje</h2>
      <table class="table">
        <colgroup>
          <col>
          <col>
        </colgroup>
        <tbody>
          <tr>
            <td>Electricidad</td>
            <td>Instalación de cables y conectores. Instalación de cables y conectores. Instalación de cables y conectores. Instalación de cables y conectores.</td>
          </tr>
          <tr>
            <td>Albañilería</td>
            <td>Reparaciones y ajustes del marco.Reparaciones y ajustes del marco. Reparaciones y ajustes del marco.</td>
          </tr>
          <tr>
            <td>Material de los pilares</td>
            <td>Acero galvanizado</td>
          </tr>
          <tr>
            <td>Materiales suelo</td>
            <td>Cemento antideslizante</td>
          </tr>
        </tbody>
      </table>
      <div class="row mt-4">
        <div class="col-12">
          <p class="text-center mt-2">Montaje de Guías</p>
          <img src="https://placehold.co/750x300" alt="Montaje de Guías" class="img-fluid">
        </div>
        <div class="col-12">
          <p class="text-center mt-2">Remates</p>
          <img src="https://placehold.co/750x300" alt="Remates" class="img-fluid">
        </div>
        <div class="col-12">
          <p class="text-center mt-2">Pórtico</p>
          <img src="https://placehold.co/750x300" alt="Pórtico" class="img-fluid">
        </div>
      </div>
      <div class="footer">© 2025 Portagal</div>
    </div>

    <!-- Página 5 -->
    <div class="page">
      <h2>Fotografías</h2>
      <div class="photo-grid">
        <img src="https://placehold.co/794x600" alt="Fotografía 1">
        <img src="https://placehold.co/794x600" alt="Fotografía 2">
        <img src="https://placehold.co/794x600" alt="Fotografía 3">
        <img src="https://placehold.co/794x600" alt="Fotografía 4">
      </div>
      <div class="footer">© 2025 Portagal</div>
    </div>
  </div>
</body>
</html>
