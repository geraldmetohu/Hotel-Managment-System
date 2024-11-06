<?php
// auth.php
require_once 'google-api-php-client-2.4.0/vendor/autoload.php'; // Shtegu për libraritë e klientit të PHP të Google API

session_start();

// Zëvendëso me kredencialet e klientit tënd
$client_id = '740940702495-4bb1mjpgch37khbcdj3j7arkstb86dbc.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'http://localhost/hotel/login-google.php'; // URL-ja për këtë skript

// Krijo një objekt të ri Google_Client
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope('email');
$client->addScope('profile');

// Nëse parametri "code" është i pranishëm në URL, shkëmbeje me një token hyrjeje
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Merr informacionin e përdoruesit nga API-ja e Google
    $service = new Google_Service_Oauth2($client);
    $userInfo = $service->userinfo->get();

    // Ruaj të dhënat e përdoruesit në bazën e të dhënave
    $dbHost = 'localhost';
    $dbName = 'hotel';
    $dbUser = 'root';
    $dbPass = '';
    try {
        $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM staf WHERE google_id = :google_id");
        $stmt->bindParam(':google_id', $userInfo->id);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            // Përdoruesi ekziston tashmë në bazën e të dhënave, kyçi në llogari
            $_SESSION['user'] = $user;
            $_SESSION['user']['role'] = 'user'; // Vendos rolin në "përdorues" në sesion
            $_SESSION['user']['emp_id'] = $user['staffID']; // Ruaj emp_id në sesion
            $_SESSION['emp_id'] = $user['staffID']; // Ruaj emp_id në sesion
            $_SESSION['role'] = $user['roli']; // Ruaj rolin në sesion
            header("Location: index.php"); // Ridrejto tek faqja e profilit të përdoruesit
            exit();
        } else {
            // Përdoruesi nuk ekziston, krijoni një regjistrim të ri në bazën e të dhënave
            $stmt = $conn->prepare("INSERT INTO staf (fname, lname, email, google_id, profile_pic) VALUES (:fname, :lname, :email, :google_id, :profile_pic)");
            $stmt->bindParam(':fname', $userInfo->givenName);
            $stmt->bindParam(':lname', $userInfo->familyName);
            $stmt->bindParam(':email', $userInfo->email);
            $stmt->bindParam(':google_id', $userInfo->id);
            $stmt->bindParam(':profile_pic', $userInfo->picture);
            // $stmt->bindParam(':pass', $userInfo->id); // Vendosni fjalëkalimin te Google ID si shembull (mund të dëshironi të trajtoni kriptimin e fjalëkalimit)
            $stmt->execute();

            // Merr përdoruesin e sapo krijuar nga baza e të dhënave
            $stmt = $conn->prepare("SELECT * FROM staf WHERE google_id = :google_id");
            $stmt->bindParam(':google_id', $userInfo->id);
            $stmt->execute();
            $user = $stmt->fetch();

            // Kyçu përdoruesin
            $_SESSION['user'] = $user;
            $_SESSION['user']['role'] = 'user'; // Vendos rolin në "përdorues" për të gjithë përdoruesit të rinj
            $_SESSION['emp_id'] = $user['staffID']; // Ruaj emp_id në sesion
            $_SESSION['role'] = $user['roli']; // Ruaj rolin në sesion
            header("Location: index.php"); // Ridrejto tek faqja e profilit të përdoruesit
            exit();
        }
    } catch (PDOException $e) {
        echo "Lidhja dështoi: " . $e->getMessage();
    }
}

// Nëse përdoruesi është kyçur tashmë, ridrejto tek faqja e profilit
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Krijo URL-në e autorizimit dhe ridrejto përdoruesin në faqen e hyrjes së Gmail-it
$authUrl = $client->createAuthUrl();
header("Location: $authUrl");
exit();
?>
