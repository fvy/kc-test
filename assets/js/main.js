$(function () {
    $('#sandbox-container .input-daterange').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('[data-toggle="tooltip"]').tooltip({
            html: true,
            trigger: 'hover focus',
/*            delay: { "show": 300, "hide": 0 },*/
            template: '<div class="tooltip">' +
                '<div class="tooltip-arrow"></div>' +
                '<div class="tooltip-head"><h3><span class="glyphicon glyphicon-info-sign"></span>Описание пользователя</h3></div>' +
                '<div class="tooltip-inner"></div>' +
                '</div>'
        }
    )

    $('[data-toggle="popover-hover"]').popover({
        html: true,
        trigger: 'hover',
        placement: 'top'
    });
});