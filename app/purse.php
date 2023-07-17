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
        //header('Content-Type: application/json');
        answerMessage("link is not redirect");
        //echo "Ссылка не переадресуется";
    }
}

function answerURL ($answerString) {
    header('Content-Type: application/json');
    $answerJson = json_encode($answerString);
    echo $answerJson;
}

function answerMessage ($answerString) {
    header('Content-Type: text/plain');
    $answerJson = json_encode($answerString);
    echo $answerJson;
}

//прием
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['data']);
    check_redirection($message);
    answerURL($resURLs);
} else {
    echo "data was not keep \n";
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Метод POST ожидается\n");
}
