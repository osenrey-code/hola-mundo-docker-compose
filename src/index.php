<?php
$host = getenv('DB_HOST') ?: 'db';
$user = getenv('DB_USER') ?: 'app_user';
$password = getenv('DB_PASSWORD') ?: 'app_password';
$database = getenv('DB_NAME') ?: 'hola_mundo';

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    http_response_code(503);
    $hasError = true;
    $status = 'No se pudo conectar a MySQL: ' . $connection->connect_error;
    $message = 'Revisa que los servicios de Docker Compose estén iniciados.';
    $visits = [];
} else {
    $hasError = false;
    $status = 'Conectado correctamente a MySQL';
    $message = 'Hola mundo desde PHP + Docker Compose';
    $result = $connection->query('SELECT id, mensaje, creado_en FROM visitas ORDER BY id DESC');
    $visits = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $connection->close();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hola mundo con Docker Compose</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2ff; color: #172554; margin: 0; }
        main { max-width: 760px; margin: 70px auto; padding: 32px; background: white; border-radius: 16px; box-shadow: 0 10px 30px #0002; }
        h1 { margin-top: 0; }
        .status { padding: 12px 16px; border-radius: 8px; background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        li { margin: 10px 0; }
    </style>
</head>
<body>
<main>
    <h1><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="status <?= $hasError ? 'error' : '' ?>"><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></p>
    <h2>Registros obtenidos desde MySQL</h2>
    <?php if ($visits): ?>
        <ul>
            <?php foreach ($visits as $visit): ?>
                <li>#<?= (int) $visit['id'] ?> — <?= htmlspecialchars($visit['mensaje'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($visit['creado_en'], ENT_QUOTES, 'UTF-8') ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay registros disponibles todavía.</p>
    <?php endif; ?>
</main>
</body>
</html>
