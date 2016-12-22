<?php
/**
 * 报价设置
 */

namespace Admin\Controller;


use Think\AjaxPage;
use Think\Page;

class OffersetController extends BaseController {
	
    /**
     * 报价类型列表
     */
    public function index(){
        // 搜索条件
        $condition = array();
        I('mobile') ? $condition['mobile'] = I('mobile') : false;

		$type =  M('typeset');
    	$res = $type->order('type_id')->page($_GET['p'].',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$val['addtime'] = date('Y-m-d',$val['addtime']);
    			$list[] = $val;
    		}
    	}
    	$this->assign('list',$list);
    	$count = $type->count();
    	$Page = new \Think\Page($count,10);
    	$show = $Page->show();
    	$this->assign('page',$show);
    	$this->display();
    }
    
    /**
     * 报价详细信息查看
     */
    public function detail(){        
        
        $typeid = I('get.type_id');
        $type = D('typeset')->where(array('type_id'=>$typeid))->find();
        
        if(IS_POST){
        	//  报价 信息编辑
        	$data['type_name'] = I('post.type_name');
        	$data['range'] = I('post.range');
        	$data['type_id'] = I('post.type_id');
        
        	$row = M('typeset')->where(array('type_id'=>$data['type_id']))->save($data);
        	if($row)
        		exit($this->success('修改成功'));
        	exit($this->error('未作内容修改或修改失败'));
        }
        $this->assign('type',$type);
        $this->display();
    }

    /**
     * 删除报价类型
     */
    public function delete(){
        $typeid = I('post.type_id');
        $row = M('typeset')->where(array('type_id'=>$typeid))->delete();
        if($row){
            $this->success('成功删除类型');
        }else{
            $this->error('操作失败');
        }
    }

   /**
    * 添加报价类型 
    */
    public function addoffer(){
    	$this->display();
    }
    
    /**
     * 添加报价类型 
     */
    public function insertoffer(){
    	$data['type_name'] = I('post.type_name');
    	$data['range'] = I('post.range');
    	$data['addtime'] = time();
    	
    	$row = M('typeset')->where(array('type_name'=>$data['type_name'],'range'=>$data['range']))->find();
    	if($row){
    		exit($this->error('该种类型及价格已经添加'));
    	}
    	
    	$r = D('typeset')->add($data);
    	
    	if($r){
    		$this->success("操作成功",U('Admin/Offerset/addoffer'));
    	}else{
    		$this->error("操作失败",U('Admin/Offerset/addoffer'));
    	}
    }
}