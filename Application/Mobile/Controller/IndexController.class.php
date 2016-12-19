<?php
/**
 * 首页
 */ 
namespace Mobile\Controller;
class IndexController extends MobileBaseController {

    public function index(){
       /* $model = M('modelusers')->where(array('mobile_validated'=>1))->select();
        //$user_id = array();
        $arr = array();
        foreach($model as $k=>$v){
            $user_id = $v['user_id'];
            $img_arr = M('user_images')->where(array('modeluser_id'=>$user_id))->order("img_id desc")->limit(1)->find();
            $arr[] = $img_arr;
            $arr[$k]['nickname'] = $v['nickname'];
        }
        //var_dump($arr);exit;
        $this->assign('arr',$arr);*/
    	//轮播图
        $list = M('lunbo')->where(array('is_show'=>1))->limit(3)->select();
        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 红人
     */
    public function hotPerson(){
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
    /*
     * 首页模特展示 
    */
    public function ajaxGetMore(){
        $p = I('p',1);
        $model = M('modelusers')->where(array('mobile_validated'=>1))->page($p,9)->select();
        $arr = array();
        foreach($model as $k=>$v){
            $user_id = $v['user_id'];
            $img_arr = M('user_images')->where(array('modeluser_id'=>$user_id))->order("img_id desc")->limit(1)->find();
            $arr[] = $img_arr;
            $arr[$k]['nickname'] = $v['nickname'];
        }
        //var_dump($arr);exit;
        $this->assign('arr',$arr);
        $this->display();
    }
}