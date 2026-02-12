<?php
session_start(); 


if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.html");
    exit();
}

require_once 'config_strava.php' ; 
require_once 'db_connect.php' ;
require_once 'config_gemini.php' ; 
require_once 'profil.php'; 

$pool_size = $_POST['pool_size'] ;
$swim_distance = $_POST['swim-distance'] ;
$experience = $_POST['experience'] ; 
$activitiesList = callStravaAPI('https://www.strava.com/api/v3/athlete/activities?per_page=20', $token); 


function askGeminiCoachSwim ($stats, $latestActivity){
    $apiKey = GEMINI_API_KEY ;

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey;

    $prompt = "Tu es un coach de triathlon expérimenté, pédagogue et professionnel. Tu conseilles en fonction du niveau de fatigue, des dernières performances
    sur les activités, des données que tu possède sur l'athlète. Tu devras toujours prévenir aussi l'athlète de voir le médecin aux quelconques signes d'alerte, que tu n'es pas responsables des blessures que l'athlète peut se faire et qu'il doit toujours revérifier tes propos.
     Analyse donc les données de l'athlète si possible : \n";

     
$lastSwim = null; 

if (!empty($activitiesList)) {
    foreach ($activitiesList as $activity) {

        if ($activity['type'] === 'Swim') {
            $lastSwim = $activity;
            break; 
        }
    }
}


     if($lastSwim){
        $dist = round($lastSwim['distance'] / 1000, 2 );
        $type = $lastSwim['type'];
        $time = gmdate("H:i:s", $lastSwim['moving_time']);
        $prompt .= "- Dernière séance : $type de $dist km en $time.\n";
     }
$runKm = isset($stats['all_run_totals']['distance']) ? round($stats['all_run_totals']['distance']/1000, 0) : 0;
    $bikeKm = isset($stats['all_ride_totals']['distance']) ? round($stats['all_ride_totals']['distance']/1000, 0) : 0;
    $swimKm = isset($stats['all_swim_totals']['distance']) ? round($stats['all_swim_totals']['distance']/1000, 0) : 0;


    $prompt .= "- Totaux saison : Run $runKm km | Vélo $bikeKm km | Natation $swimKm km.\n";
    $prompt .= "Consigne : Donne-moi une analyse très brève de ma forme (1 phrase) et propose-moi UNE séance précise et optimisé    pour demain (détaille l'échauffement et le corps de séance).";


    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
        return $json['candidates'][0]['content']['parts'][0]['text'];
    } else {
        return "Erreur API ou Quota";
    }

}


?>