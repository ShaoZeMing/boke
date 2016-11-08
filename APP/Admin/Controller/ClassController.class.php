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
class ClassController extends AdminController {
    function index(){
        $class=D('Class');
        $info=$class->order('class_ord')->select();
       // var_dump($info);
        $lanmu=M('Lanmu');
        $linfo=$lanmu->select();
        $cinfo=array();
        foreach($linfo as $v){
            $cinfo[$v['lanmu_id']]=$v['lanmu_name'];
        }
        $this->assign('cinfo',$cinfo);
        $this->assign("info",$info);
        $this->display();
    }

    function add(){
        $lanmu=D('Lanmu');
        $infol= $lanmu->select();
      //  var_dump($infoc);
        $class=D('Class');

        if(!empty($_POST)){
         //   var_dump($_POST);
            $class -> create();
            if($class->add()){
                $this->success('添加成功！','index');
            }else{
                echo "添加失败".$this->error;
            }
        }

        $this->assign('infol',$infol);

        $this->display();
    }
    //修改分类
    function update($id=''){
        $lanmu=D('Lanmu');
        $infol= $lanmu->select();
        //  var_dump($infoc);
        $class=D('Class');
        if(!empty($id)) {
            $info=$class->find($id);
            if (!empty($_POST)) {
             //   var_dump($_POST);
                $class->create();
                if ($class->save()) {
                    $this->success('修改成功！','index');
                } else {
                    echo "修改失败" . $this->error;
                }
            }
        }
        $this->assign('info',$info);
        $this->assign('infol',$infol);

        $this->display();
    }

//删除
    function delete($id){
        if(!empty($id)) {
            $class = D('Class');
                if ($class->delete($id)) {
                    echo "删除成功！";
                }else{
                    echo "删除失败！";
                }
        }
    }
}