<?php
/**
 * Created by PhpStorm.
 * User: 4d4k
 * Date: 2016/5/19
 * Time: 14:20
 */
namespace Admin\Controller;
use  Common\Util\AdminController;
class BlogController extends  AdminController{
    function blog(){
        $blog=D('Blog');
        $inf=$blog->where("blog_type = 0 and blog_cid != 12")->select();
        $count=count($inf);
        $page=new \Common\Util\page($count,10,5);
        $sql = "select * from bk_blog where blog_type=0 AND blog_cid !=12 ORDER BY blog_time DESC {$page->limit()}";
        $info=$blog->query($sql);
        $join=M('User')->select();
        $uinfo=array();
        foreach ($join as $k=>$v){
            $uinfo[$v['user_id']] = $v['user_ckame'];   //将查询的用户id转换为名字
        }
        $cjoin=M('Class')->select();
        $cinfo=array();
        foreach ($cjoin as $k=>$v){
            $cinfo[$v['class_id']] = $v['class_name'];   //将查询的二维数组转换成一维对应的数组如：array(1 =>经理 ，2=>主管)
        }
        $p=$page->show(4);
        $this->assign('cinfo',$cinfo);
        $this->assign('uinfo',$uinfo);
        $this->assign('p',$p);
        $this->assign('info',$info);
        $this->display();
    }

//添加文章
    function add()
    {
        $class = D('Class');
        $infoc = $class->select();
        $blog = D('Blog');
        if (!empty($_POST)) {
            if (!empty($_POST['blog_cid'])) {
                // var_dump($_POST);
                $_POST['blog_logo'] = $this->small_img($_POST);//调用生成浓缩图方法，并将路径赋值到$_POST之中，插入数据库。
                $_POST['blog_time'] = time();
                $_POST['blog_uid'] = session('user_id');
                $blog->create();
                if ($blog->add()) {
                    echo "上传成功";
                } else {
                    echo "上传失败！";
                }
            } else {
                echo "文章分类不能为空！";
            }

        }
        $this->assign('infoc', $infoc);
        $this->display();
    }

    //说说列表
    function sayShow(){
        $blog=D('Blog');
        $inf=$blog->where("blog_type = 0 and blog_cid = 12")->select();
        $count=count($inf);
        $page=new \Common\Util\page($count,10,5);
        $sql = "select * from bk_blog where blog_type=0 AND blog_cid =12 ORDER BY blog_time DESC {$page->limit()}";
        $info=$blog->query($sql);
        foreach($info as $k => $v){
            $info[$k]['blog_content'] = mb_strcut(strip_tags(htmlspecialchars_decode($v['blog_content'])),0,100).'....';
        }

        $cjoin=M('Class')->select();
        $cinfo=array();
        foreach ($cjoin as $k=>$v){
            $cinfo[$v['class_id']] = $v['class_name'];   //将查询的二维数组转换成一维对应的数组如：array(1 =>经理 ，2=>主管)
        }
        $p=$page->show(4);
        $this->assign('cinfo',$cinfo);
        $this->assign('p',$p);
        $this->assign('info',$info);
        $this->display();

    }

    //添加说说
    function  addSay(){
        if (!empty($_POST)) {
            $blog = D('Blog');
            // var_dump($_POST);
                $_POST['blog_logo'] = $this->small_img($_POST);//调用生成浓缩图方法，并将路径赋值到$_POST之中，插入数据库。
                $_POST['blog_time'] = time();
                $_POST['blog_uid'] = session('user_id');
                $_POST['blog_cid'] = 12;
                $blog->create();
                if ($blog->add()) {
                    redirect(U('Blog/blog'),0.1, "<script> alert('添加成功！')</script>");
                } else {
                    echo "<script> alert('添加失败！')</script>";
                }
            }

        $this->display();

    }

    //修改文章
    function  update($id){
        $blog=D('Blog');
        $class=D('Class');
        $infoc = $class->select();
        $info=$blog->find($id);
       // var_dump($info);

        if(!empty($_POST)){
            $_POST['blog_logo'] = $this->small_img($_POST);//调用生成浓缩图方法，并将路径赋值到$_POST之中，插入数据库。
        //   var_dump($_POST);
            $blog->create();
            if($blog->save()){
//                echo "<script> alert('修改成功！')</script>";
                redirect(U('Blog/blog'),0.1, "<script> alert('修改成功！')</script>");
            }else{
                echo "<script> alert('修改失败！')</script>";
            }
        }
        $this->assign('info',$info);
        $this->assign('infoc',$infoc);
        $this->display();
    }

    function  updateSay($id){
        $blog=D('Blog');
        $info=$blog->find($id);
        if(!empty($_POST)){
            $_POST['blog_logo'] = $this->small_img($_POST);//调用生成浓缩图方法，并将路径赋值到$_POST之中，插入数据库。
            //   var_dump($_POST);
            $blog->create();
            if($blog->save()){
//                echo "<script> alert('修改成功！')</script>";
                redirect(U('Blog/blog'),0.1, "<script> alert('修改成功！')</script>");
            }else{
                echo "<script> alert('修改失败！')</script>";
            }
        }
        $this->assign('info',$info);
        $this->display();
    }


//删除文章方法，其实是加入回收站；
    function  del($id){
        if(!empty($id)){
            $blog=D('Blog');
            //测试代码。
         /*   $sr=$blog->find($id);
            $content=$sr['blog_content'];
            $str = htmlspecialchars_decode($content);   //反转译
            $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
            preg_match_all($pattern, $str, $match);       //正则表达式识别字符串中的img url链接
            $fall='.'.$match[1][0];
            if(unlink($fall)){
             echo '删除成功！='.$fall;
            }else{
                echo '删除失败=='.$fall;
            }
            echo '<br>'.substr(strrchr($fall,'/'),1);
            echo '<br>'.substr($fall,0,strrpos($match[1][0],'/'));
        dump( $match);*/

            $arr[ 'blog_type']=1;
            $arr['blog_id']=$id;
            if($blog->save($arr)){
                $this->redirect('blog');
            }else{
                echo "<script> alert('删除失败！')</script>";
            }
        }
    }


    //恢复回收站数据
    function restore($id){
        if(!empty($id)){
            $blog=D('Blog');
            $arr=array(
                'blog_id' => $id,
                'blog_type' => 0
            );
            if($blog->save($arr)){
                $this->redirect('dump');
            }else{
                echo "<script> alert('恢复失败！')</script>";
            }
        }
    }

    //回收站方法
    function dump($id=''){
        $blog=D('Blog');
        $inf=$blog->where("blog_type = 1")->select();
        $count=count($inf);
        $page=new \Common\Util\page($count,10,5);
        $sql="select * from bk_blog where blog_type=1 ORDER BY blog_time DESC {$page->limit()}";
        $info=$blog->query($sql);
        $join=M('User')->select();
        $uinfo=array();
        foreach ($join as $k=>$v){
            $uinfo[$v['user_id']] = $v['user_ckame'];   //将查询的二维数组转换成一维对应的数组如：array(1 =>经理 ，2=>主管)
        }
        $cjoin=M('Class')->select();
        $cinfo=array();
        foreach ($cjoin as $k=>$v){
            $cinfo[$v['class_id']] = $v['class_name'];   //将查询的二维数组转换成一维对应的数组如：array(1 =>经理 ，2=>主管)
        }
        $p=$page->show(4);                              //分页页码


        if ($id != "row") {
            $post = $blog->find($id);                //单篇文章查询
            $this->del_img($post['blog_content']);   //利用删除方法删除文章对应文件
            if ($blog->delete($id)) {                //删除对应文件
               $this->redirect('dump');              //跳转回收站
            }
        }else {
            $rows = $blog->where('blog_type = 1')->select();   //清空回收站查询
            foreach ($rows as $k => $v) {             //遍历多条文章数据
                $this->del_img($v['blog_content']);   //循环调用删除方法删除文件相关图片
            }
            if ($blog->where('blog_type = 1')->delete()){ //清空回收站数据
                $this->redirect('dump');                  //跳转
            }
        }


        $this->assign('cinfo',$cinfo);
        $this->assign('uinfo',$uinfo);
        $this->assign('p',$p);
        $this->assign('info',$info);
        $this->display();

    }


    //删除文章对应图像文件方法
    function  del_img($content){
        $str = htmlspecialchars_decode($content);   //反转译
        $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern, $str, $match);       //正则表达式识别字符串中的img url链接
//        dump( $match);

        if (!empty($match[1])) {
            for ($i = 0; $i < count($match[1]); $i++) {       //循环数组url
                $file = '.'.$match[1][$i];       //截取图片文件url
                $file_dir=substr($file,0,strrpos($file,'/')).'/';                //截取图片对应目录url
                if (is_file($file)) {
                    unlink($file);                            //删除图片文件
                }
                if(is_dir($file_dir)){
                    if($this->is_empty_dir($file_dir)==2){    //调用方法查看目录是否为空
                        rmdir($file_dir);                     //删除目录
                    }
                }
            }
        }
    }


    //判断文件目录是否为空方法
    function is_empty_dir($fp){
        $H = @opendir($fp);                     //打开目录
        $i = 0;
        while ($_file = readdir($H)) {          //遍历目录内文件
            $i++;
        }
        closedir($H);                          //关闭目录
        if ($i > 2) {
            return 1;                          //返回 1 代表目录非空
        } else {
            return 2;                          //返回 2 代表目录空
        }
    }





    //识别提交内容中是否包含图片链接，并将图片生成浓缩图保存在指定文件下
    function small_img($post){
        if(!empty($post)) {
            $str = $post['blog_content'];
            $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
            preg_match_all($pattern, $str, $match);                                    //正则表达式识别字符串中的img url链接
            if (!empty($match[1][0])) {
                $arr = explode('/', $match['1']['0']);//  拆分链接
                $url =  __ROOT__."/APP/Public/upload/images/" . $arr[5] . '/' . $arr[6];         //图片文件
                //注意：url地址一定要针对入口文件来配对，否则错误，

//                $filename = $arr[7];       //文件名称
//                $image = new \Think\Image();
//                $imageurl = $url;     //从根目录的文件路径
//                $image->open($imageurl);
//                $image->thumb(180, 150);
//                $smallfileurl = "./APP/Public/upload/images/" . $arr[6] . "/small_" . $filename;      //浓缩图保存路径
//                $image->save($smallfileurl);
                return $url;                                                //将浓缩图路径赋值到$_POST之中，插入数据库。
            }else{
                $smallfileurl = __ROOT__."/APP/Public/upload/images/demo.jpg";                   //无浓缩图保存默认图片路径
                return $smallfileurl;
            }

        }
    }

}