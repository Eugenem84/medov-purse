// Получаем ссылку на кнопку и поле ввода
//const button = document.getElementById('buttonSend');
//const input = document.getElementById('input');
const purseLink = document.getElementById('purseLink');
const mainDiv = document.getElementById('main');

mainDiv.addEventListener('click' , function (event) {
    if (event.target.id === 'buttonSend') {
        const input = document.getElementById('input');
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
                    console.log("RESPONSE:  \n", response);
                    displayResponse(response)
                } else {
                    console.error('Произошла ошибка при выполнении запроса.');
                    //пока не знаю как проверить участок кода
                    let responseDiv = document.getElementById('response')
                    let redirectionMessage = document.createElement('div')
                    redirectionMessage.id = "redirectionMessage"
                    redirectionMessage.innerHTML = "redirection to: "
                }
            }
        };

        function displayResponse (result) {
            //получаем окно вывода
            let responseDiv = document.getElementById('response')
            // очищаем окно вывода
            responseDiv.innerHTML = ""
            for (let i = 0; i < result.length; i++) {
                let redirectionMessage = document.createElement('div')
                redirectionMessage.id = "redirectionMessage"
                redirectionMessage.innerHTML = "redirection to: "
                //console.log(redirectionMessage)
                console.log(result[i])
                //вставляем сообщение
                responseDiv.appendChild(redirectionMessage)
                // создаем инпут для ссылки
                let newURLDiv = document.createElement('input')
                // обявляем класс для инпута
                newURLDiv.className = 'newURLDiv';
                // вставляем инпут в див response
                responseDiv.appendChild(newURLDiv);
                // вставляем result в ипут
                newURLDiv.value = result[i];
             //   responseDiv.appendChild(newURLDiv);
            }
        }

        //Отправляем запрос с данными
        xhr.send('data=' + encodeURIComponent(data));
    }
})

purseLink.addEventListener('click', () => {
    loadContent('purse_client.php');
});

function loadContent(menu_url) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("main").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", menu_url, true);
    xhttp.send();
}