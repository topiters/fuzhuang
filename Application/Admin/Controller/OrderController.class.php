<?php
/**
 * 订单管理
 */
namespace Admin\Controller;
use Admin\Logic\OrderLogic;
use Think\AjaxPage;

class OrderController extends BaseController {
    public  $order_status;
    public  $shipping_status;
    public  $pay_status;
    /*
     * 初始化操作
     */
    public function _initialize() {
        C('TOKEN_ON',false); // 关闭表单令牌验证
        // 订单 支付 发货状态
        $this->assign('order_status',C('ORDER_STATUS'));
        $this->assign('pay_status',C('PAY_STATUS'));
        $this->assign('shipping_status',C('SHIPPING_STATUS'));
    }

    /*
     *订单首页
     */
    public function index(){
    	$begin = date('Y/m/d',(time()-30*60*60*24));//30天前
    	$end = date('Y/m/d',strtotime('+1 days')); 	
    	$this->assign('timegap',$begin.'-'.$end);
        $this->display();
    }

    /*
     *Ajax首页 2016-12-22
     */
    public function ajaxindex(){   
        $timegap = I('timegap');
        if($timegap){
        	$gap = explode('-', $timegap);
        	$begin = strtotime($gap[0]);
        	$end = strtotime($gap[1]);
        }
        // 搜索条件
        $condition = array();
        if($begin && $end){
        	$condition['add_time'] = array('between',"$begin,$end");
        }
        I('order_sn') ? $condition['order_sn'] = trim(I('order_sn')) : false;
        
        $sort_order = I('order_by','DESC').' '.I('sort');
        $count = M('order')->where($condition)->count();
        $Page  = new AjaxPage($count,20);
        //  搜索条件下 分页赋值
        foreach($condition as $key=>$val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $show = $Page->show();
        $field = array(
        	'o.order_id',
        	'o.order_sn',
        	'o.user_name',
        	'o.goods_price',
        	'o.total_amount',
        	'o.order_status',
        	'o.province',
        	'o.city',
        	'o.district',
        	'o.address',
        	'o.mobile',
        	'o.pay_name',
        	'o.add_time',
        );
        //获取订单列表
        $list = M("order")->alias("o")->field($field)->select();
        $orderList = array();
        foreach($list as $val){
        	
        	$province = M('region2')->where(array('parent_id'=>0,'level'=>1,'id'=>$val['province']))->find();
        	$city = M('region2')->where(array('parent_id'=>$val['province'],'level'=>2,'id'=>$val['city']))->find();
        	$district = M('region2')->where(array('parent_id'=>$val['city'],'level'=>3,'id'=>$val['district']))->find();
        	// 获取省份
        	$val['province'] = $province['name'];
        	//获取订单城市
        	$val['city'] = $city['name'];
        	//获取订单地区
        	$val['district'] =  $district['name'];
        	$orderList[] = $val;
        }
        $this->assign('orderList',$orderList);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    
    /*
     * ajax 发货订单列表
    */
    public function ajaxdelivery(){
    	$orderLogic = new OrderLogic();
    	$condition = array();
    	I('consignee') ? $condition['consignee'] = trim(I('consignee')) : false;
    	I('order_sn') != '' ? $condition['order_sn'] = trim(I('order_sn')) : false;
    	$condition['order_status'] = 1;
    	$shipping_status = I('shipping_status');
    	$condition['shipping_status'] = empty($shipping_status) ? array('neq',1) : $shipping_status;
    	
    	$count = M('order')->where($condition)->count();
    	$Page  = new AjaxPage($count,10);
    	//搜索条件下 分页赋值
    	foreach($condition as $key=>$val) {
    		$Page->parameter[$key]   =   urlencode($val);
    	}
    	$show = $Page->show();
    	$orderList = M('order')->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order('add_time DESC')->select();
    	$this->assign('orderList',$orderList);
    	$this->assign('page',$show);// 赋值分页输出
    	$this->display();
    }
    
    /**
     * 订单详情
     * @param int $id 订单id
     */
    public function detail(){
    	$order_id = I('order_id');
    	//订单基本信息
    	$order = M('order')->where(array('order_id'=>$order_id))->find();
    	//模特信息 
    	$mote = M('order')->alias('o')->where(array('o.order_id'=>$order_id))->join(" RIGHT JOIN __ORDER_GOODS__ og ON o.order_id = og.order_id ")->select();
    	$this->assign("mote",$mote);
    	$this->assign('order',$order);
    	$this->display();
    }

    /**
     * 订单删除
     * @param int $id 订单id
     */
    public function delete_order($order_id){
    	$del = M('order')->where(array('order_id'=>$order_id))-delete();
        if($del){
        	//删除成功,同时删除order_goods表中相关数据
            $this->success('删除订单成功');
        }else{
        	$this->error('订单删除失败');
        }
    }

    /**
     * 订单操作
     * @param $id
     */
    public function order_action(){    	
        $orderLogic = new OrderLogic();
        $action = I('get.type');
        $order_id = I('get.order_id');
        if($action && $order_id){
        	 $a = $orderLogic->orderProcessHandle($order_id,$action);       	
        	 $res = $orderLogic->orderActionLog($order_id,$action,I('note'));
        	 if($res && $a){
        	 	exit(json_encode(array('status' => 1,'msg' => '操作成功')));
        	 }else{
        	 	exit(json_encode(array('status' => 0,'msg' => '操作失败')));
        	 }
        }else{
        	$this->error('参数错误',U('Admin/Order/detail',array('order_id'=>$order_id)));
        }
    }

   

    public function export_order()
    {
    	//搜索条件
		$where = 'where 1=1 ';
		$consignee = I('consignee');
		if($consignee){
			$where .= "AND consignee like '%$consignee%' ";
		}
		$order_sn =  I('order_sn');
		if($order_sn){
			$where .= "AND order_sn = '$order_sn' ";
		}
		if(I('order_status')){
			$where .= "AND order_status = ".I('order_status');
		}
		$add_time = I('add_time');
		$sql = "select *,FROM_UNIXTIME(add_time,'%Y-%m-%d') as create_time from __PREFIX__order $where order by order_id";
		if($add_time){
			$sql = "select *,FROM_UNIXTIME(add_time,'%Y-%m-%d') as create_time from __PREFIX__order $where and create_time='$add_time' order by order_id";
		}
    	$orderList = D()->query($sql);   
    	$strTable ='<table width="500" border="1">';
    	$strTable .= '<tr>';
    	$strTable .= '<td style="text-align:center;font-size:12px;width:120px;">订单编号</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="100">日期</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">收货人</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">收货地址</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">电话</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">订单金额</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">实际支付</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付方式</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付状态</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">发货状态</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">商品信息</td>';
    	$strTable .= '</tr>';
    	
    	foreach($orderList as $k=>$val){
    		$strTable .= '<tr>';
    		$strTable .= '<td style="text-align:center;font-size:12px;">&nbsp;'.$val['order_sn'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['create_time'].' </td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['consignee'].' </td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['address'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['mobile'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['goods_price'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['order_amount'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['pay_name'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$this->pay_status[$val['pay_status']].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$this->shipping_status[$val['shipping_status']].'</td>';    
    		$orderGoods = D('order_goods')->where('order_id='.$val['order_id'])->select();
    		$strGoods="";
    		foreach($orderGoods as $goods){
    			$strGoods .= "商品编号：".$goods['goods_sn']." 商品名称：".$goods['goods_name'];
    			if ($goods['spec_key_name'] != '') $strGoods .= " 规格：".$goods['spec_key_name'];
    			$strGoods .= "<br />";
    		}
    		unset($orderGoods);
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$strGoods.' </td>';
    		$strTable .= '</tr>';
    	}
    	$strTable .='</table>';
    	unset($orderList);
    	downloadExcel($strTable,'order');
    	exit();
    }
}
