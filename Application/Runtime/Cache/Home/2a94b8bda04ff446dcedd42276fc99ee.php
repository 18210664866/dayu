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

        

    </head>
    <body>
        <h3>一、</h3>
        <ul>
            <li><a href="<?php echo U('Index/config');?>">微信配置信息</a></li>
        </ul>

        <h3>二、</h3>
        <ul>
            <li><a href="<?php echo U('WeiXin/index');?>">微信授权登录</a></li>
        </ul>

        <h3>三、</h3>
        <ul>
            <li><a href="<?php echo U('Message/sendTemplateMessage');?>">发送模板消息</a></li>
        </ul>
        
        <h3>五、</h3>
        <ul>
            <li><a href="<?php echo U('WeiXin/share');?>">分享</a></li>
        </ul>
    </body>
</html>