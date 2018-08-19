<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="/Public/js/jquery-2.1.1.min.js"></script>
        <script src="/Public/js/base.js"></script>
        <script type="text/javascript" src="/Public/js/layer/layer.js"></script>
        <script src="/Public/js/jquery.validate.min.js"></script>
        <script src="/Public/js/messages_zh.min.js"></script>
    </head>
    <body>
        <form method="post" id="config" action="<?php echo U('Index/addMsnmodel');?>" jump-url="<?php echo U('Index/index');?>">
            <ul class="login">
                <li><labe>APPID：</label><input type="text" class="" value="" name="appid"></li>
                    <li><label>APPSECERT：</label><input class="" name="appsecret" id=""></li>
                    <li><label>模板消息ID：</label><input class="" name="msnmodel" id=""></li>
                    <li style="margin-bottom:15px;"><label>&nbsp;</label><input type="submit" value="提交" class="tijiao" style="border:0;"></li>
            </ul>
        </form>
        <script>
            $("#config").validate({
                rules: {
                    appid: {
                        required: true
                    },
                    appsecret: {
                        required: true
                    },
                    msnmodel: {
                        required: true
                    }
                },
                messages: {
                    appid: {
                        required: 'APPID不能为空',
                    },
                    appsecret: {
                        required: 'APPSECRET不能为空'
                    },
                    msnmodel: {
                        required: '模板消息不能为空'
                    }
                },
                submitHandler: function (form) {
                    ajax_submit_form(form)
                    return false;
                },
                invalidHandler: function () {  //不通过回调
                    return false;
                }
            });
        </script>
    </body>
</html>