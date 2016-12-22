<?php
/**
 * 认证管理
 */

namespace Admin\Controller;

class CationController extends BaseController{
    /**
     * 认证列表 
     */
    public function index(){
        $cation =  M('modelusers');
        $count = $cation->where('checked=1')->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $list = $cation->where('checked=1')->order('user_id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        
        $this->assign('list',$list);// 赋值数据集                
        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    
    /**
     * 通过认证 
     */
    public function editsta(){
    	$user_id = I('get.user_id');
    	if($user_id == ''){
    		exit($this->error('会员不存在'));
    	}
    	$data['checked'] = 2;
    	$r = D('modelusers')->where('user_id='.$user_id)->save($data);
    	if($r) exit(json_encode(1));
    }
}