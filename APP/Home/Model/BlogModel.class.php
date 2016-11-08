<?php

namespace Home\Model;
use Think\Model;

class BlogModel extends Model{

    function class_list($lid=null){
        $class = M('Class')->where("class_type = 0 and class_lid=$lid")->order('class_ord')->select();
        return $class;
    }

}
