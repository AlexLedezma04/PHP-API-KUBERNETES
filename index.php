<?php
$defaultLat = "9.9281";
$defaultLon = "-84.0907";

// Coordenadas personalizadas por GET
$lat = isset($_GET['lat']) ? $_GET['lat'] : $defaultLat;
$lon = isset($_GET['lon']) ? $_GET['lon'] : $defaultLon;

// URL de la API Open-Meteo
$apiUrl = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current_weather=true";

// Consumir la API
$responseJson = @file_get_contents($apiUrl);
$data = null;
$error = null;

if ($responseJson === FALSE) {
    $error = "No se pudo conectar con la API de clima.";
} else {
    $data = json_decode($responseJson, true);
    if ($data === null) {
        $error = "Error al decodificar la respuesta JSON de la API.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clima actual - PHP + Docker + Kubernetes (Debian)</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255,255,255,0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
        .card { 
            border: 1px solid rgba(255,255,255,0.3); 
            padding: 20px; 
            border-radius: 10px; 
            background: rgba(255,255,255,0.05);
            margin: 20px 0;
        }
        label { 
            display: block; 
            margin-top: 10px; 
            font-weight: bold;
        }
        input[type="text"] { 
            width: 100%; 
            padding: 10px; 
            border-radius: 5px;
            border: none;
            margin-top: 5px;
        }
        button { 
            margin-top: 15px; 
            padding: 12px 25px; 
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #45a049;
        }
        h1 {
            text-align: center;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        .result {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        li:last-child {
            border-bottom: none;
        }
        .error {
            background: rgba(255,0,0,0.2);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid rgba(255,0,0,0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Clima Actual</h1>
        <p class="subtitle">Aplicación PHP + Docker + Kubernetes en Debian</p>
        
        <div class="card">
            <form method="get">
                <label>
                    Latitud:
                    <input type="text" name="lat" value="<?php echo htmlspecialchars($lat); ?>" placeholder="Ej: 9.9281">
                </label>
                <label>
                    Longitud:
                    <input type="text" name="lon" value="<?php echo htmlspecialchars($lon); ?>" placeholder="Ej: -84.0907">
                </label>
                <button type="submit">🔍 Consultar Clima</button>
            </form>
        </div>

        <?php if ($error): ?>
            <div class="error">
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif ($data && isset($data['current_weather'])): ?>
            <?php $current = $data['current_weather']; ?>
            <div class="result">
                <h2>Resultado</h2>
                <ul>
                    <li><strong>Temperatura:</strong> <?php echo $current['temperature']; ?> °C</li>
                    <li><strong>Velocidad del viento:</strong> <?php echo $current['windspeed']; ?> km/h</li>
                    <li><strong>Dirección del viento:</strong> <?php echo $current['winddirection']; ?>°</li>
                    <li><strong>Hora de lectura:</strong> <?php echo htmlspecialchars($current['time']); ?></li>
                </ul>
            </div>
        <?php else: ?>
            <p class="subtitle">No hay datos de clima disponibles.</p>
        <?php endif; ?>
    </div>
</body>
</html>