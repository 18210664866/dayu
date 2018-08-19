// JavaScript Document
//ajax提交表单并刷新本页面
function ajax_submit_form(form) {
    var index = '';
    $.ajax({
        type: $(form).attr("method"),
        url: $(form).attr("action"),
        async: false,
        data: $(form).serialize(),
        beforeSend: function () {
            index = layer.msg('正在提交请稍后');
        },
        success: function (msg) {
            layer.msg(msg.info);
            if (msg.status == 1) {
                layer.msg(msg.info);
                var url = $(form).attr("jump-url");
                if (url) {
                    setTimeout(function () {
                        window.location.href = url;
                    }, 1500);
                } else {
                    window.location.reload();
                }
            } else {
                layer.msg(msg.info);
                layer.close(index);
                //window.location.reload();
            }
        }
    });
    return false;
}



