<?php
namespace Common\Util;
use Think\Controller;
class AdminController extends Controller
{
	function __construct()
	{
		//首先调用父类construct方法
		parent::__construct();
		$session_id = session('user_id');
		if($session_id != 1){
			redirect(U('Login/index'));
		}
	}
}
	/*	$now_ca= CONTROLLER_NAME."-".ACTION_NAME ;
       
        if (!empty($session_id)){
        	$sql="select role_ac from tp_manager
		join tp_role on manager_rid = role_id where manager_id = $session_id ";
        }else {
		    $sql="select role_ac from tp_manager
	    join tp_role on manager_rid = role_id where manager_id is null";
        }
		$row=D()->query($sql);
	//	var_dump($row);
		$role_ca=$row[0]['role_ac'];
    	$rolell_ca=array('Index-index','Index-right','Index-left','Index-head','Manager-login','Manager-logout');

      if (!in_array($now_ca,$rolell_ca) && $session_id != 1 && strpos($role_ca,$now_ca)===false){	 
      	 // session('manager_id',null);
      	  //echo "没有用户权限";
    	  $this->error('此用户没有访问权限，请重新登陆',__APP__.'/login');
         }//自动跳转到指定路由，与$this->success不同于不倒计时！
    //  }else{
      	//$this->success('请重新登陆访问！',__APP__.'/Manager/login');
      	//session('manager_id','l');
      //	$this->redirect('Manager/login');    //自动跳转到指定路由，与$this->success不同于不倒计时！
     // }
	}
  }

*/
