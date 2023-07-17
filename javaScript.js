// Получаем ссылку на кнопку и поле ввода
//const button = document.getElementById('buttonSend');
//const input = document.getElementById('input');
const purseLink = document.getElementById('purseLink');
const mainDiv = document.getElementById('main');

//функция печати сообщения в диве с ответом
function DisplayMessage (message) {
    let responseDiv = document.getElementById('response')
    let redirectionMessage = document.createElement('div')
    redirectionMessage.id = "redirectionMessage";
    redirectionMessage.style.display = "flex";
    redirectionMessage.style.justifyContent = "center";
    redirectionMessage.style.alignItems = "center";
    responseDiv.innerHTML = ""
    redirectionMessage.innerHTML = message;
    responseDiv.appendChild(redirectionMessage);
}
//отправка сообщения с инпута
mainDiv.addEventListener('click' , function (event) {
    if (event.target.id === 'buttonSend') {
        const input = document.getElementById('input');
        if (input.value === '') {
            //похоже что не срабатывает тут ?
            DisplayMessage("you must put link into field below")
            return
        }
        DisplayMessage('ok checking in process')
        console.log('ok checking')
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
                    const contentType = xhr.getResponseHeader('Content-Type');
                    // Получаем ответ от сервера
                    if (contentType === 'application/json') {
                        const response = JSON.parse(xhr.responseText);
                        console.log("RESPONSE:  \n", response);
                        displayResponse(response)
                        console.log('Content-Type: ' + contentType)
                    } else {
                        //console.log('else')
                        //обрабатываем как простой текст
                        const responseTxt = xhr.responseText;
                        console.log('RESPONSE: ', responseTxt);
                        DisplayMessage(responseTxt)
                    }
                }else if (xhr.status === 504) {
                    //сообщение если нет ответа
                    DisplayMessage('time is out, server was not request')
                } else {
                    console.error('Произошла ошибка при выполнении запроса.');
                    //сообщение ошибки запроса
                    DisplayMessage("error of performance request")
                }
            }
        };

        function displayResponse (result) {
            //получаем окно вывода
            let responseDiv = document.getElementById('response')
            // очищаем окно вывода
            DisplayMessage("Done")
            for (let i = 0; i < result.length; i++) {
                console.log("done")
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