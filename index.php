<?php
// index.php
require('header.php');
require('verificacion.php');

require('route.php');
require($ruta.'/nav.php');
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

switch ($uri) {
    case '':
        require 'pages/home.php';
        break;
   case 'index':
          require 'pages/home.php';
        break;

        case 'login':
            require 'pages/login.php';
            break;
            case 'informacion-personal':
                require 'pages/informacion-personal.php';
                break;
                case 'mis-servicios':
                    require 'pages/mis-servicios.php';
                    break;
                    case 'facturas':
                        require 'pages/facturas.php';
                        break;
    

    case 'facturacion':
        require 'pages/facturacion.php';
        break;

    default:
        http_response_code(404);
        require 'pages/404.php';
        break;
}
require($ruta."/footer.php");