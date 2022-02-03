$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(document).on('click', 'body #button-submit', function () {
    let yiiform = $('body #message-form');
    // отправляем данные на сервер
    $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray()
        }
    )
        .done(function (data) {
            $('body #pills-message').html(data)
            let div = $("#messages-scroll");
            div.scrollTop(div.prop('scrollHeight'));
        })
        .fail(function () {
            // не удалось выполнить запрос к серверу
        })
    return false; // отменяем отправку данных формы
});

$('body #message-message').keydown(function(e) {
    if(e.keyCode === 13) {
        $('body #button-submit').click();
        return false;
    }
});