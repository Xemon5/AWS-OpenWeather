<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>⛅ Város elmentve! | AWS Cloud x NJE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-sm p-4 text-center">

        <?php
        $json = $_POST['json'];
        $api_url = "http://localhost:5000/weather/save";

        $options = [
            'http' => [
                'header'  => "Content-Type: application/json",
                'method'  => 'POST',
                'content' => $json
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($api_url, false, $context);
        ?>

        <h2 class="mb-3">🎉 Sikeres mentés! 🎉</h2>
        
        <a href="index.php" class="btn btn-primary"><b><-- Vissza a főoldalra</b></a>
        <br>
        <a href="list.php" class="btn btn-success"><b>Mentett városok</b></a>

    </div>
</div>
</body>
</html>