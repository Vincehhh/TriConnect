<?php
session_start();
require_once 'db_connect.php'; 
require_once 'config_strava.php'; 

if (isset($_GET['code'])) {
    $auth_code = $_GET['code'];
} else {
    die("Erreur : Autorisation refusée par Strava.");
}


$params = [
    'client_id'     => STRAVA_CLIENT_ID,
    'client_secret' => STRAVA_CLIENT_SECRET,
    'code'          => $auth_code,
    'grant_type'    => 'authorization_code' 
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, STRAVA_TOKEN_URL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$response = curl_exec($ch); 

$data = json_decode($response, true);

if (isset($data['access_token'])) {
    $accessToken = $data['access_token']; 
    $refreshToken = $data['refresh_token']; 
    $expiresAt = $data['expires_at'];    
    
    try {
        if (!isset($_SESSION['user_id'])) {
            die("Erreur : Vous devez être connecté à TriConnect pour lier Strava.");
        }
        $userId = $_SESSION['user_id'];
        $stmt = $pdo->prepare("DELETE FROM oauth_tokens WHERE user_id = ? AND provider = 'strava'");
        $stmt->execute([$userId]);

        $sql = "INSERT INTO oauth_tokens (user_id, provider, access_token, refresh_token, expires_at) 
                VALUES (?, 'strava', ?, ?, FROM_UNIXTIME(?))";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $accessToken, $refreshToken, $expiresAt]);
        header("Location: ../../profil.php?strava=success");
        exit();

    } catch (PDOException $e) {
        die("Erreur base de données : " . $e->getMessage());
    }

} else {
    echo "<h3>Interdiction de permission</h3>";
    echo "<p>Réponse de Strava :</p>";
    echo "<pre>";
    print_r($data); 
    echo "</pre>";
}
?>