<?php
echo "ok <br>";
function check_redirection($url) {
    // инициализация url
    $ch = curl_init($url);
    // установка параметров
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // включение заголовков в результат
    curl_setopt($ch, CURLOPT_HEADER, true);
    // выполнение запроса и получение ответа
    $response = curl_exec($ch);
    // получение http из ответа
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // проверка наличия переадресации
    if ($httpCode === 301 || $httpCode === 302) {
        // разбиваем заголовки по строкам
        $headers = explode("\n", $response);
        // ищем строку "location"
        foreach ($headers as $header) {
            if (strpos($header, 'Location') !== false) {
                // получаем новый url
                $rediracted_url = trim(str_replace('Location:', '', $header));
                // выводим новый url
                return $rediracted_url;
            }
        }
    }else{
        echo " Ссылка не переадресуется ";
    }
}

function makeJson ($URL) {
    echo "start makeJson";
    $limit = 0;
    $URLs = array();
    $resURL = "";
    while ($URL !== $resURL || $limit < 10) {
        $limit++;
        echo $limit;
        $resURL = check_redirection($URL);
        array_push($URLs, $resURL);
        echo $resURL;
    }
    return $URLs;
}
echo "check<br>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "start request" . "<br>";
    $message = trim ($_POST['data']);
    echo "message:" . $message . "<br>";
    if ($message === "") {
        echo " url form is empty" . "<br>";
    } else {
        echo "start else";
        $JsonURLs = makeJson($message);
        echo $JsonURLs[0] . "<br>";
        echo $JsonURLs[1] . "<br>";
        echo $JsonURLs[2] . "<br>";
    }
} else {
    echo "data was not received <br>";
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(" Метод POST ожидается <br>");
}
