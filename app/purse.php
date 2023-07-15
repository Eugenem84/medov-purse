<?php
//echo "ok \n" . "<br>";
$resURLs = [];
function check_redirection($url)
{
    global $resURLs;
    static $URLs = [];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode === 301 || $httpCode === 302) {
        $headers = explode("\n", $response);
        foreach ($headers as $header) {
            if (strpos($header, 'Location') !== false) {
                $rediracted_url = trim(str_replace('Location:', '', $header));
                array_push($URLs, $rediracted_url);
                check_redirection($rediracted_url);
                $resURLs = $URLs;
                break;
            }
        }
    } else {
        echo "Ссылка не переадресуется";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['data']);
    if ($message === "") {
        echo "url form is empty \n";
    } else {
        check_redirection($message);
        $jsonURLs = json_encode($resURLs);
        header('Content-Type: application/json');
        echo $jsonURLs;
    }
} else {
    echo "data was not keep \n";
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Метод POST ожидается\n");
}
