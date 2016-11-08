<?php
/**
 * Created by PhpStorm.
 * User: 4d4k
 * Date: 2016/5/22
 * Time: 11:43
 */
namespace Admin\Controller;
//use Think\Controller;
use Common\Util\AdminController;
class LanmuController extends AdminController {
    function index(){
        $lanmu=M('Lanmu');
        $info=$lanmu->order('lanmu_ord')->select();
        $this->assign("info",$info);
        $this->display();
    }

    function add(){
        $lanmu=D('Lanmu');
        if(!empty($_POST)){
            var_dump($_POST);
            $lanmu-> create();
            if($lanmu->add()){
                echo "添加成功！";
            }else{
                echo "添加失败".$this->error;
            }
        }
        $this->display();
    }
    //修改分类
    function update($id=''){
        $lanmu=D('Lanmu');
        if(!empty($id)) {
            $info=$lanmu->find($id);
            if (!empty($_POST)) {
                //var_dump($_POST);
                $lanmu->create();
                if ($lanmu->save()) {
                    $this->redirect('index');
                } else {
                    echo "修改失败" . $this->error;
                }
            }
        }
        $this->assign('info',$info);
        $this->display();
    }
}