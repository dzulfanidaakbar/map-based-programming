<?php
$dbhost = '178.128.82.218';
$dbname = 'Dzulfanida';
$dbuser = 'postgres';
$dbpass = 'stmik-amikbandung';

$dbconn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass")
or die('Could not connect: ' . pg_last_error());
$query = 'SELECT id, name, notes, type, geojson, ST_AsGeoJSON(geometry), ST_AsGeoJSON(geometry2) FROM public.gis';
$result = pg_query($query) or die('Error message: ' . pg_last_error());
$response = [];
if ($result) {
$data = [];
while ($row = pg_fetch_row($result)) {
$temp = [];
$temp['id'] = $row[0];
$temp['name'] = $row[1];
$temp['notes'] = $row[2];
$temp['type'] = $row[3];
$temp['geojson'] = json_decode($row[4], true);
$temp['geometry'] = json_decode($row[5], true);
$temp['geometry2'] = json_decode($row[6], true);
array_push($data, $temp);
}
$response['success'] = true;
$response['message'] = 'Get Data Success';
$response['data'] = $data;
} else {
$response['success'] = false;
$response['message'] = 'Get Data Failed';
$response['data'] = [];
}
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
pg_free_result($result);
pg_close($dbconn);
?>