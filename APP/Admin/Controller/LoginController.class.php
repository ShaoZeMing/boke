<?php 
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{
	function index() {
		$verify= new \Think\Verify();

		if (!empty($_POST)){
			if ($verify->check($_POST['verify'])){     //利用tp框架系统方法验证验证码。
				$user=D('User');                    //实例化模型验证方法
				$rst=$user->checkNamePwd($_POST['user_name'],md5($_POST['user_pwd']));  //调用模型内验证方法
				if ($rst===false){
					$cw= '用户名或密码错误！';
				}else{
					//认证成功后设置session;
					//认证成功后设置session;
					session('user_name',$rst['user_name']);
					session('user_ckame',$rst['user_ckame']);
					session('user_id',$rst['user_id']);
					session('user_ip',$rst['user_ip']);
					session('user_time',$rst['user_time']);
					$this->redirect('Index/index');    //自动跳转到指定路由，与$this->success不同于不倒计时！
				}
			}else{
				$cw= "验证码错误！";
			}
		}
		$this->assign('cw',$cw);   //将错误信息传递到模板中
		$this->display();
	}




	//退出登陆
	function  logout(){
		session(null);
		$this->redirect('index');
	}



	function verifyImg(){
		ob_start();
		$config=array(
				'codeSet'   =>  '0123456789',             // 验证码字符集合
				'fontSize'  =>  13,              // 验证码字体大小(px)
				'imageH'    =>  26,               // 验证码图片高度
				'imageW'    =>  100,               // 验证码图片宽度
				'length'    =>  4,               // 验证码位数
				'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
		);
		$verify= new \Think\Verify($config);
		$verify->entry();
	}
}