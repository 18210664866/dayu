<?php

namespace Home\Controller;

header('content-type:text/html;charset=utf-8');

use Home\Controller\HomeController;

/*
 * 发送模版消息(这只是其中一个，在不同场景下调用不同模板)
 */

class MessageController extends HomeController {

    //发送模版消息
    public function sendTemplateMessage() {
        //接受模板消息的用户openid
        $res = $this->getUserResult(array('uid' => $_SESSION['uid']));
//         \Think\Log::record('haohao|'.json_encode($res));
        //获取access_token，该access_token为基本接口使用的access_token
        $access_token_arr = $this->getAccessToken();
        //设置模板消息
        $template = array(
            'touser' => $res['openid'], //接收模板消息的用户openid
            'template_id' => C('MODEL_ID'), //模板消息的id
            'topcolor' => "#7B68EE",
            'data' => array(
                'first' => array('value' => urlencode("购买成功通知"), 'color' => "#DD5044"),
                'keynote1' => array('value' => urlencode("巧克力"), 'color' => '#333'),
                'keynote2' => array('value' => urlencode("39.8元"), 'color' => '#333'),
                'keynote3' => array('value' => urlencode("2018年8月19日"), 'color' => '#333'),
                'remark' => array('value' => urlencode('欢迎再次够买'), 'color' => '#DD5044'),
            )
        );
        $addMsgmodel = $this->addMessage($template);
        $template['url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/Home/Message/message?mid=' . $addMsgmodel; //设置点击模板消息跳转的url
        $json_template=json_encode($template);
        //调用公共方法curl_post，发送模板消息
        $curlPost = $this->curl_post(urldecode($json_template), 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token_arr);
//        \Think\Log::record('haohao|'.json_encode($curlPost));
        exit('发送成功');
    }

    //把发送的消息存到数据库
    public function addMessage($array) {
        $add = array();
        $add['touser'] = $array['touser'];
        $add['msnid'] = $array['template_id'];
        $add['message'] = json_encode($array['data']);
        $add['addtime'] = time();
        return M('message')->add($add);
    }

    //展示消息详情页面，修改消息的状态
    public function message() {
        $where = $save = array();
        $where['mid'] = $_REQUEST['mid'];
        $message = M('message')->where($where)->find();
        $save['status'] = 1;
        $save['edittime'] = time();
        M('message')->where($where)->save($save);
        $message_data = json_decode($message['message'],true);
        $data = array();
        foreach ($message_data as $key => $value) {
            $data[] = urldecode($value['value']);
        }
        $this->assign('data',$data);
        $this->display();
    }

}
