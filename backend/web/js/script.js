$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(document).on('click', 'body #cancel-edit', function () {
    let form = $('body #message-form');
    let input = $('body #message-message');
    form.attr('action', '/application/message-create');
    form.attr('data-action', 'create');
    input.val('');
    $('#message-id').remove();
    $(this).remove();
});

$(document).on('click', 'body #update-message', function () {
    let form = $('body #message-form');
    let input = $('body #message-message');
    if (form.attr('data-action') === 'update') {
        let parentDiv = $(this).parent().parent();
        input.val(parentDiv.find('.text-message').html());
        $('#message-id').val($(this).attr('data-id'));
    } else {
        let buttonCancel = document.createElement('button');
        buttonCancel.className = 'btn btn-danger';
        buttonCancel.innerHTML = 'Отмена';
        buttonCancel.id = 'cancel-edit';
        let inputID = document.createElement('input');
        inputID.type = 'hidden';
        inputID.value = $(this).attr('data-id');
        inputID.name = 'Message[id]';
        inputID.id = 'message-id';
        form.append(inputID);
        $('body #button-message').append(buttonCancel);
        let parentDiv = $(this).parent().parent();
        input.val(parentDiv.find('.text-message').html());
        form.attr('data-action', 'update');
        form.attr('action', $(this).attr('href'));
    }
    return false;
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

$(document).on('keydown', 'body #message-message', function (e) {
    if (e.keyCode === 13) {
        $('body #button-submit').click();
        return false;
    }
});

$('body').on('hidden.bs.modal', '.modal', function () {
    $(this).removeData('bs.modal');
});


$(document).on('click', '#link', function () {

    $('.modal').modal('show');
    return false;
})

$('body').on('show.bs.modal', '.modal', function () {

});