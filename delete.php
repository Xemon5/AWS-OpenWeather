<?php
$id = $_GET["id"];
$api_url = "http://localhost:5000/weather/$id";

$opts = [
    'http' => [
        'method' => "DELETE"
    ]
];

$ctx = stream_context_create($opts);
file_get_contents($api_url, false, $ctx);

header("Location: list.php");
exit;
?>