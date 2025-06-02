<?php 
session_start();
if(isset($_SESSION['tipoUsuario'])){
$tipoUsuario=$_SESSION['tipoUsuario'];

}
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FactyFlow</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    :root {
      --bs-primary: #667eea;
      --bs-primary-rgb: 102, 126, 234;
      --bs-primary-dark: #764ba2;
      --bs-primary-dark-rgb: 118, 75, 162;
    }

    /* Sobrescribir colores de Bootstrap */
    .btn-primary {
      background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-dark) 100%);
      border: none;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, var(--bs-primary-dark) 0%, var(--bs-primary) 100%);
      transform: translateY(-1px);
      box-shadow: 0 5px 15px rgba(var(--bs-primary-rgb), 0.4);
    }
    .btn-primary:focus {
      background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-dark) 100%);
      box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }
    .btn-primary:active {
      background: linear-gradient(135deg, var(--bs-primary-dark) 0%, var(--bs-primary) 100%);
    }

    .text-primary {
      color: var(--bs-primary) !important;
    }
    .bg-primary {
      background-color: var(--bs-primary) !important;
    }
    .border-primary {
      border-color: var(--bs-primary) !important;
    }

    /* Estilos para enlaces */
    a {
      color: var(--bs-primary);
      transition: all 0.3s ease;
    }
    a:hover {
      color: var(--bs-primary-dark);
    }

    /* Estilos para inputs */
    .form-control:focus {
      border-color: var(--bs-primary);
      box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }

    /* Estilos para cards */
    .card {
      transition: all 0.3s ease;
    }
    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(var(--bs-primary-rgb), 0.1);
    }
    .card-header {
      background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-dark) 100%);
      color: white;
    }

    /* Estilos para badges */
    .badge.bg-primary {
      background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-dark) 100%) !important;
    }

    /* Estilos para paginación */
    .page-item.active .page-link {
      background-color: var(--bs-primary);
      border-color: var(--bs-primary);
    }
    .page-link {
      color: var(--bs-primary);
    }
    .page-link:hover {
      color: var(--bs-primary-dark);
    }

    /* Estilos para alertas */
    .alert-primary {
      background-color: rgba(var(--bs-primary-rgb), 0.1);
      border-color: rgba(var(--bs-primary-rgb), 0.2);
      color: var(--bs-primary);
    }

    /* Estilos para tooltips */
    .tooltip .tooltip-inner {
      background-color: var(--bs-primary);
    }
    .tooltip.bs-tooltip-top .tooltip-arrow::before {
      border-top-color: var(--bs-primary);
    }
  </style>
</head>