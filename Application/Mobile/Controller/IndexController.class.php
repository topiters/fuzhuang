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
        $user_id = session('user_id');
        $list = M('lunbo')->where(array('is_show'=>1))->limit(3)->select();
        $this->assign('list',$list);
        $arr = M('modelusers')->where(array('user_id'=>$user_id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }

    /**
     * 红人
     */
    public function hotPerson(){
        $user_id = session('user_id');
        $id = $_GET['id'];
       // var_dump($id);exit;
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
        $this->assign('user_id',$user_id);
        $this->display();
    }


    public function ajaxGetMore(){
        $p = I('p',1);
        $model = M('modelusers')->where(array('lever'=>1))->page($p,9)->select();
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
     *模特详情
     */
    public function modelDetail(){
        $id = session('user_id');
        $user_id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$user_id))->find();
        $this->assign('arr',$arr);
        $this->assign('user_id',$id);
        $this->display();
    }

    /**
     * 点赞
     */
    public function zan(){
        $id = $_GET['id'];
        $user_id = session('user_id');
        $arr = M('zan')->where(array('user_id'=>$user_id,'model_id'=>$id))->select();
        if($arr){
            exit("0");
        }else{
            $_POST=array(
                'user_id'=>$user_id,
                'model_id'=>$id,
                'add_time'=>time()
            );
            M('zan')->add($_POST);
            $arr = M('modelusers')->where(array('user_id'=>$id))->find();
            $num = $arr['total'] + 1;
            $re = M('modelusers')->where(array('user_id'=>$id))->save(array('total'=>$num));
            $this->ajaxReturn(json_encode($re));
        }
    }
    /**
     * 收藏
     */
    public function collect(){
        $id = $_GET['id'];
        $user_id = session('user_id');
        $arr = M('collect')->where(array('user_id'=>$user_id,'model_id'=>$id))->select();
        if($arr){
            exit("0");
        }else{
            $_POST=array(
                'user_id'=>$user_id,
                'model_id'=>$id,
                'add_time'=>time()
            );
            M('collect')->add($_POST);
            $arr = M('modelusers')->where(array('user_id'=>$id))->find();
            $num = $arr['collectnum'] + 1;
            $re = M('modelusers')->where(array('user_id'=>$id))->save(array('collectnum'=>$num));
            $this->ajaxReturn(json_encode($re));
        }
    }
    /*
     * 取消收藏
     */
    public function delCollect(){
        $id = $_GET['id'];
        $user_id = session('user_id');
        $arr = M('collect')->where(array('user_id'=>$user_id,'model_id'=>$id))->select();
        $d_id = $arr[0]['collect_id'];
        //var_dump($arr);exit;
        M('collect')->where(array('collect_id'=>$d_id))->delete();
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $num = $arr['collectnum'] - 1;
        $re = M('modelusers')->where(array('user_id'=>$id))->save(array('collectnum'=>$num));
        $this->ajaxReturn(json_encode($re));
    }
    /**
     * 加载更多红人
     */
    public function ajaxMore(){
        $p = intval(I('p',1));
        //var_dump($p);
        $id = intval($_GET['id']);
        //var_dump($id);exit;
        $m_arr = M('schedule')->where(array('id'=>$id))->find();
        $mod = explode(',',$m_arr['models']);
        //var_dump($mod);exit;
        $arr = array();
        foreach($mod as $k=>$v){
            $arr[$k] = M('modelusers')->where(array('user_id'=>$v))->find();
        }
        //dump($arr);exit;
        $re = M('linshi')->where(array('s_id'=>$id))->select();
        //var_dump($arr);exit;
        if(!$re) {
            //M("linshi")->where('id' != 0)->delete();
            foreach ($arr as $k => $v) {
                $head_pic = $v['head_pic'];
                $experience = $v['experience'];
                $nickname = $v['nickname'];
                $total = $v['total'];
                $model_id = $v['user_id'];
                $s_id = $id;
                M('linshi')->add(array('head_pic' => $head_pic, 'experience' => $experience, 'nickname' => $nickname, 'total' => $total, 's_id' => $s_id,'model_id'=>$model_id));
            }
        }
       // var_dump()
        $model = M('linshi')->where(array('s_id'=>$id))->order('total desc')->page($p,3)->select();
        //var_dump($model);exit;
        $this->assign('arr',$model);
        $this->display();
    }
    /**
     * 发现
     */
    public function find(){
        $this->display();
    }
    /**
     *文章详情
     */
    public function article(){
        $this->display();
    }
    /**
     * 活动详情
     */
    public function activity(){
        $this->display();
    }
    /**
     * 预约
     */
    public function order(){
        $this->display();
    }
    /**
     * 自选
     */
    public function select(){
        $this->display();
    }
    /**
     *详情
     */
    public function detail(){
        $this->display();
    }
    /**
     *客服
     */
    public function kefu(){
        $this->display();
    }
    /**
     *扫码
     */
    public function saoma(){
        $this->display();
    }
    /**
     *打给我们
     */
    public function callus(){
        $this->display();
    }
    /**
     *留言
     */
    public function message(){
        $this->display();
    }
}