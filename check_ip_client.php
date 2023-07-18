<?php
$server = $_SERVER;
$ip = $server['REMOTE_ADDR'];
$language = $server['HTTP_ACCEPT_LANGUAGE'];
$user_agent = $server['HTTP_USER_AGENT'];
$browser = "Неизвестный браузер";
$os = "Неизвестная операционная систма";
$computerName = shell_exec('hostname');
//вычисляем браузер
if (preg_match('/MSI/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
    $browser = 'Internet Explorer';
} elseif (preg_match('/Firefox/i', $user_agent)) {
    $browser = 'Mozilla Firefox';
} elseif (preg_match('/Chrom/i', $user_agent)) {
    $browser = 'Google Chrome';
} elseif (preg_match('/Safari/i', $user_agent)) {
    $browser = 'Apple Safari';
} elseif (preg_match('/Opera/i', $user_agent)) {
    $browser = 'Opera';
} elseif (preg_match('/Netscape/i', $user_agent)) {
    $browser = 'Netscape';
}
//вычисляем операционную систему
if (preg_match('/Windows/i', $user_agent)) {
    $os = 'Windows';
} elseif (preg_match('/Mac/i', $user_agent)) {
    $os = 'Mac';
} elseif (preg_match('/Linux/i', $user_agent)) {
    $os = 'Linux';
} elseif (preg_match('/Unix/i', $user_agent)) {
    $os = 'Unix';
} elseif (preg_match('/Ubuntu/i', $user_agent)) {
    $os = 'Ubuntu';
} elseif (preg_match('/Android/i', $user_agent)) {
    $os = '';
} elseif (preg_match('/iOS/i', $user_agent)) {
    $os = 'iOS';
}
?>

<div class="container">
    <div class="item" id="ip">
        Ваш ip адрес: <div class="info" id="ip" >
            <?=$ip;?>
        </div>
    </div>
    <div class="item" id="System" >
        Ваша операционная система:
        <div class="info" id="os" >
            <?=$os;?>
        </div>
    </div>
    <div class="item" id="browser" >
        Ваш браузер: <div class="info" id="browser" >
            <?=$browser;?>
        </div>
    </div>
    <div class="item" id="computer">
        computer-name: <div class="info" id="computerName">
            <?=$computerName;?>
        </div>
    </div>
</div>
