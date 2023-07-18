<?php
//echo "ok \n" . "<br>";
$resURLs = [];

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
function check_redirection($url)
{
    global $resURLs;
    static $URLs = [];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    switch ($httpCode) {
        case 301:
        case 302:
            $headers = explode("\n", $response);
            foreach ($headers as $header) {
                if (strpos($header, "Location") !== false) {
                    $rediracted_url = trim(str_replace("Location", '', $header));
                    array_push($URLs, $rediracted_url);
                    check_redirection($rediracted_url);
                    $resURLs = $URLs;
                }
            } break;
        case 500: answerMessage("Internal Server Error"); break;
        case 404: answerMessage("Not Found"); break;
        case 403: answerMessage("Forbidden"); break;
        case 400: answerMessage("Bad Request"); break;
        case 200: answerMessage("Link is not redirected"); break;
        default: answerMessage("I d't now whats going on"); break;
    }

//    if ($httpCode === 301 || $httpCode === 302) {
//        $headers = explode("\n", $response);
//        foreach ($headers as $header) {
//            if (strpos($header, 'Location') !== false) {
//                $rediracted_url = trim(str_replace('Location:', '', $header));
//                array_push($URLs, $rediracted_url);
//                check_redirection($rediracted_url);
//                $resURLs = $URLs;
//                break;
//            }
//        }
//    } else if ($httpCode === 500) {
//        answerMessage("Internal Server Error");
//    } else if ($httpCode === 404) {
//        answerMessage("Not Found");
//    } else if ($httpCode === 403) {
//        answerMessage("Forbidden:");
//    } else if ($httpCode === 400) {
//        answerMessage("Bad Request");
//    } else if ($httpCode === 200) {
//        answerMessage("link is not redirected");
//    } else {
//        answerMessage("i d't no what's going on");
//    }
}

//прием
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['data']);
    check_redirection($message);
    if ($resURLs[0] === $message) {
        answerMessage("link is not redirection");
    if (!empty($resURLs)) {
        answerURL($resURLs);
    } else {
        answerMessage("something else going on");
    }
} else {
    answerMessage("data was not keep \n");
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    answerMessage("POST is waiting\n");
}
