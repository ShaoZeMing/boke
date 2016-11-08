<?php

//后台管理员管理控制器
namespace Admin\Controller;

use  Common\Util\AdminController;

class UserController extends AdminController
{

    //添加管理员
    function  update()
    {
        $user = M('User');
        if (!empty($_POST)) {
            $pwd = md5($_POST['user_pwd']);
            $pwd1 = md5($_POST['user_pwd2']);
			$res = $this->checkUser($pwd);
			if ($res) {
               $data['user_id']=1;
               $data['user_ckame']=$_POST['user_ckame'];
               $data['user_pwd']=$pwd1;
                if ($user->save($data)) {
                    session(null);
                    $this->success('修改成功！请重新登陆', 'Login/index');
                } else {
                    $this->error(' 修改失败！', 'update');

                }
            } else {
                $this->error(' 密码错误，修改失败！', 'update');
            }


		}
        $info = $user->find();
        $this->assign('info', $info);
        $this->display();
    }


    function checkUser($pwd)
    {
        if (empty($pwd)) {
            die('密码不能为空');
        }
        $user = M(user);
        $info = $user->find();
        if ($pwd != $info['user_pwd']) {
            return false;
        } else {
            return true;
        }

    }


}