<?php

namespace Manage\Controller;
use Think\Controller;

class PublicController extends Controller {

    public function login($username = null, $password = null, $captcha = null) {
        if(IS_POST) {
            if(!check_captcha($captcha)) {
                $this->error('验证码输入错误！');
            }

            $user = D('User')->login($username, $password);
            if($user['id']) {
                $this->success('登录成功！', U('Index/index'));
            } else {
                $this->error('用户名或密码错误');
            }
        } else {
            if(is_login()){
                $this->redirect('Index/index');
            }else{
                /* 读取数据库中的配置 */
                // $config  =   S('DB_CONFIG_DATA');
                // if(!$config){
                //     $config  =   D('Config')->lists();
                //     S('DB_CONFIG_DATA',$config);
                // }
                // C($config); //添加配置
                
                $this->display();
            }
        }
    }

    public function logout(){
        if(is_login()) {
            D('User')->logout();
            session('[destroy]');
            $this->redirect(U('login'));
        } else {
            $this->redirect('login');
        }
    }


    // 生成登录验证码
    public function captcha() {
        ob_get_clean();
        $v = new \Think\PhpCaptcha(null,120,50);
        $v->UseColour(true);
        $v->SetNumChars(4);
        $v->Create();
    }

}
