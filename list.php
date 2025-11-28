<!DOCTYPE html>
<html lang="hu">
<head>
    <title>⛅ Mentett városok | AWS Cloud x NJE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow-sm p-4">

        <div class="d-flex justify-content-between mb-4">
            <h2>🏢 Mentett városok időjárás adatai</h2>
            <a href="index.php" class="btn btn-primary" style="margin-top:10px;"><b><-- Vissza a kereséshez</b></a>
        </div>

        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Város</th>
                    <th>Ikon</th>
                    <th>Hőmérséklet</th>
                    <th>Érzett</th>
                    <th>Min</th>
                    <th>Max</th>
                    <th>Páratartalom</th>
                    <th>Légnyomás</th>
                    <th>Szél</th>
                    <th>Leírás</th>
                    <th>Művelet</th>
                </tr>
            </thead>
            <tbody class="table-dark">

            <?php
            $data = json_decode(file_get_contents("http://localhost:5000/weather/all"), true);

            foreach($data as $row){
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['city']}</td>
                    <td><img src='http://openweathermap.org/img/wn/{$row['icon']}@2x.png'></td>
                    <td>{$row['temperature']} °C</td>
                    <td>{$row['feels_like']} °C</td>
                    <td>{$row['temp_min']} °C</td>
                    <td>{$row['temp_max']} °C</td>
                    <td>{$row['humidity']}%</td>
                    <td>{$row['pressure']} hPa</td>
                    <td>{$row['wind_speed']} km/h</td>
                    <td class='text-capitalize'>{$row['description']}</td>
                    <td>
                        <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Törlés</a>
                    </td>
                </tr>
                ";
            }
            ?>

            </tbody>
        </table>

    </div>
</div>

</body>
</html>
