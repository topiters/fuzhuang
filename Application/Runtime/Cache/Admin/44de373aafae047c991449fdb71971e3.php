<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 --
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />   
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>    
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>        
  </head>
  <body style="background-color:#ecf0f5;">
 

<div class="wrapper">
    <!-- Content Header (Page header) -->
   <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>    
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>          
	</ol>
</div>

    <section class="content">
    <!-- Main content -->
    <!--<div class="container-fluid">-->
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> 用户信息</h3>
            </div>
            <div class="panel-body">
                <form action="" method="post" onsubmit="return checkUserUpdate(this);">
                    <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>会员昵称:</td>
                        <td><input type="text" class="form-control" name="nickname" value="<?php echo ($user["nickname"]); ?>"></td>
                    </tr>
                    <tr>
                        <td>消费积分:</td>
                        <td><?php echo ($user["pay_points"]); ?></td>
                    </tr>

                    <tr>
                        <td>邮件地址:</td>
                        <td><input type="text" class="form-control" name="email" value="<?php echo ($user["email"]); ?>"></td>
                    </tr>
                    <tr>
                        <td>新密码:</td>
                        <td><input type="password" class="form-control" name="password"></td>
                    </tr>
                    <tr>
                        <td>确认密码:</td>
                        <td><input type="password" class="form-control" name="password2"></td>
                    </tr>
                    <!--<tr>-->
                        <!--<td>会员等级:</td>-->
                        <!--<td><?php echo ($user["user_rank"]); ?></td>-->
                    <!--</tr>-->
                    <tr>
                        <td>性别:</td>
                        <td id="order-status">
                            <input name="sex" type="radio" value="0" <?php if($user['sex'] == 0): ?>checked<?php endif; ?> >保密
                            <input name="sex" type="radio" value="1" <?php if($user['sex'] == 1): ?>checked<?php endif; ?> >男
                            <input name="sex" type="radio" value="2" <?php if($user['sex'] == 2): ?>checked<?php endif; ?> >女

                        </td>
                    </tr>
                    <tr>
                        <td>QQ:</td>
                        <td>
                            <input class="form-control" type="text" name="qq" value="<?php echo ($user["qq"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>手机:</td>
                        <td>
                            <input type="text" class="form-control" name="mobile" value="<?php echo ($user["mobile"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>注册时间:</td>
                        <td>
                            <?php echo (date('Y-m-d H:i',$user["reg_time"])); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-info">
                                <i class="ace-icon fa fa-check bigger-110"></i> 保存
                            </button>
                            <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default pull-right" data-original-title="返回"><i class="fa fa-reply"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </form>

            </div>
        </div>
 	  </div> 
    </div>    <!-- /.content -->
   </section>
</div>
<script>
    function checkUserUpdate(){
        var email = $('input[name="email"]').val();
        var mobile = $('input[name="mobile"]').val();
        var password = $('input[name="password"]').val();
        var password2 = $('input[name="password2"]').val();

        var error ='';
        if(password != password2){
            error += "两次密码不一样\n";
        }

        if(!checkEmail(email)){
            error += "邮箱地址有误\n";
        }
        if(!checkMobile(mobile)){
            error += "手机号码填写有误\n";
        }
        if(error){
            layer.alert(error, {icon: 2});  //alert(error);
            return false;
        }
        return true;

    }
</script>

</body>
</html>