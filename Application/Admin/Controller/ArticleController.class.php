<?php
/*
 * 信息管理
 */
namespace Admin\Controller;
use Admin\Logic\ArticleCatLogic;

class ArticleController extends BaseController {

    public function categoryList(){
        $ArticleCat = new ArticleCatLogic(); 
        $cat_list = $ArticleCat->article_cat_list(0, 0, false);
        $this->assign('cat_list',$cat_list);
        $this->display('categoryList');
    }
    
    public function category(){
        $ArticleCat = new ArticleCatLogic();  
 		$act = I('GET.act','add');
        $this->assign('act',$act);
        $cat_id = I('GET.cat_id');
        $cat_info = array();
        if($cat_id){
            $cat_info = D('article_cat')->where('cat_id='.$cat_id)->find();
            $this->assign('cat_info',$cat_info);
        }
        $cats = $ArticleCat->article_cat_list(0,$cat_info['parent_id'],true);
        $this->assign('cat_select',$cats);
        $this->display();
    }
    
    /**
     * 首页大图   2016-12-21
    */
    public function bigimg(){
    	$lunbo =  M('lunbo');
    	$res = $list = array();
    	$p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
    	
    	$res = $lunbo->where($where)->order('id desc')->page("$p,5")->select();
    	$count = $lunbo->where($where)->count();// 查询满足要求的总记录数
    	$pager = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数
    	$page = $pager->show();//分页显示输出
    	if($res){
    		foreach ($res as $val){
    			$val['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
    			$list[] = $val;
    		}
    	}
    	$this->assign('list',$list);// 赋值数据集
    	$this->assign('page',$page);// 赋值分页输出
    	$this->display();
    }
    
    /**
     * 添加首页大图 2016-12-21
    */
    public function addimg(){
    	$this->display();
    }
    
    /**
     * 执行添加首页大图 2016-12-21 
    */
    public function insertimg(){
    	$data = I('post.');
    	$data['addtime'] = time();
    	
    	$r = D('lunbo')->add($data);
    	 
    	if($r){
    		$this->success("操作成功",U('Admin/Article/bigimg'));
    	}else{
    		$this->error("操作失败",U('Admin/Article/bigimg'));
    	}
    }
    
    /**
     * 轮播图详情
     */
    public function imgdetail(){
    	$id = I('id',1);
    	$info = D('lunbo')->where("id=$id")->find();
    	//修改文章
    	if(IS_POST){
    		//  会员信息编辑
    		$data['p_url'] = I('post.p_url');
    		$data['url'] = I('post.url');
    		 
    		$row = M('lunbo')->where(array('id'=>$id))->save($data);
    		if($row)
    			exit($this->success('修改成功'));
    		exit($this->error('未作内容修改或修改失败'));
    	}
    	 
    	$this->assign('info',$info);
    	$this->display();
    }
    
    /**
     * 删除首页大图
     */
    public function delimg(){
    	$id = I('post.id');
    	$r = D('lunbo')->where('id='.$id)->delete();
    	if($r) exit(json_encode(1));
    }
    
    //文章 列表 2016-12-20
    public function articleList(){
        $Article =  M('Article'); 
        $res = $list = array();
        $p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
        $size = empty($_REQUEST['size']) ? 20 : $_REQUEST['size'];
        
        $where = " 1 = 1 ";
        $keywords = trim(I('keywords'));
        $keywords && $where.=" and title like '%$keywords%' ";
        $res = $Article->where($where)->order('article_id desc')->page("$p,$size")->select();
        $count = $Article->where($where)->count();// 查询满足要求的总记录数
        $pager = new \Think\Page($count,$size);// 实例化分页类 传入总记录数和每页显示的记录数
        $page = $pager->show();//分页显示输出

        $ArticleCat = new ArticleCatLogic();
        $cats = $ArticleCat->article_cat_list(0,0,false);
        if($res){
        	foreach ($res as $val){
        		$val['add_time'] = date('Y-m-d H:i:s',$val['add_time']);        		
        		$list[] = $val;
        	}
        }
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$page);// 赋值分页输出
        $this->display('articleList');
    }
    //添加文章
    public function article(){
        $ArticleCat = new ArticleCatLogic();
 		$act = I('GET.act','add');
        $info = array();
        if(I('GET.article_id')){
           $article_id = I('GET.article_id');
           $info = D('article')->where('article_id='.$article_id)->find();
        }
        $cats = $ArticleCat->article_cat_list(0,$info['cat_id']);
        $this->assign('cat_select',$cats);
        $this->assign('act',$act);
        $this->assign('info',$info);
        //初始化编辑器链接
        $this->initEditor();
        $this->display();
    }
    
    /**
     * 文章详情
    */
    public function detail(){
    	$article_id = I('article_id',1);
    	$article = D('article')->where("article_id=$article_id")->find();
    	//修改文章
    	if(IS_POST){
    		//  会员信息编辑
    		$data['title'] = I('post.title');
    		$data['thumb'] = I('post.thumb');
    		$data['description'] = I('post.description');
    		$data['content'] = I('post.content');
    	
    		$row = M('article')->where(array('article_id'=>$article_id))->save($data);
    		if($row)
    			exit($this->success('修改成功'));
    		exit($this->error('未作内容修改或修改失败'));
    	}
    	
    	$this->assign('article',$article);
    	//初始化编辑器链接
    	$this->initEditor();
    	$this->display();
    }
    
    /**
     * 关于我们
    */
    public function about(){
    	
    }
    
    /**
     * 用户协议
    */
    public function agreement(){
    	
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
    
    
    public function categoryHandle(){
    	$data = I('post.');   
        if($data['act'] == 'add'){           
            $d = D('article_cat')->add($data);
        }
        
        if($data['act'] == 'edit')
        {
        	if ($data['cat_id'] == $data['parent_id']) 
			{
        		$this->error("所选分类的上级分类不能是当前分类",U('Admin/Article/category',array('cat_id'=>$data['cat_id'])));
        	}
        	$ArticleCat = new ArticleCatLogic();
        	$children = array_keys($ArticleCat->article_cat_list($data['cat_id'], 0, false)); // 获得当前分类的所有下级分类
        	if (in_array($data['parent_id'], $children))
        	{
        		$this->error("所选分类的上级分类不能是当前分类的子分类",U('Admin/Article/category',array('cat_id'=>$data['cat_id'])));
        	}
        	$d = D('article_cat')->where("cat_id=$data[cat_id]")->save($data);
        }
        
        if($data['act'] == 'del'){      	
        	$res = D('article_cat')->where('parent_id ='.$data['cat_id'])->select(); 
        	if ($res)
        	{
        		exit(json_encode('还有子分类，不能删除'));
        	}
        	$res = D('article')->where('cat_id ='.$data['cat_id'])->select();       	      	
        	if ($res)
        	{
        		exit(json_encode('非空的分类不允许删除'));
        	}      	
        	$r = D('article_cat')->where('cat_id='.$data['cat_id'])->delete();
        	if($r) exit(json_encode(1));
        }
        if($d){
        	$this->success("操作成功",U('Admin/Article/categoryList'));
        }else{
        	$this->error("操作失败",U('Admin/Article/categoryList'));
        }
    }
    
    /*
     * 执行添加文章 
     */
    public function aticleHandle(){
        $data = I('post.');
        $data['publish_time'] = strtotime($data['publish_time']);
        //$data['content'] = htmlspecialchars(stripslashes($_POST['content']));
        if($data['act'] == 'add'){
        	$data['add_time'] = time(); 
            $r = D('article')->add($data);
        }
        
        if($data['act'] == 'edit'){
            $r = D('article')->where('article_id='.$data['article_id'])->save($data);
        }
        
        if($data['act'] == 'del'){
        	$r = D('article')->where('article_id='.$data['article_id'])->delete();
        	if($r) exit(json_encode(1));       	
        }
        $referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U('Admin/Article/articleList');
        if($r){
            $this->success("操作成功",$referurl);
        }else{
            $this->error("操作失败",$referurl);
        }
    }
    
    
    public function link(){
    	$act = I('GET.act','add');
    	$this->assign('act',$act);
    	$link_id = I('GET.link_id');
    	$link_info = array();
    	if($link_id){
    		$link_info = D('friend_link')->where('link_id='.$link_id)->find();
    		$this->assign('info',$link_info);
    	}
    	$this->display();
    }
    
    public function linkList(){
    	$Ad =  M('friend_link');
    	$res = $Ad->where('1=1')->order('orderby')->page($_GET['p'].',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$val['target'] = $val['target']>0 ? '开启' : '关闭';
    			$list[] = $val;
    		}
    	}
    	$this->assign('list',$list);// 赋值数据集
    	$count = $Ad->where('1=1')->count();// 查询满足要求的总记录数
    	$Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
    	$show = $Page->show();// 分页显示输出
    	$this->assign('page',$show);// 赋值分页输出
    	$this->display();
    }
    
    public function linkHandle(){
        $data = I('post.');
    	if($data['act'] == 'add'){
    		$r = D('friend_link')->add($data);
    	}
    	if($data['act'] == 'edit'){
    		$r = D('friend_link')->where('link_id='.$data['link_id'])->save($data);
    	}
    	
    	if($data['act'] == 'del'){
    		$r = D('friend_link')->where('link_id='.$data['link_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
    	
    	if($r){
    		$this->success("操作成功",U('Admin/Article/linkList'));
    	}else{
    		$this->error("操作失败",U('Admin/Article/linkList'));
    	}
    }
}