// Получаем ссылку на кнопку и поле ввода
const button = document.getElementById('buttonSend');
const input = document.getElementById('input');

// Функция обработки нажатия на кнопку
button.addEventListener('click', () => {
    // Получаем значение из поля ввода
    const data = input.value;

    // Создаем объект XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Устанавливаем метод и URL для запроса
    xhr.open('POST', 'app/purse.php', true);

    // Устанавливаем заголовки запроса
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Обрабатываем изменение состояния запроса
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Получаем ответ от сервера
                const response = JSON.parse(xhr.responseText);
                //document.getElementById('response').innerHTML = response;
                console.log("RESPONSE:  \n", response);
                displayResponse(response)
            } else {
                console.error('Произошла ошибка при выполнении запроса.');
            }
        }
    };

    function displayResponse (result) {
        result.forEach(function (element) {
            document.getElementById("response").innerHTML += element + "<br>";
        })
    }

     //Отправляем запрос с данными
    xhr.send('data=' + encodeURIComponent(data));
    // xhr.onreadystatechange = function () {
    //     if (xhr.readyState === 3) {
    //         console.log("Download in process\n")
    //     }
    //     if (xhr.readyState ===4) {
    //         console.log("Downloaded \n ")
    //     }
    // }

    // xhr.onload = function () {
    //     if (xhr.status != 200) {
    //         console.log(`Error ${xhr.status}: ${xhr.statusText}`);
    //     }else {
    //         console.log(`Done, keep ${xhr.response.length} byte`);
    //     }
    // }
    // xhr.timeout = 2000;
});