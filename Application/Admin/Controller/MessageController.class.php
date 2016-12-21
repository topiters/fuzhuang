<?php
/**
 * 留言管理
 */

namespace Admin\Controller;


use Think\AjaxPage;
use Think\Page;

class MessageController extends BaseController {

    public function index(){
        $this->display();
    }

    /**
     * 留言列表
     */
    public function ajaxindex(){
        // 搜索条件
        $condition = array();
        $message = I('message');
        $message ? $condition['message'] = array('like','%{$message}%') : false;

        $sort_order = I('order_by').' '.I('sort');

        $model = M('message');
        $count = $model->where($condition)->count();
        //  搜索条件下 分页赋值
        $Page  = new AjaxPage($count,5);
        $show = $Page->show();
        
        $messageList = $model->where($condition)->order($sort_order)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('messageList',$messageList);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    
    /*
     * 留言详细查看
     */
    public function detail(){
    	$id = I('get.id');
    	$message = D('message')->where(array('message_id'=>$id))->find();
    	if(!$message){
    		exit($this->error('留言不存在'));
    	}
    	//查询回复
    	$reply = M('reply')->where(array('message_id'=>$id))->select();
    	$this->assign('message',$message);
    	$this->assign('reply',$reply);
    	$this->display();
    }
    /*
     * 添加回复 
    */
    public function reply(){
    	$data = array(); 
    	$data['content'] = I('post.content');
    	$data['message_id'] = I('post.id');
    	$data['reply_time'] = time();
    	//添加回复
    	if($data['content'] == ''){
    		exit($this->error('请填写评论'));
    	}else{
    		$r = D('reply')->add($data);
    	}
    	
    	if($r){
    		$this->success("操作成功",U('Admin/Message/index'));
    	}else{
    		$this->error("操作失败",U('Admin/Message/index'));
    	}
    }

    /**
     * 删除留言
     */
    public function delete(){
        $id = I('get.id');
        $row = M('message')->where(array('message_id'=>$id))->delete();
        if($row){
        	//删除该留言下的评论
        	$reply = M('reply')->where(array('message_id'=>$id))->delete();
            $this->success('成功删除留言');
        }else{
            $this->error('操作失败');
        }
    }
}