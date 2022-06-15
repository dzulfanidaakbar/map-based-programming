<?php
$dbhost = '178.128.82.218';
$dbname = 'Dzulfanida';
$dbuser = 'postgres';
$dbpass = 'stmik-amikbandung';
$dbconn = pg_connect(“
host=$dbhost
dbname=$dbname
user=$dbuser
password=$dbpass
")
or die('Could not connect: ' . pg_last_error());
$name = $_POST["name"];
$notes = $_POST["notes"];
$type = $_POST["type"];
$geojson = $_POST["geojson"];
$query = "insert into gis (
name, notes, type, geojson, geometry2
) ";
$query .= "values ('$name', '$notes', '$type', '$geojson’,
ST_TRANSFORM(ST_GeomFromGeoJSON('$geojson'),3857)
)";
$result = pg_query($query) or die('Error message: ‘ .
pg_last_error());
$response = [];
if ($result) {
$response['success'] = true;
$response['message'] = 'Insert Data Success';
$response['data'] = [];
} else {
$response['success'] = false;
$response['message'] = 'Insert Data Failed';
$response['data'] = [];
}
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
pg_free_result($result);
pg_close($dbconn);
?>