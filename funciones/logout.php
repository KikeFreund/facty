<?php
// logout.php

// Si usas sesiones
session_start();
session_unset();
session_destroy();

// Borrar la cookie del token (ajusta el nombre si usas otro)
setcookie("token_sesion", "", time() - 3600, "/");

// Redirigir al login o al home
header("Location: /login");
exit;
