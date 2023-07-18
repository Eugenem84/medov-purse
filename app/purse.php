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
    // результирующая глобальная переменная с массивом адресов
    global $resURLs;
    // массив с адресами сохраняющий значения в рекурсии
    static $URLs = [];
    // создается обработчик запросов с указаной ссылкой
    $ch = curl_init($url);
    // опция для обработчика ссылки что бы возвращал результат в виде строки а не выводился напрямую
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //опция для обработчика что бы заголовки ответа возвращал вместе с телом ответа
    curl_setopt($ch, CURLOPT_HEADER, true);
    // выполнение запроса хттп использую обработчик с урл сохраняет все в response
    $response = curl_exec($ch);
    // получаем код ответа
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    switch ($httpCode) {
        case 301:
        case 302:
            $headers = explode("\n", $response);
            foreach ($headers as $header) {
                if (strpos($header, "Location") !== false) {
                    $rediracted_url = trim(str_replace("Location:", '', $header));
                    array_push($URLs, $rediracted_url);
                    check_redirection($rediracted_url);
                }
            }
            break;
        case 500:
            answerMessage("Internal Server Error");
            break;
        case 404:
            answerMessage("Not Found");
            break;
        case 403:
            answerMessage("Forbidden");
            break;
        case 400:
            answerMessage("Bad Request");
            break;
//        case 200:
//            answerMessage("Link is not redirected");
//            break;
    }
    $resURLs = $URLs;
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


//прием
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['data']);
    check_redirection($message);
    if (!empty($resURLs)) {
        answerURL($resURLs);
    } else if (!empty($resURLs) && $resURLs[0] === $message) {
        answerMessage("Link is not redirected");
    }
}

//if (!empty($resURLs)) {
//   answerURL($resURLs);
//} else if (!empty($resURLs) && $resURLs[0] === $message) {
//    answerMessage("Link is not redirected");
//}

//if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//    answerMessage("POST is waiting\n");
//}
