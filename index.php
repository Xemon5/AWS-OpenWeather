<!DOCTYPE html>
<html lang="hu">
<head>
    <title>⛅ Főoldal | AWS Cloud x NJE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

<div class="container mt-5">

    <div class="logo-wrapper">
        <img src="assets/img/logo.png" alt="Logo">
        <span style="font-size:100px;">×</span>
        <img src="assets/img/nje.png" alt="Logo">
    </div>

    <div class="card shadow-sm p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">🔍 Keress rá egy városra!</h2>
            <a href="list.php" class="btn btn-secondary">Mentett adatok</a>
        </div>

        <form method="GET" action="index.php" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="city" class="form-control" placeholder="Város neve..." required>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary"><b>Keresés 🔍</b></button>
            </div>
        </form>

        <hr>

        <?php
        if(isset($_GET['city'])){
            $city = urlencode($_GET['city']);

            $api_url1 = "http://localhost:5000/weather/$city";
            $api_url2 = "http://localhost:5000/weather/forecast/$city";

            // Aktuális időjárás
            $data_json = @file_get_contents($api_url1);

            if($data_json === FALSE){
                echo "<div class='alert alert-danger mt-3'>Nincs ilyen nevű város.</div>";
            } else {
                $data = json_decode($data_json, true);

                // API hiba ellenőrzése
                if(isset($data['cod']) && $data['cod'] != 200){
                    echo "<div class='alert alert-danger mt-3'>A város nem létezik vagy nem található.</div>";
                } else {

                    // Forecast lekérése
                    $forecast_json = @file_get_contents($api_url2);
                    $forecast = json_decode($forecast_json, true) ?? [];

                    echo "<div class='row mt-4'>";

                    echo "<div class='col-md-6'>";
                    $user_input = $_GET['city'];
                    $formatted = ucwords(strtolower($user_input));

                    echo "<h3 class='mb-3'>{$formatted}</h3>";
                    echo "<img src='http://openweathermap.org/img/wn/".$data['icon']."@2x.png'>";

                    echo "<h4 class='text-capitalize mt-2'>{$data['description']}</h4>";

                    echo "<table class='weather-table mt-3'>
                            <tr><th>Hőmérséklet</th><td>{$data['temperature']} °C</td></tr>
                            <tr><th>Érzett</th><td>{$data['feels_like']} °C</td></tr>
                            <tr><th>Min</th><td>{$data['temp_min']} °C</td></tr>
                            <tr><th>Max</th><td>{$data['temp_max']} °C</td></tr>
                            <tr><th>Páratartalom</th><td>{$data['humidity']}%</td></tr>
                            <tr><th>Légnyomás</th><td>{$data['pressure']} hPa</td></tr>
                            <tr><th>Szél</th><td>{$data['wind_speed']} km/h</td></tr>
                          </table>";

                    echo "
                        <form method='POST' action='save.php' class='mt-3'>
                            <input type='hidden' name='json' value='".htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8')."'>
                            <button type='submit' class='btn btn-success'>Mentés</button>
                        </form>
                    ";

                    echo "</div>";

                    echo "<div class='col-md-6 forecast-box'>";
                    echo "<h4 class='mb-3'>Előrejelzés</h4>";

                    if(!empty($forecast)){
                        foreach($forecast as $f){

                            echo "<div class='forecast-item'>";
                            echo "<h5>{$f['time']}</h5>";
                            echo "<img src='http://openweathermap.org/img/wn/{$f['icon']}@2x.png'>";

                            echo "<table class='mt-2 weather-table'>
                                    <tr><th>Hőmérséklet</th><td>{$f['temperature']} °C</td></tr>
                                    <tr><th>Páratartalom</th><td>{$f['humidity']}%</td></tr>
                                    <tr><th>Szél</th><td>{$f['wind_speed']} km/h</td></tr>
                                    <tr><th>Leírás</th><td class='text-capitalize'>{$f['description']}</td></tr>
                                  </table>";

                            echo "</div>";
                        }
                    } else {
                        echo "<p>Nincs elérhető előrejelzés.</p>";
                    }

                    echo "</div>";

                    echo "</div>";
                }
            }
        }
        ?>
    </div>
</div>

</body>
</html>
