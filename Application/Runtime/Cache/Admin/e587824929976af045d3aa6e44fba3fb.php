<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>tpshop管理后台</title>
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
  <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>    
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>          
	</ol>
</div>
 
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-list"></i> <?php if($t == 'pc'): ?>PC端<?php else: ?>手机端<?php endif; ?>模板</h3>
        </div>
        <div class="panel-body">
        <!-- 模板列表 -->
            <div class="row">                
		    <?php if(is_array($template_config)): foreach($template_config as $k=>$val): ?><div class="col-sm-6 col-md-4">
                     <style>
                         .thumbnail img{ width:460px; height:270px; }
                     </style>
                   <div class="thumbnail">
                     <img src="/Template/<?php echo ($t); ?>/<?php echo ($k); ?>/<?php echo ($val['img']); ?>" />
                     <div class="caption">
                       <h3><?php echo ($val['name']); ?></h3>
                       <p><?php echo ($val['remark']); ?></p>
                       <p>                                
                           <?php if($default_theme == $k): ?><a href="<?php echo U('Admin/Template/changeTemplate',array('key'=>$k,'t'=>$t));?>" class="btn btn-success" role="button">启用</a> 
                           <?php else: ?> 
                           <a href="<?php echo U('Admin/Template/changeTemplate',array('key'=>$k,'t'=>$t));?>" class="btn btn-default" role="button">启用</a><?php endif; ?>                                
                       </p>
                     </div>
                   </div>
                 </div><?php endforeach; endif; ?>         
            </div>
        <!-- 模板列表 end-->
        </div>
      </div>
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<!-- /.content-wrapper --> 
</body>
</html>