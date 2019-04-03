$(function () {
    $('#sandbox-container .input-daterange').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('[data-toggle="tooltip"]').tooltip({
            html: true,
            template: '<div class="tooltip">' +
                '<div class="tooltip-arrow"></div>' +
                '<div class="tooltip-head"><h3><span class="glyphicon glyphicon-info-sign"></span>Описание</h3></div>' +
                '<div class="tooltip-inner"></div>' +
                '</div>'
        }
    )
});