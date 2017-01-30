(function ($) {

    $.fn.log_list = function () {

        var $element = $(this);

        var nonce = $("#_wpnonce").val(),
            delay = 4000;

        return this.each(function () {

            $(this).on("click", ".delete a, .retry a", function () {

                var $this = $(this),
                    action = $this.parent().hasClass('retry') ? 'retry' : 'delete',
                    $row = $this.parents('tr').first(),
                    $message_container = $row.find('td.column-error_message'),
                    $action_container = $row.find('td.column-actions'),
                    $temp_html = $action_container.html(),
                    id = $this.data('log-id'),
                    log_data = JSON.parse($element.find('#data-' + id).text()),
                    post_data = {
                        action: action === 'delete' ? 'tve_dash_api_delete_log' : 'tve_dash_api_form_retry',
                        nonce: nonce
                    };

                $.extend(post_data, log_data);

                $action_container.html("Loading...");

                var jqxhr = $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: post_data,
                    dataType: 'json'
                });

                jqxhr.fail(function () {
                    alert(TVE_Dash_Const.translations.RequestError);
                });

                jqxhr.done(function (data) {
                    $action_container.html($temp_html);
                    $message_container.html(data.message);

                    if (data.status === 'error') {
                        $row.find("> td").css('background-color', 'pink');
                        setTimeout(function () {
                            $row.find('> td').css({
                                'background-color': ''
                            });
                        }, delay);
                    } else if (data.status === 'success') {
                        $row.find('> td').css('background', 'lightgreen');
                        $action_container.html('');
                        setTimeout(function () {
                            $row.remove();
                        }, delay);
                    } else {
                        $message_container.html('Something went wrong here, please contact Thrive developers team!')
                    }
                });
            });

        });
    };

    $(function () {
        $(".wp-list-table.logs").log_list();
    });

})(jQuery);
