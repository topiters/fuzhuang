<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: JY 2016-01-09
 */ 
namespace Mobile\Controller;
class IndexController extends MobileBaseController {

    public function index(){
        $list = M('lunbo')->where(array('is_show'=>1))->limit(3)->select();
        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 红人
     */
    public function hotPerson(){
        $id = $_GET['id'];
        $s_arr = M('schedule')->select();
        $arr = array();
        foreach($s_arr as $k=>$v){
            $arr[$k] = $v['id'];
        }
        if($id==''){
            $id=max($arr);
        }
        //var_dump($id);exit;
        $m_arr = M('schedule')->where(array('id'=>$id))->find();
        $this->assign('m_arr',$m_arr);
        $this->assign('s_arr',$s_arr);
        $this->display();
    }

    /**
     * 分类列表显示
     */
    public function categoryList(){
        $this->display();
    }

    /**
     * 模板列表
     */
    public function mobanlist(){
        $arr = glob("D:/wamp/www/svn_tpshop/mobile--html/*.html");
        foreach($arr as $key => $val)
        {
            $html = end(explode('/', $val));
            echo "<a href='http://www.php.com/svn_tpshop/mobile--html/{$html}' target='_blank'>{$html}</a> <br/>";            
        }        
    }
    
    /**
     * 商品列表页
     */
    public function goodsList(){
        $goodsLogic = new \Home\Logic\GoodsLogic(); // 前台商品操作逻辑类
        $id = I('get.id',0); // 当前分类id
        $lists = getCatGrandson($id);
        $this->assign('lists',$lists);
        $this->display();

    }
    public function ajaxGetMore(){
        $p = I('p',1);
        $model = M('modelusers')->where(array('mobile_validated'=>1))->page($p,9)->select();
        /*$arr = array();
        foreach($model as $k=>$v){
            $user_id = $v['user_id'];
            $img_arr = M('user_images')->where(array('modeluser_id'=>$user_id))->order("img_id desc")->limit(1)->find();
            $arr[] = $img_arr;
            $arr[$k]['nickname'] = $v['nickname'];
        }*/
        //var_dump($arr);exit;
        $this->assign('arr',$model);
        $this->display();
    }

    /**
     * 加载更多红人
     */
    public function ajaxMore(){
        $p = I('p',1);
        $id = $_GET['id'];
        $m_arr = M('schedule')->where(array('id'=>1))->find();
        $mod = explode(',',$m_arr['models']);
        //var_dump($mod);exit;
        $arr = array();
        foreach($mod as $k=>$v){
            $arr[$k] = M('modelusers')->where(array('user_id'=>$v))->find();
        }
        foreach($arr as $k=>$v){
            $head_pic = $v['head_pic'];
            $experience = $v['experience'];
            $nickname = $v['nickname'];
        }
        $this->assign('arr',$arr);

        $model = M('modelusers')->where(array('mobile_validated'=>1))->order('total desc')->page($p,2)->select();
        $this->assign('model',$model);
        $this->display();
    }
}