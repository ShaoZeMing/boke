<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller{
    function index(){
        $where="blog_type=0";                                                //查询条件
       $page=$this->page($where);                                            //调用page方法得到分页对象
        $info=$this->select($where,$page->limit());                          //调用多表查询方法查询
        $linfo=$this->lanmu_list();                                          //查询栏目
        $now_list=$this->now_list($where);                                   //查询最新数据排行
        $click_list=$this->click_list($where);                               //查询点击访问量排行
        $p = $page->show(4);                                                 //分页页码
        $this->assign('info', $info);
        $this->assign('now', $now_list);
        $this->assign('click', $click_list);
        $this->assign('linfo', $linfo);
        $this->assign('p', $p);
       $this->display();
    }


//前端开发||后端开发
    function lists($id){
        $where="blog_type=0 and class_lid=$id";                             //查询条件
        $page=$this->page($where);                                          //调用page方法得到分页对象
        $info=$this->select($where,$page->limit());                         //调用多表查询方法查询
        $p = $page->show(4);                                                //分页页码
        $linfo=$this->lanmu_list();                                         //查询栏目
        $now_list=$this->now_list($where);                                  //查询最新数据排行
        $click_list=$this->click_list($where);                              //查询点击访问量排行
        $class=$this->class_list($id);                                      //利用方法查询对应分类列表
        $this->assign('class',$class);
        $this->assign('info', $info);
        $this->assign('now', $now_list);
        $this->assign('click', $click_list);
        $this->assign('linfo', $linfo);
        $this->assign('p', $p);
        $this->display();
    }



//游戏人间
    function  game($id){
        $where="blog_type=0 and class_lid=$id";                              //查询条件
        $page=$this->page($where);                                           //调用page方法得到分页对象
        $info=$this->select($where,$page->limit());                          //调用多表查询方法查询
        $p = $page->show(4);                                                 //分页页码
        $linfo=$this->lanmu_list();                                          //查询栏目
        $now_list=$this->now_list($where);                                   //查询最新数据排行
        $click_list=$this->click_list($where);                               //查询点击访问量排行
        $class=$this->class_list($id);                                      //利用方法查询对应分类列表
        $this->assign('class',$class);
        $this->assign('info', $info);
        $this->assign('now', $now_list);
        $this->assign('click', $click_list);
        $this->assign('linfo', $linfo);
        $this->assign('p', $p);
        $this->assign('num',"1");
        $this->display();
    }

 //相册
    function  photo($id=null){
        $where="blog_type=0 and class_lid=$id";                              //查询条件
        $page=$this->page($where);                                           //调用page方法得到分页对象
        $info=$this->select($where,$page->limit());                          //调用多表查询方法查询
        $linfo=$this->lanmu_list();                                          //查询栏目
        $now_list=$this->now_list($where);                                   //查询最新数据排行
        $click_list=$this->click_list($where);                               //查询点击访问量排行
        $p = $page->show(4);                                                 //分页页码
        $class=$this->class_list($id);                                      //利用方法查询对应分类列表
        $this->assign('class',$class);
        $this->assign('info', $info);
        $this->assign('now', $now_list);
        $this->assign('click', $click_list);
        $this->assign('linfo', $linfo);
        $this->assign('p', $p);
        $this->display();
    }

//关于我
    function  myself(){

        $linfo=$this->lanmu_list();
        $this->assign('linfo', $linfo);
        $this->display();
    }

    //碎言碎语
   function moodlist(){
       $linfo=$this->lanmu_list();
       $this->assign('linfo', $linfo);

       $this->display();
   }

//留言板
    function  message(){

        $linfo=$this->lanmu_list();
        $this->assign('linfo', $linfo);

        $this->display();
    }





    function read($id=null){
        if(!empty($id)){
            $b=D('Blog');
            $blog=$b->join('bk_user ON bk_blog.blog_uid = bk_user.user_id')
                ->join('bk_class ON bk_blog.blog_cid = bk_class.class_id')
                ->join('bk_lanmu ON bk_class.class_lid = bk_lanmu.lanmu_id')
                ->find($id);
            $blog['blog_content']=htmlspecialchars_decode($blog['blog_content']);   //反转译
            $click["blog_id"]=$id;
            $click["blog_click"] = $blog['blog_click'] + 1;
            $b->save($click);
            $linfo=$this->lanmu_list();
            $now_list=$this->now_list();
            $click_list=$this->click_list();
            $class= D('Class')->where("class_lid = {$blog['class_lid']} ")->select();
            $blog_next=$b->find($id+1);
            $blog_pre=$b->find($id-1);
        }
        $this->assign('blog_pre',$blog_pre);
        $this->assign('blog_next',$blog_next);
        $this->assign('now', $now_list);
        $this->assign('click', $click_list);
        $this->assign('blog',$blog);
        $this->assign('class',$class);
        $this->assign('linfo', $linfo);
        $this->display();
    }

    //最新文章排序
    function now_list($where){
        $now_list=D('Blog')->join('bk_class ON bk_blog.blog_cid = bk_class.class_id')
            ->where($where)->limit("0,9")->select();
        return $now_list;

    }
 //最热文章排序
    function click_list($where){
        $click_list=D('Blog')->join('bk_class ON bk_blog.blog_cid = bk_class.class_id')
            ->where($where)->limit("0,5")->select();
        return $click_list;
    }
 //栏目排序查询
    function lanmu_list(){
        $lanmu = M('Lanmu')->where('lanmu_type= 0')->order('lanmu_ord')->select();
        return $lanmu;
    }
//分类排序查询
    function class_list($lid=null){
        $class = M('Class')->where("class_type = 0 and class_lid=$lid")->order('class_ord')->select();
        return $class;
    }
//查询数据方法
    function select($where,$limit){
        $blog = D('Blog');
        $sql="select * from  bk_blog
             JOIN  bk_user ON bk_blog.blog_uid = bk_user.user_id
             JOIN  bk_class ON bk_blog.blog_cid = bk_class.class_id
             where {$where} ORDER BY blog_time DESC {$limit}";
        $info = $blog->query($sql);
        //遍历数据，并将数据博文反转译输出
        foreach($info as $k => $v){
            $str = htmlspecialchars_decode($info[$k]["blog_content"]);   //反转译
            $info[$k]["blog_content"] = mb_strcut($str,0,340) ."·····";   //截取字符串
        }
        return $info;
    }

    //查询总数方法
    function page($where){
        $blog = D('Blog');
        $inf = $blog
            ->join('bk_class ON bk_blog.blog_cid = bk_class.class_id')
            ->where($where)->select();                                       //查询数据总数
        $count = count($inf);

        $page = new \Common\Util\page($count, 6, 5);
        return $page;
    }

}