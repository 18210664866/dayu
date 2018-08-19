<?php

namespace Home\Controller;

use Think\Controller;

class HomeController extends Controller {

    //这里这两个参数应该是获取到的，需要修改
    protected $appid;
    protected $appsecret;
    protected $token;

    public function _initialize() {
        $this->token = C('token');
        $this->appid = C('appid');
        $this->appsecret = C('appsecret');
    }

    public function callback() {
        $data = $_REQUEST;
//        \Think\Log::record('haohao|'.json_encode($data));
//        exit();
        //验证签名
        $signature = $data['signature'];
        $echostr = $data['echostr'];
        $timestamp = $data['timestamp'];
        $nonce = $data['nonce'];
        $tmp = array($this->token, $timestamp, $nonce);
        sort($tmp, SORT_STRING);
        $sha1Str = sha1(implode($tmp));
//        \Think\Log::record($sha1Str . "|" . $signature . "|" . $echostr);
        if ($sha1Str == $signature) {
            echo $echostr;
        } else {
            return false;
        }
    }

    //获取对应的appid，appsecert信息
    public function getConfigResult($where) {
        $res = M('config')->where($where)->find();
        return $res;
    }

    //获取对应的会员信息
    public function getUserResult($where) {
        $res = M('user')->where($where)->find();
        return $res;
    }

    //该公共方法获取和全局缓存基本接口需要使用的access_token(该access_token为基本接口使用的access_token)
    public function getAccessToken() {
        //将access_token全局缓存在文件中,每次获取的时候,先判断是否过期,如果过期重新获取再全局缓存
        //缓存在文件中的数据，包括access_token和该access_token的过期时间戳.
        //获取缓存的access_token
        $access_token_data = json_decode(F('access_token'), true);
        //判断缓存的access_token是否存在和过期，如果不存在和过期则重新获取.
        if ($access_token_data !== null && $access_token_data['access_token'] && $access_token_data['expires_in'] > time()) {
            return $access_token_data['access_token'];
        } else {
            //重新获取access_token,并全局缓存
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->appsecret;
            $data = $this->curl_get($url);
            if ($data != null && $data['access_token']) {
                //设置access_token的过期时间,有效期是7200s
                $data['expires_in'] = $data['expires_in'] + time();
                //将access_token全局缓存，快速缓存到文件中.
                F('access_token', json_encode($data));
                //返回access_token
                return $data['access_token'];
            } else {
                exit('微信获取access_token失败');
            }
        }
    }

    //获取jsapi_ticket，每次获取的时候,先判断是否过期,如果过期重新获取再全局缓存
    public function getJsapiTicket($access_token) {
        $ticket_data = json_decode(F('ticket'), true);
        //判断缓存的ticket是否存在和过期，如果不存在和过期则重新获取.
        if ($ticket_data !== null && $ticket_data['ticket'] && $ticket_data['expires_in'] > time()) {
            return $ticket_data['ticket'];
        } else {
            //重新获取ticket,并全局缓存
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=" . $access_token;
            $data = $this->curl_get($url);
            if ($data != null && $data['ticket']) {
                //设置ticket的过期时间,有效期是7200s
                $data['expires_in'] = $data['expires_in'] + time();
                //将ticket全局缓存，快速缓存到文件中.
                F('ticket', json_encode($data));
                //返回access_token
                return $data['ticket'];
            } else {
                exit('微信获取access_token失败');
            }
        }
    }

    //curl使用post方式请求url,参数为$arr是post方式传送的数据,为数组类型,$url为需要请求的url
    public function curl_post($arr, $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    //curl使用get方式请求url
    public function curl_get($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output, true);
        return $data;
    }

}
