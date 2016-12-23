<?php
/**
 * 充值活动管理
 */

namespace Admin\Controller;


use Think\AjaxPage;
use Think\Page;

class ChargeController extends BaseController {

    public function index(){
        $this->display();
    }

    /**
     * 充值活动列表
     */
    
    public function ajaxindex(){
    	// 搜索条件
    	$condition = array();
    	I('charge') ? $condition['name'] = I('charge') : false;
    
    	$model = M('prom_order');
    	//计算会员总数
    	$count = $model->where($condition)->count();
    	$Page  = new AjaxPage($count,5);
    	//  搜索条件下 分页赋值
    	foreach($condition as $key=>$val) {
    		$Page->parameter[$key]   =   urlencode($val);
    	}
    	$show = $Page->show();
    	$prom = $model->where($condition)->order("id desc")->limit($Page->firstRow.','.$Page->listRows)->select();
    	$this->assign('prom',$prom);
    	$this->assign('page',$show);// 赋值分页输出
    	$this->display();
    }

    /**
     * 充值详细信息查看
     */
    public function detail(){
        $id = I('get.id');
        $info = D('prom_order')->where(array('id'=>$id))->find();
        if(IS_POST){
            $data['name'] = I("post.name");
            $data['money'] = I("post.money");
            $data['fmoney'] = I("post.fmoney");
            $data['wmoney'] = I("post.wmoney");
            $data['description'] = I("post.description");

            $row = M('prom_order')->where(array('id'=>I("post.id")))->save($data);
            if($row)
                exit($this->success('修改成功'));
            exit($this->error('未作内容修改或修改失败'));
        }
        $this->assign('info',$info);
        //初始化编辑器链接
        $this->initEditor();
        $this->display();
    }

    /**
     * 删除活动
     */
    public function delete(){
        $id = I('get.id');
        $row = M('prom_order')->where(array('id'=>$id))->delete();
        if($row){
            $this->success('成功删除活动');
        }else{
            $this->error('操作失败');
        }
    }
    
    /**
     * 添加充值活动 
     */
    public function addcharge(){
    	$this->display();
    }
    
    /**
     * 添加充值 
     */
    public function insertcharge(){
    	$data = I('post.');
    	$data['addtime'] = time();
    	 
    	$r = D('prom_order')->add($data);
    	
    	if($r){
    		$this->success("操作成功",U('Admin/Charge/index'));
    	}else{
    		$this->error("操作失败",U('Admin/Charge/index'));
    	}
    }
    
    /**
     * 推荐奖设置 
     */
    public function recommend(){
    	
    	$this->display();
    }
    
    /**
     * 初始化编辑器链接
     * @param $post_id post_id
     */
    private function initEditor()
    {
    	$this->assign("URL_upload", U('Admin/Ueditor/imageUp',array('savepath'=>'article')));
    	$this->assign("URL_fileUp", U('Admin/Ueditor/fileUp',array('savepath'=>'article')));
    	$this->assign("URL_scrawlUp", U('Admin/Ueditor/scrawlUp',array('savepath'=>'article')));
    	$this->assign("URL_getRemoteImage", U('Admin/Ueditor/getRemoteImage',array('savepath'=>'article')));
    	$this->assign("URL_imageManager", U('Admin/Ueditor/imageManager',array('savepath'=>'article')));
    	$this->assign("URL_imageUp", U('Admin/Ueditor/imageUp',array('savepath'=>'article')));
    	$this->assign("URL_getMovie", U('Admin/Ueditor/getMovie',array('savepath'=>'article')));
    	$this->assign("URL_Home", "");
    }
}