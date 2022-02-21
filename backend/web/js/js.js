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


$(document).on('click', '#link-modal', function () {
    let yiiform = $('body #modal-w1');
    let action = 'application/set-state?id=' + $(this).attr('data-id');
    let status = parseInt($(this).attr('data-status'));
    let access = $(this).attr('data-user-access');
    yiiform.attr('action', action);
    let buttonNext = $('body #modal-w1 #next');
    let buttonBack = $('body #modal-w1 #back');
    let userNow = $(this).attr('data-user-now');
    let userApp = $(this).attr('data-user');
    if (access === 'manager' || access === 'admin') {
        switch (status) {
            case 1:
                buttonBack.remove();
                buttonNext.html('В работу');
                break;
            case 2:
                buttonBack.remove();
                buttonNext.html('Завершить');
                break;
            case 3:
                if (userNow === userApp) {
                    buttonNext.html('Завершить');
                }
                break;
        }
    } else if (access === 'user' && status === 3) {
        buttonNext.html('Закрыть');
    }
    $('.modal').modal('show');
    return false;
})

$(document).on('submit', 'body #modal-w1', function () {
    let yiiform = $('body #modal-w1');
    // отправляем данные на сервер
    $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray()
        }
    )
        .done(function (data) {
            let tr = $('.table-application tr[data-key="' + data.id + '"]');
            tr.children()[2].innerHTML = data.html;
            let alltd = tr.children();
            alltd.each(function (index) {
                if (index === 5) {
                    let link = $(this).find('a');
                    let newStatus = parseInt(link.attr('data-status')) + 1;
                    link.attr('data-status', newStatus.toString());
                    if (newStatus === 3 && link.attr('data-user-now') !== link.attr('data-user')) {
                        link.remove();
                    }
                }
            });
            $('.modal').modal('hide');
            yiiform.children('#log-comment').val('');
        })
        .fail(function () {
            // не удалось выполнить запрос к серверу
        })
    return false;
});
if (window.location.pathname === '/' || window.location.pathname === '/site/index') {
    let path = '';
    if(window.location.pathname === '/') path = '/site/';
    $.ajax({
        type: 'GET',
        url: path + 'get-stat-users',
    }).done(function (data) {
        Highcharts.chart('chart-user', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Статистика пользователей'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category',
            },
            yAxis: {
                title: {
                    text: 'Общее количество пользователей'
                },
                max: data.all
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
            },
            series: [
                {
                    name: "Группа пользователей",
                    colorByPoint: true,
                    data: data.data
                }
            ]
        });
    }).fail(function () {
        // не удалось выполнить запрос к серверу
    });

    $.ajax({
        type: 'GET',
        url: path +'get-analysis-application',
    }).done(function (data) {
        Highcharts.chart('chart-application', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Статистика заявок'
            },
            subtitle: {
                text: 'Нажмите на название категории для перехода к ней. <br/>' +
                    '<strong>Общее количество заявок '+data.all+'</strong>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.count}</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<u>{point.link}</u>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Заявки',
                colorByPoint: true,
                data: data.data
            }]
        });
    }).fail(function () {
        // не удалось выполнить запрос к серверу
    });


    $.ajax({
        type: 'GET',
        url: path +'get-max',
    }).done(function (data) {
        Highcharts.chart('chart-max-work', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Статистика выполнения'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category',
            },
            yAxis: {
                title: {
                    text: 'Заявки'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> выполненых заявок<br/>'
            },
            series: [
                {
                    name: "Пользователь",
                    colorByPoint: true,
                    data: data
                }
            ]
        });
    }).fail(function () {
        // не удалось выполнить запрос к серверу
    });
}