$companyOrigins = "$lat2,$lng2";
$userDistinations = "$lat1,$lng1";
$url = "https://maps.googleapis.com/maps/api/directions/json?origin=$companyOrigins&destination=$userDistinations&key=$apiKey";
$response = Http::get($url);
if (isset($response["routes"][0]["legs"][0]["distance"]["value"])) {
    $value = $response["routes"][0]["legs"][0]["distance"]["value"];
    return round($value / 1000, 2);
}