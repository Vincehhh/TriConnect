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


function askGeminiCoach ($stats, $latestActivity){
    $apiKey = GEMINI_API_KEY ;

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey;

    $prompt = "Tu es un coach de triathlon expérimenté, pédagogue et professionnel. Tu conseilles en fonction du niveau de fatigue, des dernières performances
    sur les activités, des données que tu possède sur l'athlète. Tu devras toujours prévenir aussi l'athlète de voir le médecin aux quelconques signes d'alerte, que tu n'es pas responsables des blessures que l'athlète peut se faire et qu'il doit toujours revérifier tes propos.
     Analyse donc les données de l'athlète si possible : \n";

     if($latestActivity){
        $dist = round($latestActivity['distance'] / 1000, 2 );
        $type = $latestActivity['type'];
        $time = gmdate("H:i:s", $latestActivity['moving_time']);
        $prompt .= "- Dernière séance : $type de $dist km en $time.\n";
     }



}


?>