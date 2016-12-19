<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: 当燃      
 * 专题管理
 * Date: 2016-03-09
 */

namespace Admin\Controller;

class PromotionController extends BaseController {

    public function index(){
        $this->display();
    }
    
    public function group_buy_list(){
    	$Ad =  M('group_buy');
    	$p = I('p',1);
    	$res = $Ad->where('1=1')->order('groupbuy_id desc')->page($p.',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$val['start_time'] = date('Y-m-d',$val['start_time']);
    			$val['end_time'] = date('Y-m-d',$val['end_time']);
    			$list[] = $val;
    		}
    	}
    	$this->assign('list',$list);
    	$count = $Ad->where('1=1')->count();
    	$Page = new \Think\Page($count,10);
    	$show = $Page->show();
    	$this->assign('page',$show);
    	$this->display();
    }
    
    public function group_buy(){
    	$act = I('GET.act','add');
    	$groupbuy_id = I('GET.groupbuy_id');
    	$group_info = array();
    	if($groupbuy_id){
    		$group_info = D('group_buy')->where('groupbuy_id='.$groupbuy_id)->find();
    		$group_info['start_time'] = date('Y-m-d',$group_info['start_time']);
    		$group_info['end_time'] = date('Y-m-d',$group_info['end_time']);
    		$this->assign('info',$group_info);
    		$act = 'edit';
    	}
    	$this->assign('min_date',date('Y-m-d'));
    	$this->assign('act',$act);
    	$this->display();
    }
    
    public function get_goods(){
    	$brandList =  M("brand")->select();
    	$categoryList =  M("goods_category")->select();
    	$this->assign('categoryList',$categoryList);
    	$this->assign('brandList',$brandList);   	
    	$where = ' is_on_sale = 1 ';//搜索条件
    	I('intro')  && $where = "$where and ".I('intro')." = 1";
    	if(I('cat_id')){
    		$this->assign('cat_id',I('cat_id'));    		
            $grandson_ids = getCatGrandson(I('cat_id')); 
            $where = " $where  and cat_id in(".  implode(',', $grandson_ids).") "; // 初始化搜索条件
                
    	}
		if(I('brand_id')){
			$this->assign('brand_id',I('brand_id'));
			$where = "$where and brand_id = ".I('brand_id');
		}
    	if(!empty($_REQUEST['keywords']))
    	{
    		$this->assign('keywords',I('keywords'));
    		$where = "$where and (goods_name like '%".I('keywords')."%' or keywords like '%".I('keywords')."%')" ;
    	}  	
    	$goodsList = M('goods')->where($where)->order('goods_id DESC')->select();
    	$this->assign('goodsList',$goodsList);
    	$this->display();
    }
    
    public function groupbuyHandle(){
    	$data = I('post.');
    	$data['groupbuy_intro'] = htmlspecialchars(stripslashes($_POST['groupbuy_intro']));
    	$data['start_time'] = strtotime($data['start_time']);
    	$data['end_time'] = strtotime($data['end_time']);
    	if($data['act'] == 'add'){
    		$now = time();
    		$rs = D('group_buy')->where('goods_id='.$data['goods_id'].' AND end_time>'.$now)->find();
    		if(empty($rs)){
    			$r = D('group_buy')->add($data);
    		}else{
    			$this->error("此商品已存在团购活动中",U('Admin/Promotion/group_buy_list'));
    		}
    	}
    	if($data['act'] == 'edit'){
    		$r = D('group_buy')->where('groupbuy_id='.$data['groupbuy_id'])->save($data);
    	}
    
    	if($data['act'] == 'del'){
    		$r = D('group_buy')->where('groupbuy_id='.$data['groupbuy_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
    
    	if($r){
    		$this->success("操作成功",U('Admin/Promotion/group_buy_list'));
    	}else{
    		$this->error("操作失败",U('Admin/Promotion/group_buy_list'));
    	}
    }
    
    public function area(){
    	$this->display();
    }
    
    public function area_info(){
    	$this->display();
    }
    
    public function areaHandle(){
    	$this->display();
    }
}