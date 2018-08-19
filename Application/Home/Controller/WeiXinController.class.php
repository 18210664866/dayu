<?php
namespace Home\Controller;
header('content-type:text/html;charset=utf-8');

use Home\Controller\HomeController;

/*
 * 微信操作
 */

class WeiXinController extends HomeController {
    
    //用户授权获取code
    public function index() {
        //用户同意授权后回调的网址.必须使用url对回调网址进行编码，我们也将授权完跳转对网址,
        $redirect_uri = urlencode('http://' . $_SERVER['HTTP_HOST'] . '/Home/WeiXin/callback');
        header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='
                . $this->appid . '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=snsapi_userinfo&state=state' .
                '#wechat_redirect');
    }

    /*
     * 用户授权跳转到回调网址后，根据获取到code换取网页授权access_token,
     * 获取网页授权access_token和openid获取用户的基本信息，保存在数据库中
     */
    public function callback() {
        //获取到的code
        $code = $_REQUEST['code'];
        //获取access_token和openid
        $url_token = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->appid . '&secret=' . $this->appsecret . '&code=' . $code . '&grant_type=authorization_code ';
        $data = $this->curl_get($url_token);
        //如果获取成功，根据access_token和openid获取用户的基本信息
        if ($data != null && $data['access_token']) {
            //获取用户的基本信息
            $url_user = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $data['access_token'] . '&openid=' . $data['openid'] . '&lang=zh_CN';
            $user_data = $this->curl_get($url_user);
            \Think\Log::record('haohao|'.json_encode($user_data));
            if ($user_data != null && $user_data['openid']) {
                $model = M('user');
                //先判断用户数据是不是已经存储了
                $user_id = $model->where(['openid' => $user_data['openid']])->getField('uid');
                if ($user_id) {
                    session('uid', $user_id);
                } else {
                    $array = array();
                    $array['openid'] = $user_data['openid'];
                    $array['nickname'] = $user_data['nickname'];
                    $array['headimgurl'] = $user_data['headimgurl'];
                    $array['time'] = time();
                    $user_id = $model->add($array);
                    //将用户在数据库中的唯一表示保存在session中
                    session('uid', $user_id);
                }
                //跳转网页,这里需要一个变量（如果从登录页进来，变量为主页地址，如果从其他页面进来，变量为进入前的页面地址）
                redirect('http://' . $_SERVER['HTTP_HOST'] . '/Home/WeiXin/accredit');
            } else {
                exit('获取用户信息失败！');
            }
        } else {
            exit('微信授权失败');
        }
    }
   
    //授权成功跳转页面
    public function accredit(){
        $where = array();
        $where['uid'] = $_SESSION['uid'];
        $user_data = $this->getUserResult($where);
        $this->assign('user_data', $user_data);
        $this->display();
    }
    
    //微信分享页面
    public function share(){
        
        $this->display();
    }
    
    //根据JS-SDK的签名算法生成签名串，把需要的参数返回前端页面
    public function getTicket(){
        //需要返回前端的数组
        $data = array();
        $data['appid'] = $this->appid;
        //先获取access_token，通过access_token才能获取ticket
        $token = $this->getAccessToken();
        //获取jsapi_ticket
        $data['ticket'] = $this->getJsapiTicket($token);
        //获取随机字符串
        $data['noncestr'] = $this->createNonceStr();
        //获取当前页面的URL地址
        $url = $_SERVER['REQUEST_URI'];
        //获取当前时间戳
        $data['timestamp'] = time();
        //生成signature
        $str = "jsapi_ticket=" . $data['ticket'] . "&noncestr=" . $data['noncestr'] . "&timestamp=" . $data['timestamp'] . "&url=" . $url;
        $data['signature'] = sha1($str);
        \Think\Log::record('haohao|'.json_encode($data));
        $this->ajaxReturn($data);
    }
    
    //生成随机字符串
    public function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    

}
