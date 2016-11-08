<?php
namespace Admin\Controller;
//use Think\Controller;
use Common\Util\AdminController;
class IndexController extends AdminController {
	
    function index(){
    	$this->display();
    }

    //登陆
    function head() {
    	$this->display();
    }
    
    function left(){
//    	$session=session('manager_id');   //查找session中的用户id
//    	$manager=M('Manager');            //
//    	$auth=M('Auth');
//    //	var_dump(session());
//    	$list_r=$manager->where("manager_id = $session")
//    	->join("tp_role ON manager_rid = role_id ")
//    	->select();
//    //	var_dump($list_r);
//    	$role_auth=$list_r[0]['role_auth'];
//
//    	//判断是否是超级管理员
//    	if($session != 1){
//    		$list_a=$auth->where("auth_level = 0 and auth_id in ($role_auth)")->select();      //查询权限菜单级别为0的主菜单
//    		$list_l=$auth->where("auth_level = 1 and auth_id in ($role_auth)")->select();      //查询权限菜单级别我1的次级菜单
//
//    	}else {
//    		$list_a=$auth->where("auth_level = 0 ")->select();
//    		$list_l=$auth->where("auth_level = 1 ")->select();
//    	}
//
//
//
//    //	var_dump($list_l);
//    	$this->assign('list_a',$list_a);
//    	$this->assign('list_l',$list_l);
//
    	
    	$this->display();
    }
    
    function right(){

// 定义一个函数getIP()
        $ip = get_client_ip();


// var_dump(session());
        $this->assign('ip',$ip);
        $this->display();
    }
}