// Función para mantener la sesión activa
function mantenerSesionActiva() {
    fetch('/funciones/keepalive.php', {
        method: 'POST',
        credentials: 'same-origin'
    }).catch(error => console.error('Error al mantener sesión activa:', error));
}

// Mantener la sesión activa cada 5 minutos
setInterval(mantenerSesionActiva, 5 * 60 * 1000);

// También mantener la sesión activa cuando la ventana recupera el foco
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') {
        mantenerSesionActiva();
    }
});

// Mantener la sesión activa cuando la PWA se inicia
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        mantenerSesionActiva();
    });
} 