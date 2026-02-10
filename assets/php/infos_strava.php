
<?php
session_start();
require_once 'assets/php/config_strava.php';


function callStravaAPI($url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $token
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$stravaData = null;
$latestActivity = null;

if ($isStravaConnected) {
    $token = $stravaAccount['access_token'];

    $athleteInfo = callStravaAPI('https://www.strava.com/api/v3/athlete', $token);

    $activities = callStravaAPI('https://www.strava.com/api/v3/athlete/activities?per_page=1', $token);
    
    if (!empty($activities)) {
        $latestActivity = $activities[0]; 
    }
}
?>