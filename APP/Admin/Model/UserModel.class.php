<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model{
	
	function checkNamePwd($name,$pw)
	{
		//$this->getBy表字段(查询的条件)、、//tp封装的一个查询方法
		$info = $this->getByUser_name($name); //查询数据库表user里user_name字段里面有没有$name

		if ($info != null) {
			if ($info['user_pwd'] != $pw) {
				return false;
			} else {

				$arr = array(
						'user_id' => $info['user_id'],
						'user_ip' => get_client_ip()

				);
				$this->save($arr);


				return $info;

			}
		} else {
			return false;
		}
	}

	//查询ip方法
	function getIP()
	{
		global $ip;
		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else $ip = "Unknow";
		return $ip;
	}


		

	

	
// 	function saveManager($post){
		
// 		$post['atime']=time();
		
// 		$da=$this->save($post);
// 		return $da;
// 	}
	
}