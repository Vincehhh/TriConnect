<?php
session_start();
require_once 'assets/php/config_strava.php';
require_once 'assets/php/db_connect.php';

$stmtStrava = $pdo->prepare("SELECT * FROM oauth_tokens WHERE user_id = ? AND provider = 'strava'");
$stmtStrava->execute([$_SESSION['user_id']]);
$stravaAccount = $stmtStrava->fetch();

$isStravaConnected = ($stravaAccount !== false);

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

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.html");
    exit();
}


$stmtUser = $pdo->prepare("SELECT email FROM users WHERE id = ?");
$stmtUser->execute([$_SESSION['user_id']]);
$userInfo = $stmtUser->fetch();

$email = htmlspecialchars($userInfo['email'] ?? 'Non renseigné');
$username = htmlspecialchars($_SESSION['username']);
$role = htmlspecialchars($_SESSION['role']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - TriConnect</title>
    <link rel="stylesheet" href="assets/css/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div id="cookie-banner">
      <p>Nous utilisons des cookies pour améliorer votre expérience. 
         <button id="accept-cookies">Accepter</button>
      </p>
    </div>

    <header>
    <div class="logo">
      <div class="logo-img">
        <img src="logo.png" alt="">
       </div>
      <div class="logo-nom">TriConnect</div>
    </div>
    <nav>
      <ul>
        <li><a href="sport.html">Accueil</a></li>
        <li><a href="#">Discussions</a></li>
        <li><a href="#">Suivi</a></li>
        <li><a href="#">Profil</a></li>
        <li><a href="connexion.html" class="btn">Connexion</a></li>
      </ul>
    </nav>
    </header>

    <main class="container">
        <section class="section futuristic-section">
            <div class="glass-container">
                <h1 class="neon-title">Bienvenue, <?= $username ?> !</h1>

                 <?php

              $authUrl = STRAVA_AUTH_URL . '?' . http_build_query([
                  'client_id' => STRAVA_CLIENT_ID,
                  'redirect_uri' => STRAVA_REDIRECT_URI,
                  'response_type' => 'code',
                  'approval_prompt' => 'auto',
                  'scope' => 'activity:read_all,profile:read_all'
              ]);
              ?>


                <?php if (!$isStravaConnected): ?>
            <a href="<?= $authUrl ?>" class="btn-strava" style="display:inline-block; background: white; width : 30% ; color: black; padding: 15px 30px; margin-bottom: 30px; text-decoration: none;text-align: center; border-radius: 5px; font-weight: bold; font-family: sans-serif;">
            Se connecter avec <span style="color: #FC4C02;   text-shadow: 
            0 0 1px rgba(233, 109, 8, 0.9); ">
            <i class="fab fa-strava"></i></span> 
            Strava
           </a>
        <?php endif; ?>

              <?php if ($isStravaConnected): ?>
                  <div class="alert-success">
                    <p>Strava a été lié avec succès à votre compte TriConnect !</p>
                  </div>
              <?php endif; ?>
               <?php if (!$isStravaConnected): ?>
                  <div class="alert-error">
                    <p>Une erreur est survenue lors de la liaison avec Strava. Veuillez réessayer.</p> 
                  </div>
              <?php endif; ?>
                
                <p class="section-desc">
                    Ceci est votre espace personnel sécurisé.
                    <br>Votre rôle actuel : <strong><?= $role ?></strong>
                </p>
                      <div class="profile-content">
                          <h3>Mes Infos</h3>
                           <hr style="width : 25% ; margin: 5px 0 20px 0;">
                          <p>Email : <?= $email ?></p>
                          <p>Nom d'utilisateur : <?= $username ?></p>
                 </div>

              <div class="profile-strava">
                  <h3>Mes Activités Strava</h3>
                  <hr style="width : 20% ; margin: 5px 0 20px 0;">
                  <?php if (!$isStravaConnected): ?>
                  <span style="display:inline-block; margin-top: 8px;"><p>Vos activités Strava apparaîtront ici une fois que vous aurez connecté votre compte.</p></span>
                  <?php endif; ?>
                  <?php if ($isStravaConnected): ?>
                  <p> Vos données sportives Strava : </p></div>
                  <?php if ($latestActivity): ?>
                      <div class="strava-activity">
                          <h4>Dernière activité : <?= htmlspecialchars($latestActivity['name']) ?></h4>
                          <p>Type : <?= htmlspecialchars($latestActivity['type']) ?></p>
                          <p>Distance : <?= round($latestActivity['distance'] / 1000, 2) ?> km</p>
                          <p>Durée : <?= gmdate("H:i:s", $latestActivity['moving_time']) ?></p>
                          <p>Date : <?= date("d M Y", strtotime($latestActivity['start_date'])) ?></p>
                      </div>
                      <div class="strava-athlète">
                        
                      </div>
                  <?php endif; ?> 
                  <?php endif; ?> 
                  
              </div>
            </div>
        </section>
      <div class="strava-section" style="text-align: center; margin-top: 30px;">

    </div>
    </main>

      <footer>
    <hr>
     <div class="footer-liste">
   
   <div class="footer-serviceClient">
     <span> Service client </span>
    <ul>
      <li> <a href="# "> Centre d'assistance</a></li>
      <li> <a href="#">Contacts</a></li>
    </ul>
   </div>

  
   <div class="footer-Societe">
     <span> Société </span>
   <ul>
       <li> <a href="# "> A propos</a></li>
      <li> <a href="#">Carrières</a></li>
   </ul>
   </div>
   <div class="footer-Plateformes">
     <span> Plateformes </span>
    <ul>
      <li> <a href="# "> Strava</a></li>
      <li> <a href="#">Garmin</a></li>
      <li> <a href="#">Coros</a></li>
       <li> <a href="#">TrainingPeaks</a></li>
    </ul>
   </div>
 </div>
  
  <div class="footer-information">
    <div class="footer-information-pays"> France</div>
    <div class="footer-information-logoRéseaux">
      <ul> 
        <li> <a href="#"><img src="assets/img/insta.jpeg" alt=""> </a></li>
        <li> <a href="#"><img src="assets/img/facebook.jpeg" alt=""> </a></li>
        <li> <a href="#"><img src="assets/img/x.jpeg" alt=""></a></li>
      </ul>
    </div>
  </div>
 <hr>

 <div class="footer-cookie">
  <a href="#"> Paramètres Cookies</a>
 </div>


  </footer>
<script src="assets/js/fichier.js"></script>
<script src="assets/js/cookie.js"></script> 
</body>
</html>