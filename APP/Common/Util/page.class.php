<?php
/**
 * Created by PhpStorm.
 * User: 4d4k
 * Date: 2016/5/14
 * Time: 15:02
 */
namespace Common\Util;
class page{
    private $total_row;             //总数
    private $total_page;           //总页数
    private $pages;            //每页显示条数
    private $url;                // url地址调试
    private $page_row;            //显示几个页码
    private $self_page;           //当前页码
    private $a_id;                //每一页开始ID
    private $l_id;                 //每一页结束id
    private $name= array();               //显示的文字信息自定义


 //初始化对象
    public function __construct($count,$page=10,$page_row = 7,$name=''){
        $this->total_row = $count;                                //总数
        $this->pages = $page;                                     //每页显示条数
        $this->total_page = ceil($this->total_row/$this->pages);  //获得总页数
        $this->page_row = $page_row;                            //显示页码数
        $this->self_page = min($this->total_page, max($_GET['page'],1));   //当前页
        $this->a_id = ($this->self_page-1) * $this->pages+1;               //当前页开始id
        $this->l_id = min($this->total_row,$this->self_page * $this->pages); //当前页末尾ID
        $this->url = $this->geturl();                                     //url对象方法
        $this->name =$this->name($name);                                   //自定义文字信息
    }

//自定义文字方法name

    public function  name($name){
        $d=array(
            "pre"=>"<<",
            "next"=>">>",
            "first"=>"首页",
            "end"=>"末页",
            "unit"=>"条"
        );
        if(empty($name) && !is_array($name)){
            return $d;
        }
        function filter($v){
            return !empty($v);
        }
        return array_merge($d,array_filter($name,'filter'));
    }

    //URL调试方法

    public function geturl(){
        //获取url
        $get= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

        $url_arr=parse_url($get);           //拆分url 路径和字符串为数组
        if(isset($url_arr['query'])){
            parse_str($url_arr['query'],$arr);       //拆分url字符为字符串
             unset($arr['page']);                   //删除其中的page元素

            $url = $url_arr['path'].'?'.http_build_query($arr)."&page=";    //合并url
        }else{
            $url = $url_arr['path'].'?page=';                            //合并url
        }
        return $url;
    }

    //limit方法
    public function limit(){
        return "LIMIT ".max(0,($this->self_page - 1 ) * $this->pages).",".$this->pages ;
    }
//    public function limit(){
//        return "LIMIT ".max(0,($this->self_page-1)*$this->onepage_rows).",".$this->onepage_rows;
//    }

    //上一页
    public function pre(){
        return $this->self_page>1 ? "<a href='".$this->url.($this->self_page - 1) ."'>{$this->name['pre']}</a>":'';

    }

    //下一页
    public function next(){
        return $this->self_page < $this->total_page ?  "<a href='".$this->url.($this->self_page + 1) ."'>{$this->name['next']}</a>":'';
    }

    //首页

    public function first(){
        return $this->self_page > 1  ?  "<a href='".$this->url."1 '>{$this->name['first']}</a>":'';

    }
    //尾页

    public function end(){
        return $this->self_page < $this->total_page ?  "<a href='".$this->url.$this->total_page ."'>{$this->name['end']}</a>":'';

    }

    //当前页明细
    public function nowpage(){
        return " 当前页: 第".$this->a_id ."—{$this->l_id}{$this->name['unit']}　" ;
    }

    //统计数据

    public function count(){
        return "总页:".$this->total_page."页 &nbsp;共".$this->total_row ."条";
    }

    //前几页
    public function pres(){
        $p = $this->self_page - $this->page_row;
        return $this->self_page > $this->page_row ?  "<a href='".$this->url.$p."'>上{$this->page_row}{$this->name['unit']}</a>":'';
    }


    //后几页
    public function nexts(){
        $p = $this->self_page + $this->page_row;
        return $this->total_page - $this->self_page > $this->page_row ?  "<a href='".$this->url.$p."'>下{$this->page_row}{$this->name['unit']}</a>":'';
    }

    //获取页码数组
    private function pagelist(){
        $pagelist = array();
        $first = max(1,min($this->self_page-ceil($this->page_row/2),$this->total_page-$this->page_row));
        $next = min($this->page_row + $first,$this->total_page);

        for($i=$first;$i<=$next;$i++) {
            if ($i == $this->self_page) {
            $pagelist[$i]['url'] = '';
            $pagelist[$i]['str'] = $i;
            continue;
            }
            $pagelist[$i]['url']=$this->url.$i;
            $pagelist[$i]['str']=$i;
        }

        return $pagelist;
    }

    //页码数组遍历成字符串；
    public function strlist(){
        $arr=$this->pagelist();
        $pagelist = '';
        foreach($arr as $v){
            $pagelist .= empty($v['url'])? "<strong>{$v['str']}</strong>" : "<a href='{$v['url']}'>{$v['str']}</a>";
        }
        return $pagelist;
    }

    public function select(){
       $arr= $this->pagelist();
        $str = "<select class='pageSelect' onchange='javascript:location.href = this .options[this.selectedIndex].value'>";
        foreach($arr as $v){
            $str .= empty($v['url'])?"<option  value={$this->url}{$v['str']} selected='selected'>{$v['str']}</option>":"<option  value={$v['url']}>{$v['str']}</option>";
        }
        $str .= "</select>";
        return $str;
    }

    public function input(){
        $str = "<input type='text' id='pageinput' class='pageinput' size='5' value='{$this->self_page}'
        onkeydown=\"javascript:if(event.keyCode == 13){
         location.href='{$this->url}'+this.value;
         }\"/>
         <button  onclick=\"javascript:
         var url = document.getElementById('pageinput').value;
         location.href='{$this->url}'+url;
         \">提交</button>
         ";
        return $str;
    }

    public function show($i=4){
        switch($i){
            case 1:
                return $this->first().$this->pre().$this->strlist().$this->next().$this->end().$this->select().$this->input();
            break;
            case 2:
                return $this->first().$this->pre().$this->strlist().$this->next().$this->end().$this->input();
            break;
            case 3:
                return $this->pres().$this->pre().$this->strlist().$this->next().$this->nexts();
            break;
            case 4:
                return $this->first().$this->pre().$this->strlist().$this->next().$this->end().$this->nowpage().$this->count();
            break;
        }
    }

}