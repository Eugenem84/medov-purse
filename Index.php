<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>docker ajax learning</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div id="header"> - SOME NAME SITE - </div>
    <div class="menu">
            <a id="purseLink" href="#" onclick="loadContent('purse_client.php');">Purse link</a>
            <a id="checkIpLink" href="#" onclick="loadContent('check_ip_client.php');"> Check ip</a>
            <a id="qr-code" href="#" onclick="loadContent('qr_code.php')">qr-code</a>
            <a id="some_one_else=#" onclick="loadContent('some_one_else.html')">some one else</a>
    </div>
    <div id="main">
        <!-- php loads their -->
    </div>
    <script src="javaScript.js"></script>
</body>
</html>
