<?php

namespace Home\Controller;

use Home\Controller\HomeController;

class IndexController extends HomeController {
    
    
    

    public function index() {
        
        $this->display();
    }
    
    public function config(){
        
        $this->display();
    }

    //公众号信息表
    public function addMsnmodel() {
        if (empty($_POST['appid'])) {
            $data['status'] = 2;
            $data['info'] = 'APPID不能为空';
            $this->ajaxReturn($data);
        }
        if (empty($_POST['appsecret'])) {
            $data['status'] = 2;
            $data['info'] = 'APPSECRET不能为空';
            $this->ajaxReturn($data);
        }
        if (empty($_POST['msnmodel'])) {
            $data['status'] = 2;
            $data['info'] = '模板消息不能为空';
            $this->ajaxReturn($data);
        }
        $add = array();
        $add['appid'] = $_POST['appid'];
        $add['appsecret'] = $_POST['appsecret'];
        $add['msnmodel'] = $_POST['msnmodel'];
        $add['time'] = time();
        if (M('config')->add($add)) {
            $data['status'] = 1;
            $data['info'] = '提交成功';
            $this->ajaxReturn($data);
        } else {
            $data['status'] = 2;
            $data['info'] = '服务器繁忙，请稍后重试';
            $this->ajaxReturn($data);
        }
    }

}
