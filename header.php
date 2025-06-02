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
      --bs-primary: #9932cc !important;
      --bs-primary-rgb: 153, 50, 204 !important;
      --bs-primary-dark: #800080 !important;
      --bs-primary-dark-rgb: 128, 0, 128 !important;
    }

    /* Sobrescribir colores de Bootstrap con mayor especificidad */
    .btn.btn-primary,
    .btn-primary {
      background-color: var(--bs-primary) !important;
      border-color: var(--bs-primary) !important;
    }
    .btn.btn-primary:hover,
    .btn-primary:hover {
      background-color: var(--bs-primary-dark) !important;
      border-color: var(--bs-primary-dark) !important;
      transform: translateY(-1px);
      box-shadow: 0 5px 15px rgba(var(--bs-primary-rgb), 0.4);
    }
    .btn.btn-primary:focus,
    .btn-primary:focus {
      background-color: var(--bs-primary) !important;
      border-color: var(--bs-primary) !important;
      box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }
    .btn.btn-primary:active,
    .btn-primary:active {
      background-color: var(--bs-primary-dark) !important;
      border-color: var(--bs-primary-dark) !important;
    }

    .text-primary,
    .text-primary:hover {
      color: var(--bs-primary) !important;
    }
    .bg-primary,
    .bg-primary:hover {
      background-color: var(--bs-primary) !important;
    }
    .border-primary,
    .border-primary:hover {
      border-color: var(--bs-primary) !important;
    }

    /* Navbar específico */
    .navbar.navbar-dark {
      background-color: var(--bs-primary) !important;
    }

    /* Footer específico */
    .footer {
      background-color: var(--bs-primary) !important;
    }

    /* Estilos para enlaces */
    a:not(.btn):not(.nav-link) {
      color: var(--bs-primary) !important;
      transition: all 0.3s ease;
    }
    a:not(.btn):not(.nav-link):hover {
      color: var(--bs-primary-dark) !important;
    }

    /* Estilos para inputs */
    .form-control:focus {
      border-color: var(--bs-primary) !important;
      box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25) !important;
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
      background-color: var(--bs-primary) !important;
      color: white;
    }

    /* Estilos para badges */
    .badge.bg-primary {
      background-color: var(--bs-primary) !important;
    }

    /* Estilos para paginación */
    .page-item.active .page-link {
      background-color: var(--bs-primary) !important;
      border-color: var(--bs-primary) !important;
    }
    .page-link {
      color: var(--bs-primary) !important;
    }
    .page-link:hover {
      color: var(--bs-primary-dark) !important;
    }

    /* Estilos para alertas */
    .alert-primary {
      background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
      border-color: rgba(var(--bs-primary-rgb), 0.2) !important;
      color: var(--bs-primary) !important;
    }

    /* Estilos para tooltips */
    .tooltip .tooltip-inner {
      background-color: var(--bs-primary) !important;
    }
    .tooltip.bs-tooltip-top .tooltip-arrow::before {
      border-top-color: var(--bs-primary) !important;
    }
  </style>
</head>