$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

var getCleanUrl = function(url) {
    return url.replace(/#.*$/, '').replace(/\?.*$/, '');
};

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
    }
});

$("#filter_drop").change(function(){
    if($(this).val() === 0) $("#w0 input").attr('name', '');
    let valueSelect = $(this).val()
    $("#w0 input").attr('name', valueSelect);
    let str = valueSelect.toLowerCase();
    let column = str.split('[')[1].slice(0,-1);
    let action = str.split('[')[0];
    $("#w0 input").attr('id', action + '-' + column);
});