<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lector de Código QR</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        .container {
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        #reader {
            width: 100%;
            max-width: 500px;
            margin: 20px auto;
        }
        #result {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lector de Código QR</h1>
        <button id="startButton" class="btn">Iniciar Cámara</button>
        <button id="stopButton" class="btn" style="display: none;">Detener Cámara</button>
        <div id="reader"></div>
        <div id="result"></div>
    </div>

    <script>
        let html5QrcodeScanner = null;
        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');
        const resultDiv = document.getElementById('result');

        startButton.addEventListener('click', () => {
            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5Qrcode("reader");
                const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                
                html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    onScanSuccess,
                    onScanFailure
                );

                startButton.style.display = 'none';
                stopButton.style.display = 'inline-block';
            }
        });

        stopButton.addEventListener('click', () => {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                    startButton.style.display = 'inline-block';
                    stopButton.style.display = 'none';
                }).catch(err => {
                    console.error("Error al detener el escáner:", err);
                });
            }
        });

        function onScanSuccess(decodedText, decodedResult) {
            // Detener el escáner después de una lectura exitosa
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                    startButton.style.display = 'inline-block';
                    stopButton.style.display = 'none';
                });
            }
            
            // Mostrar el resultado
            resultDiv.innerHTML = `
                <h3>Código QR detectado:</h3>
                <p>${decodedText}</p>
            `;

            // Aquí puedes agregar la lógica para procesar el código QR
            // Por ejemplo, redirigir a una URL o procesar los datos
            console.log("Código QR detectado:", decodedText);
        }

        function onScanFailure(error) {
            // Manejar el error de escaneo
            console.warn(`Error al escanear: ${error}`);
        }
    </script>
</body>
</html>
