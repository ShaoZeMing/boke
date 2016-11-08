<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	// 是否批处理验证
	protected $patchValidate    =   TRUE;
	protected $_map = array(
			'name'       => 'user_name',
			'email'      => 'user_email',
			'pw'         => 'user_pw',
			'qq'         => 'user_qq',
			'phone'      => 'user_phone',
			'sex'        => 'user_sex',
			'xl'         => 'user_xl',
			'ah'         => 'user_ah',
			'content'    =>'user_content',
			
			
	);
	
	protected $_validate = array(
			array('user_name','require','用户名不能为空！'),
			array('user_name','','此账号已被注册，请注册其他账号！',0,'unique',1),
			array('user_pw','require','密码不能为空！'),
			array('user_pw','6,16','密码长度应为6~16！',0,'length'),
			array('user_pw','pw2','两次密码输入不一致！',0,'confirm'),			
			array('user_email','email','请输入正确的邮箱格式'),
			array('user_phone','require','手机号码不能为空'),
			array('user_phone','/^[1]\d{10}$/','手机号码非法'),
			array('user_qq','/^[1-9]\d{4,10}$/','QQ格式非法',),
	);
	
	protected $_auto = array(
			array('user_pw','md5',3,'function'),
			array('user_intime','time',1,'function')
	);
			
}