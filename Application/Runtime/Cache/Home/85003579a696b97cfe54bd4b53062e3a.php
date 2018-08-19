<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
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
        <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

    </head>
    <body>
        <ul>
            <li><a href="" onclick="share()">微信分享</a></li>
        </ul>
        <script>
            function share() {
                var data = "";
                $.ajax({
                    type: "POST",
                    url: "<?php echo U('WeiXin/getTicket');?>",
                    data: {},
                    success: function (msg) {
                        if (msg.signature) {
                            wx(msg);
                        } else {
                            //配置微信信息
                            alert('服务器繁忙，轻稍后重试');
                        }
                    }
                });

            }
            
            function wx(data){
                alert(data.appid);
                wx.config({
                    debug: true, // true:调试时候弹窗
                    appId: data.appid, // 微信appid
                    timestamp: data.timestamp, // 时间戳
                    nonceStr: data.noncestr, // 随机字符串
                    signature: data.signature, // 签名
                    jsApiList: [
                        // 所有要调用的 API 都要加到这个列表中
                        'onMenuShareTimeline', // 分享到朋友圈接口
                        'onMenuShareAppMessage', //  分享到朋友接口
                    ]
                });
                wx.ready(function () {
                    // 微信分享的数据
                    var shareData = {
                        "imgUrl": "", // 分享显示的缩略图地址
                        "link": "sasasasassss", // 分享地址
                        "desc": "这是一个分享", // 分享描述
                        "title": "hello world", // 分享标题
                        success: function () {

                            // 分享成功可以做相应的数据处理

                            alert("分享成功"); 
                        }
                    };
                    wx.onMenuShareTimeline(shareData);
                    wx.onMenuShareAppMessage(shareData);
                });


                wx.error(function (res) {
                    // config信息验证失败会执行error函数，如签名过期导致验证失败，
                    // 具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，
                    //对于SPA可以在这里更新签名。 
                    alert("好像出错了！！");
                });
            }
        </script>
    </body>
</html>