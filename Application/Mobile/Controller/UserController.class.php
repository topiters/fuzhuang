<?php
/**
 * 用户中心
 */
namespace Mobile\Controller;
use Home\Logic\UsersLogic;
use Think\Controller;
use Think\Page;
use Think\Verify;

class UserController extends MobileBaseController {
    /*
     * 用户中心首页
     */
    public function index(){
        $logic = new UsersLogic();
        $user = $logic->get_info($this->user_id);
        $user = $user['result'];        
        $this->assign('user',$user);
        $this->display();
    }


    public function logout(){
        session('user',null);
        $this->success("退出成功",U('Mobile/Index/index'));
    }

    /*
     * 账户资金
     */
    public function account(){
        $user = session('user');
        //获取账户资金记录
        $logic = new UsersLogic();
        $data = $logic->get_account_log($this->user_id,I('get.type'));
        $account_log = $data['result'];

        $this->assign('user',$user);
        $this->assign('account_log',$account_log);
        $this->assign('page',$data['show']);
        $this->display();
    }

    public function coupon(){
        //
        $logic = new UsersLogic();
        $data = $logic->get_coupon($this->user_id,$_REQUEST['type']);
        $coupon_list = $data['result'];
        $this->assign('coupon_list',$coupon_list);
        $this->assign('page',$data['show']);
        $this->display();
    }
    /**
     *  登录
     */
    public function login(){
        if(IS_POST){           
            $this->verifyHandle('user_login'); //验证码检测
            $username = I('post.username');
            $password = I('post.password');
            $logic = new UsersLogic();
            $data = $logic->login($username,$password);
            if($data['status'] != 1)
                $this->error($data['msg']);
            session('user',$data['result']);
            session('user_id',$data['result']['user_id']);

            $cartLogic = new \Home\Logic\CartLogic();        
            $cartLogic->login_cart_handle($this->session_id,$data['result']['user_id']); // 用户登录后 需要对购物车 一些操作
            $referurl =  empty($_POST['referurl']) ? U("User/index") : $_POST['referurl'];
            header("Location:$referurl");
            exit;
        }
        $referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U("User/index");
        $this->assign('referurl',$referurl);
        $this->display();
    }
    /**
     *  注册类型
     */
    public function regType(){
        $this->display();
    }
    /**
     *  注册
     */
    public function reg(){

            if(IS_POST){
                $logic = new UsersLogic();
                $username = I('post.mobile','');
                //是否开启注册验证码机制
                /*if(check_mobile($username)){
                    $code = I('post.mobile_code','');
                    $check_code = $logic->sms_code_verify($username,$code,$this->session_id);
                    if($check_code['status'] != 1)
                        $this->error($check_code['msg']);
                }*/
                $reg_time = time();
                if($_GET['cid']==2){
                    $data = M('modelusers')->add(array('mobile'=>$username,'reg_time'=>$reg_time,'lever'=>2));
                }else{
                    $data = M('modelusers')->add(array('mobile'=>$username,'reg_time'=>$reg_time));
                }
                session('user_id',$data);
                $this->success("绑定成功",U('Mobile/User/myContent'));
                exit;
            }

        if($_GET['id']){
            $logic = new UsersLogic();
            $username = I('post.mobile','');
            //是否开启注册验证码机制
            /*if(check_mobile($username)){
                $code = I('post.mobile_code','');
                $check_code = $logic->sms_code_verify($username,$code,$this->session_id);
                if($check_code['status'] != 1)
                    $this->error($check_code['msg']);
            }*/
            $data = M('modelusers')->where(array('user_id'=>$_GET['id']))->save(array('mobile'=>$username));
            $this->success("修改成功",U('Mobile/User/userEdit'));
            exit;
        }
        $this->display();
    }
    /**
     *用户协议
     */
    public function myContent(){
        $this->display();
    }
    /**
     *用户协议
     */
    public function xieyi(){
        $this->display();
    }
    /**
     *我的钱包
     */
    public function myWallet(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     *我的钱包
     */
    public function mySpent(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     *我的活动
     */
    public function myActivity(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     *充值
     */
    public function recharge(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     * 个人中心界面
     */
    public function myCenter(){
        $id = session('user_id');
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        //var_dump($arr);exit;
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     * 更换背景墙
     */
    public function background(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        //var_dump($arr);exit;
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     * 我的收藏
     */
    public function collect(){
        $id = $_GET['id'];
        $count = M('collect')->where(array('user_id'=>$id))->count();
        $page = new Page($count,'5');
        $show = $page->show();
        $arr = M('collect')->where(array('user_id'=>$id))->order("add_time desc")->limit($page->firstRow.','.$page->listRows)->select();
        if ($_GET['is_ajax']) {
            $this->display('ajax_collect_list');
            exit;
        }
        $this->assign('page',$show);
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     * 我的订单
     */
    public function myOrder(){
        $id = $_GET['id'];
        $count = M('collect')->where(array('user_id'=>$id))->count();
        $page = new Page($count,'5');
        $show = $page->show();
        $arr = M('collect')->where(array('user_id'=>$id))->order("add_time desc")->limit($page->firstRow.','.$page->listRows)->select();
        if ($_GET['is_ajax']) {
            $this->display('ajax_collect_list');
            exit;
        }
        $this->assign('page',$show);
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     * 信息编辑
     */
    public function userEdit(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }

    /**
     * 保存信息
     */
    public function ajaxSave(){
        $id = $_POST['user_id'];
        //var_dump($_POST);exit;
        $re = M('modelusers')->where(array('user_id'=>$id))->save($_POST);
        $this->ajaxReturn(json_encode($re));
    }
    /**
     * 我的推荐
     */
    public function myRecommend(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     * 认证类型
     */
    public function approveType(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     * 个人认证
     */
    public function approvePer(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     * 个人申请
     */
    public function ajaxPer(){
        $id = $_GET['id'];
        //var_dump(session('user_id'));exit;
        $re = M('modelusers')->where(array('user_id'=>$id))->save($_POST);
        $this->ajaxReturn(json_encode($re));
    }
    /**
     * 企业认证re
     */
    public function approveCom(){
        $id = $_GET['id'];
        $arr = M('modelusers')->where(array('user_id'=>$id))->find();
        $this->assign('arr',$arr);
        $this->display();
    }
    /**
     * 企业申请
     */
    public function ajaxCom(){
        $id = $_GET['id'];
        //var_dump($_POST);exit;
        $arr = M('modelusers')->where(array('user_id'=>$id))->save($_POST);
        $this->ajaxReturn(json_encode($re));
    }
    /**
     * 个人验证
     */
    public function person(){

        $this->display();
    }
    public function setMob()
    {
        $mobile = I("post.mobile",'');
        $user_where['mobile'] = $mobile;
        $users = M('modelusers')->where($user_where)->find();
        if($users)
            echo "1";
        else
            echo "0";
    }
    /*
     * 订单列表
     */
    public function order_list()
    {         
        $this->display();
    }

    
    /*
     * 订单列表
     */
    public function ajax_order_list(){
        $where = ' user_id='.$this->user_id;
        
        //条件搜索 
        if(in_array(strtoupper(I('type')), array('WAITCCOMMENT','COMMENTED'))) 
        {
           $where .= " AND order_status in(1,4) "; //代评价 和 已评价
        }
        elseif(I('type'))
       {
           $where .= C(strtoupper(I('type')));
       }
       
       
        $count = M('order')->where($where)->count();
        $Page = new Page($count,2);

        $show = $Page->show();
        $order_str = "order_id DESC";
        $order_list = M('order')->order($order_str)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();

        //获取订单商品
        $model = new UsersLogic();
        foreach($order_list as $k=>$v)
        {
            $order_list[$k] = set_btn_order_status($v);  // 添加属性  包括按钮显示属性 和 订单状态显示属性
            $order_list[$k]['total_fee'] = $v['goods_amount'] + $v['shipping_fee'] - $v['integral_money'] -$v['bonus'] - $v['discount']; //订单总额
            $data = $model->get_order_goods($v['order_id']);
            $order_list[$k]['goods_list'] = $data['result'];            
        }
        $this->assign('order_status',C('ORDER_STATUS'));
        $this->assign('shipping_status',C('SHIPPING_STATUS'));
        $this->assign('pay_status',C('PAY_STATUS'));
        $this->assign('page',$show);
        $this->assign('lists',$order_list);
        $this->assign('active','order_list');
        $this->assign('active_status',I('get.type'));        
        $this->display();
    }    
    
    /*
     * 订单详情
     */
    public function order_detail(){
        $id = I('get.id');    
        $map['order_id'] = $id;
        $map['user_id'] = $this->user_id;
        $order_info = M('order')->where($map)->find();        
        $order_info = set_btn_order_status($order_info);  // 添加属性  包括按钮显示属性 和 订单状态显示属性
      //   print_r($order_info );
       //     exit;
        if(!$order_info){
            $this->error('没有获取到订单信息');
            exit;
        }
        //获取订单商品
        $model = new UsersLogic();
        $data = $model->get_order_goods($order_info['order_id']);
        $order_info['goods_list'] = $data['result'];
        $order_info['total_fee'] = $order_info['goods_price'] + $order_info['shipping_price'] - $order_info['integral_money'] -$order_info['coupon_price'] - $order_info['discount'];

        $region_list = get_region_list();
        //获取订单操作记录
        $order_action = M('order_action')->where(array('order_id'=>$id))->select();
        $this->assign('order_status',C('ORDER_STATUS'));
        $this->assign('shipping_status',C('SHIPPING_STATUS'));
        $this->assign('pay_status',C('PAY_STATUS'));
        $this->assign('region_list',$region_list);
        $this->assign('order_info',$order_info);
        $this->assign('order_action',$order_action);
        $this->display();
    }

    /*
     * 取消订单
     */
    public function cancel_order(){
        $id = I('get.id');
        //检查是否有积分，余额支付
        $logic = new UsersLogic();
        $data = $logic->cancel_order($this->user_id,$id);
        if($data['status'] < 0)
            $this->error($data['msg']);
        $this->success($data['msg']);
    }

    /*
     * 用户地址列表
     */
    public function address_list(){
        $address_lists = get_user_address_list($this->user_id);
        $region_list = get_region_list();
        $this->assign('region_list',$region_list);
        $this->assign('lists',$address_lists);
        $this->display();
    }
    /*
     * 添加地址
     */
    public function add_address()
    {        
        if(IS_POST)
        {
            //购物车添加完毕后 返回购物车页面
            $url = U('/Mobile/User/address_list');
            if(I('get.is_back')== 1)
                $url = U('/Mobile/Cart/cart2');
            $logic = new UsersLogic();
            $data = $logic->add_address($this->user_id,0,I('post.'));
            if($data['status'] != 1)
                $this->error($data['msg']);                            
            else
                $this->success($data['msg'],$url);
            exit();
        }
        $p = M('region')->where(array('parent_id'=>0,'level'=> 1))->select();
        $this->assign('province',$p);
        $this->display('edit_address');

    }

    /*
     * 地址编辑
     */
    public function edit_address()
    {        
        $id = I('id');
        $address = M('user_address')->where(array('address_id'=>$id,'user_id'=> $this->user_id))->find();
        if(IS_POST)
        {
            $logic = new UsersLogic();
            $data = $logic->add_address($this->user_id,$id,I('post.'));
            if($data['status'] != 1)
                $this->error($data['msg']);            
            else
                $this->success($data['msg'],U('/Mobile/User/address_list'));            
            exit();
        }
        //获取省份
        $p = M('region')->where(array('parent_id'=>0,'level'=> 1))->select();
        $c = M('region')->where(array('parent_id'=>$address['province'],'level'=> 2))->select();
        $d = M('region')->where(array('parent_id'=>$address['city'],'level'=> 3))->select();

        $this->assign('province',$p);
        $this->assign('city',$c);
        $this->assign('district',$d);

        $this->assign('address',$address);
        $this->display();
    }

    /*
     * 设置默认收货地址
     */
    public function set_default(){
        $id = I('get.id');
        M('user_address')->where(array('user_id'=>$this->user_id))->save(array('is_default'=>0));
        $row = M('user_address')->where(array('user_id'=>$this->user_id,'address_id'=>$id))->save(array('is_default'=>1));
        if(!$row)
            $this->error('操作失败');
        $this->success("操作成功");
    }

    /*
     * 地址删除
     */
    public function del_address(){
        $id = I('get.id');
        $row = M('user_address')->where(array('user_id'=>$this->user_id,'address_id'=>$id))->delete();
        if(!$row)
            $this->error('操作失败');
        $this->success("操作成功");
    }

    /*
     * 评论晒单
     */
    public function comment(){
        $user_id = $this->user_id;
        $rec_id = I('rec_id');
        $order_goods = M('order_goods')->where("rec_id = $rec_id")->find();
        $this->assign('order_goods',$order_goods);        
        $this->display();
    }

    /*
     *添加评论
     */
    public function add_comment(){                
 
     
            // 晒图片
            if($_FILES[comment_img_file][tmp_name][0])
            {
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize   =    $map['author'] = (1024*1024*3);// 设置附件上传大小 管理员10M  否则 3M
                    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                    $upload->rootPath  =     './Public/upload/comment/'; // 设置附件上传根目录
                    $upload->replace  =     true; // 存在同名文件是否是覆盖，默认为false
                    //$upload->saveName  =   'file_'.$id; // 存在同名文件是否是覆盖，默认为false
                    // 上传文件 
                    $info   =   $upload->upload();                                        
                    if(!$info) {// 上传错误提示错误信息                                                                        
                        $this->error($upload->getError());
                    }else{
                        foreach($info as $key => $val)
                        {
                            $comment_img[] = '/Public/upload/comment/'.$val['savepath'].$val['savename'];                                    
                        }
                        $comment_img = serialize($comment_img); // 上传的图片文件
                    }                     
            }  
        
            $user_info = session('user');
            $logic = new UsersLogic();

            $add['goods_id'] = I('goods_id');
            $add['email'] = $user_info['email'];
            //$add['nick'] = $user_info['nickname'];
            $add['username'] = $user_info['nickname'];
            $add['order_id'] = I('order_id');
            $add['service_rank'] = I('service_rank');
            $add['deliver_rank'] = I('deliver_rank');
            $add['goods_rank'] = I('goods_rank');
           // $add['content'] = htmlspecialchars(I('post.content'));
            $add['content'] = I('content');
            $add['img'] = $comment_img;
            $add['add_time'] = time();
            $add['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $add['user_id'] = $this->user_id;            
            
            //添加评论
            $row = $logic->add_comment($add);
            if($row[status] == 1)
            {                
                $this->success('评论成功',U('/Mobile/Goods/goodsInfo',array('id'=>$add['goods_id'])));
                exit();
            }
            else
            {
                $this->error($row[msg]);                
            }               
    }

    /*
     * 个人信息
     */
    public function info(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        if(IS_POST){
            I('post.nickname') ? $post['nickname'] = I('post.nickname') : false; //昵称
            I('post.qq') ? $post['qq'] = I('post.qq') : false;  //QQ号码
            I('post.head_pic') ? $post['head_pic'] = I('post.head_pic') : false; //头像地址
            I('post.sex') ? $post['sex'] = I('post.sex') : false;  // 性别
            I('post.birthday') ? $post['birthday'] = I('post.birthday') : false;  // 生日
            I('post.province') ? $post['province'] = I('post.province') : false;  //省份
            I('post.city') ? $post['city'] = I('post.city') : false;  // 城市
            I('post.district') ? $post['district'] = I('post.district') : false;  //地区

            if(!$userLogic->update_info($this->user_id,$post))
                $this->error("保存失败");
            $this->success("操作成功");
            exit;
        }
        //  获取省份
        $province = M('region')->where(array('parent_id'=>0,'level'=>1))->select();
        //  获取订单城市
        $city =  M('region')->where(array('parent_id'=>$user_info['province'],'level'=>2))->select();
        //  获取订单地区
        $area =  M('region')->where(array('parent_id'=>$user_info['city'],'level'=>3))->select();
//        var_dump($area);exit;

        $this->assign('province',$province);
        $this->assign('city',$city);
        $this->assign('area',$area);
        $this->assign('user',$user_info);
        $this->assign('sex',C('SEX'));
        $this->display();
    }

    /*
     * 邮箱验证
     */
    public function email_validate(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = I('get.step',1);
        //验证是否未绑定过
        if($user_info['email_validated'] == 0)
            $step = 2;
        //原邮箱验证是否通过
        if($user_info['email_validated'] == 1 && session('email_step1') == 1)
            $step = 2;
        if($user_info['email_validated'] == 1 && session('email_step1') != 1)
            $step = 1;
        if(IS_POST){
            $email = I('post.email');
            $code = I('post.code');
            $info = session('email_code');
            if(!$info)
                $this->error('非法操作');
            if($info['email'] == $email || $info['code'] == $code){
                if($user_info['email_validated'] == 0 || session('email_step1') == 1){
                    session('email_code',null);
                    session('email_step1',null);
                    if(!$userLogic->update_email_mobile($email,$this->user_id))
                        $this->error('邮箱已存在');
                    $this->success('绑定成功',U('Home/User/index'));
                }else{
                    session('email_code',null);
                    session('email_step1',1);
                    redirect(U('Home/User/email_validate',array('step'=>2)));
                }
                exit;
            }
            $this->error('验证码邮箱不匹配');
        }
        $this->assign('step',$step);
        $this->display();
    }

    /*
    * 手机验证
    */
    public function mobile_validate(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = I('get.step',1);
        //验证是否未绑定过
        if($user_info['mobile_validated'] == 0)
            $step = 2;
        //原手机验证是否通过
        if($user_info['mobile_validated'] == 1 && session('mobile_step1') == 1)
            $step = 2;
        if($user_info['mobile_validated'] == 1 && session('mobile_step1') != 1)
            $step = 1;
        if(IS_POST){
            $mobile = I('post.mobile');
            $code = I('post.code');
            $info = session('mobile_code');
            if(!$info)
                $this->error('非法操作');
            if($info['email'] == $mobile || $info['code'] == $code){
                if($user_info['email_validated'] == 0 || session('email_step1') == 1){
                    session('mobile_code',null);
                    session('mobile_step1',null);
                    if(!$userLogic->update_email_mobile($mobile,$this->user_id,2))
                        $this->error('手机已存在');
                    $this->success('绑定成功',U('Home/User/index'));
                }else{
                    session('mobile_code',null);
                    session('email_step1',1);
                    redirect(U('Home/User/mobile_validate',array('step'=>2)));
                }
                exit;
            }
            $this->error('验证码手机不匹配');
        }
        $this->assign('step',$step);
        $this->display();
    }

    //发送验证码
    public function send_validate_code(){
        $type = I('type');
        $send = I('send');
        $logic = new UsersLogic();
        $logic->send_validate_code($send, $type);
    }
    /*
     *商品收藏
     */
    public function goods_collect(){
        $userLogic = new UsersLogic();
        $data = $userLogic->get_goods_colletc($this->user_id);
        $this->assign('page',$data['show']);// 赋值分页输出
        $this->assign('lists',$data['result']);
//        var_dump($data['result']);
        $this->display();
    }

    /*
     * 删除一个收藏商品
     */
    public function del_goods_collect(){
        $id = I('get.id');
        if(!$id)
            $this->error("缺少ID参数");
        $row = M('goods_collect')->where(array('collect_id'=>$id,'user_id'=>$this->user_id))->delete();
        if(!$row)
            $this->error("删除失败");
        $this->success('删除成功');
    }

    /*
     * 密码修改
     */
    public function password(){
        //检查是否第三方登录用户
        $logic = new UsersLogic();
        $data = $logic->get_info($this->user_id);
        $user = $data['result'];
        if($user['mobile'] == ''&& $user['email'] == '')
            $this->error('请先到电脑端绑定手机',U('/Mobile/User/index'));
        if(IS_POST){
            $userLogic = new UsersLogic();
            $data = $userLogic->password($this->user_id,I('post.old_password'),I('post.new_password'),I('post.confirm_password')); // 获取用户信息
            if($data['status'] == -1)
                $this->error($data['msg']);
            $this->success($data['msg']);
            exit;
        }
        $this->display();
    }

    /**
     * 验证码验证
     * $id 验证码标示
     */
    private function verifyHandle($id)
    {
        $verify = new Verify();
        if (!$verify->check(I('post.verify_code'), $id ? $id : 'user_login')) {
            $this->error("验证码错误");
        }
    }

    /**
     * 验证码获取
     */
    public function verify()
    {
        //验证码类型
        $type = I('get.type') ? I('get.type') : 'user_login';
        $config = array(
            'fontSize' => 40,
            'length' => 4,
            'useCurve' => true,
            'useNoise' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry($type);
    }
    /**
     * 账户管理
     */
    public function accountManage()
    {
        $this->display();
    }
    
    public function order_confirm(){
        $id = I('get.id',0);
       $logic = new UsersLogic();
        $data = $logic->confirm_order($this->user_id,$id);
        if(!$data['status'])
            $this->error($data['msg']);
        $this->success($data['msg']);

    }
    
    /**
     * 模特钱包
     */
    public function mote_wallet(){
    	$this->display();
    }
    
    /**
     * 模特信息编辑 
     */
    public function moteinfo(){
    	$row = M('modelusers')->where(array('user_id'=>$this->user_id))->find();
    	if(IS_POST){
    		$data = I("post.");
    		 $r = M('modelusers')->where(array('user_id'=>$this->user_id))->save($data);
            if($r)
                exit($this->success('修改成功'));
            exit($this->error('未作内容修改或修改失败'));
    	}
    	
    	$this->assign("row",$row);
    	$this->display();
    }
    
    /**
     * 模特订单 
     */
    public function moteorder(){
    	$this->display();
    }
    
    /**
     * 模特推荐
     */
    public function moterecommend(){
    	$this->display();
    }
    
    /**
     * 模特设置报价 
     */
    public function moteoffer(){
    	$this->display();
    }
    
    /**
     * 模特设置档期 
     */
    public function setdangqi(){
    	$this->display();
    }
    
    /**
     * 模特评价 
     */
    public function mycommon(){
    	$this->display();
    }
    
    /**
     * 模特认证 
     */
    public function identify(){
    	$this->display();
    }

}