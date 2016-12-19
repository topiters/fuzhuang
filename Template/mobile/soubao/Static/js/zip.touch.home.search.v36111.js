;var LINK_SERVER_ERROR='连接服务器失败，请稍后再试。';var mHeaderActs={prev:function(){},ltext:function(){},title:function(){},menu:function(){},rtext:function(){}};$(document).ready(function(){var $header=$('.m_header');if($header.length){$header.on('click','.bt_menu',function(){var _menu=$('.m_menu').removeClass('hidden');_menu.off('click').on('click',function(){_mask.click();});var _mask=Model.mask({color:'#ffffff',opacity:.01,zIndex:19,time:0});_mask.click(function(){_menu.addClass('hidden');_mask.remove();});}).on('click','.bt_menu',mHeaderActs.menu).on('click','.bt_prev',mHeaderActs.prev).on('click','.bt_ltext',mHeaderActs.ltext).on('click','.bt_rtext',mHeaderActs.rtext).on('click','.bt_title',mHeaderActs.title)};});var Model=(function(){function Model(){};Model.phoneCodeTime=60;Model.verify=function(){};Model.verify.realname=function(value){value=$.trim(value);if(value=='')return'请填写收货人的姓名';if(!/^[\u4e00-\u9fa5]{2,10}$/.test(value))return'请填写正确的收货人姓名';return'';};Model.verify.address=function(value){value=$.trim(value);if(value=='')return'请填写详细的收货地址';if(!/^.{5,40}$/.test(value))return'请填写正确的收货地址';return'';};Model.verify.zipcode=function(value){value=$.trim(value);if(value!=''){if(!/^\d+$/.test(value))return'请填写正确的邮政编码';};return'';};Model.verify.phone=function(value){value=$.trim(value);if(value==''){return'手机号码不能为空';};if(!/^\d{10,11}$/.test(value)){return'手机号码格式错误';};return'';};Model.verify.email=function(value){if(value==''){return'邮箱不能为空';};if(!/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(value)){return'邮箱格式错误';};return'';};Model.verify.imgcode=function(value){value=$.trim(value);if(value==''){return'图形验证码不能为空';};if(!/^.{4}$/.test(value)){return'图形验证码格式错误';};return'';};Model.verify.phonecode=function(value){value=$.trim(value);if(value==''){return'手机验证码不能为空';};if(!/^\d{6}$/.test(value)){return'手机验证码格式错误';};return'';};Model.verify.password=function(value){value=$.trim(value);if(value==''){return'密码不能为空';};if(!/^.{6,20}$/.test(value)){return'密码为6-20位数字与字母组合，区分大小写！';};if(value.indexOf(' ')>=0){return'密码不能包含空格';};if(/^((\d+)|([a-zA-Z]+)){1}$/.test(value)){return'密码太简单，请您更改密码，如字母+数字的组合';};return'';};Model.checkStrong=(function(){function CharMode(iN){if(iN>=48&&iN<=57){return 1;}else if((iN>=65&&iN<=90)||(iN>=97&&iN<=122)){return 2;}else{return 4;};};var modes;function bitTotal(num){modes=0;for(i=0;i<3;i++){if(num&1){modes++;}
num>>>=1;};return modes;};function checkStrong(sPW){if(Model.verify.password(sPW)){return 0;};modes=0;for(i=0;i<sPW.length;i++){modes|=CharMode(sPW.charCodeAt(i));};return bitTotal(modes);};return checkStrong;})();Model.time=function(){var d,s;d=new Date();s=d.getFullYear()+"-";s=s+(((d.getMonth()+1)>9)?(d.getMonth()+1):('0'+(d.getMonth()+1)))+"-";s+=((d.getDate()>9)?d.getDate():('0'+d.getDate()))+" ";s+=((d.getHours()>9)?d.getHours():('0'+d.getHours()))+":";s+=((d.getMinutes()>9)?d.getMinutes():('0'+d.getMinutes()))+":";s+=((d.getSeconds()>9)?d.getSeconds():('0'+d.getSeconds()));return s;};Model.timestamp=function(){return(new Date()).valueOf();};Model.guid=function(){var _guid='';for(var i=1;i<=32;i++){var n=Math.floor(Math.random()*16.0).toString(16);_guid+=n;if((i==8)||(i==12)||(i==16)||(i==20)){_guid+='-';};};return _guid;};Model.promise=function(fun){var self=this;self.queues=[];self.resolve=function(){var fun=self.queues&&self.queues[0];if(fun){var ret=fun.apply(self,arguments);self.queues.shift();if(ret&&ret.toString()=='promise'){ret.queues=self.queues;}else if(ret){self.resolve.apply(self,ret);};};return self;};self.then=function(fun){if(fun.constructor!==Function)return;self.queues.push(fun);return self;};self.toString=function(){return'promise';};if(fun)self.then(fun);};Model.mask=function(op){op=$.extend({color:'#000000',opacity:.5,zIndex:1000,time:500},op);return $('<div class="m_mask"></div>').css({'background-color':op.color,'opacity':op.opacity,'z-index':op.zIndex}).appendTo('body').fadeIn(op.time);};Model.message=function(message,time){time=time||3000;var message=$('<div class="m_message text-v">'+message+'</div>').appendTo('body');message.css({'margin-left':-message.width()/2,'margin-top':-message.height()/2});var isclose=false;var _setTimeout;if(time!=0){_setTimeout=setTimeout(function(){if(isclose)return;isclose=true;message.fadeOut(500,function(){message.remove();});},time);};return{close:function(){if(isclose)return;isclose=true;clearTimeout(_setTimeout);message.fadeOut(500,function(){message.remove();});},element:message};};Model.dialog=function(message,buttons){var _mask=Model.mask();var _dialog=$('<div class="m_dialog"><div class="content">'+message+'</div><div class="buttons"></div></div>').appendTo('body');var $buttons=_dialog.children('.buttons');$.each(buttons||[],function(index,button){button.click=button.click||function(){};$('<a class="m_button m_button_'+button.type+'" href="javascript:void(0)">'+button.text+'</a>').appendTo($buttons).click(button.click);});if(buttons.length==1){$buttons.addClass('only_one');};_dialog.css('margin-top',-_dialog.height()/2);return{close:function(){_dialog.remove();_mask.remove();},element:_dialog};};Model.confirm=function(message,callback,type){var dialog=Model.dialog(message,[{text:'取消',click:function(){dialog.close();}},{text:'确认',click:function(){if(callback){callback();};dialog.close();},type:type||'orange'}]);return dialog;};Model.alert=function(message,callback){var dialog=Model.dialog(message,[{text:'确认',click:function(){if(callback){callback();};dialog.close();},type:'orange'}]);return dialog;};return Model;})();if($('#js_lib_content').length){function resize(){$('#js_lib_content').css('min-height',($(window).height()-$('.m_header').height()-$('.m_footer').height())+'px');};$(window).resize(resize);resize();};$('.m_checkbox input[type="checkbox"],.m_radio input[type="radio"]').each(function(){if($(this).prop('checked')){$(this).parent().addClass('m_checked');}else{$(this).parent().removeClass('m_checked');};});$('.m_order_checkbox input[type="checkbox"]').each(function(){if($(this).prop('checked')){$(this).parent().addClass('m_checked');}else{$(this).parent().removeClass('m_checked');};});$('.m_setting input[type="checkbox"]').each(function(){if($(this).parent().hasClass('m_setting_password')){if($(this).prop('checked')){$(this).parent().addClass('m_settinged m_settinged_password');}else{$(this).parent().removeClass('m_settinged m_settinged_password');};}else{if($(this).prop('checked')){$(this).parent().addClass('m_settinged');}else{$(this).parent().removeClass('m_settinged');};};});$('.m_list input[type="text"],.m_list input[type="password"],.m_list textarea').each(function(){$(this).parent().find('.right .m_icon_del').hide();});$('.m_list .password .right .m_setting input[type="checkbox"]').each(function(){if($(this).prop('checked')){$(this).parent().parent().parent().children('input[type="password"],input[type="password"]').attr('type','text');}else{$(this).parent().parent().parent().children('input[type="password"],input[type="password"]').attr('type','password');};});$('.m_select select').each(function(index,el){if($(this).val()!=''&&$(this).val()!='0'){$(this).prev().html($(this).children('option:selected').html()).removeClass('gray');}else{$(this).prev().html($(this).children('option:selected').html()).addClass('gray');};});$('body').on('keyup','.m_list input[type="text"],.m_list input[type="password"],.m_list select,.m_list textarea',function(event){if(event.keyCode=='13'){var btn=$('#'+$(this).parents('.m_list').first().attr('from-submit')+':visible');if(!btn.hasClass('disabled')&&btn.attr('disabled')==null){btn.click();};};}).on('change','.m_radio input[type="radio"]',function(event){if($(this).prop('checked')){var name=$(this).attr('name');if(name){$('.m_radio input[type="radio"][name="'+name+'"]').each(function(){if($(this).prop('checked')){$(this).parent().addClass('m_checked');}else{$(this).parent().removeClass('m_checked');};});};$(this).parent().addClass('m_checked');}else{$(this).parent().removeClass('m_checked');};}).on('change','.m_checkbox input[type="checkbox"]',function(event){if($(this).prop('checked')){$(this).parent().addClass('m_checked');}else{$(this).parent().removeClass('m_checked');};}).on('change','.m_setting input[type="checkbox"]',function(event){if($(this).parent().hasClass('m_setting_password')){if($(this).prop('checked')){$(this).parent().addClass('m_settinged m_settinged_password');}else{$(this).parent().removeClass('m_settinged m_settinged_password');};}else{if($(this).prop('checked')){$(this).parent().addClass('m_settinged');}else{$(this).parent().removeClass('m_settinged');};};}).on('focus keyup','.m_list input[type="text"],.m_list input[type="password"],.m_list textarea',function(){if($(this).prop('readonly')||$(this).prop('disabled'))return;var value=$.trim($(this).val());if(!value){$(this).parent().find('.right .m_icon_del').hide();}else{$(this).parent().find('.right .m_icon_del').show();};}).on('blur','.m_list input[type="text"],.m_list input[type="password"],.m_list textarea',function(){$(this).parent().find('.right .m_icon_del').fadeOut(100);}).on('touchend mouseup','.m_list .right .m_icon_del',function(event){$(this).parent().parent().children('input[type="text"],input[type="password"],textarea').val('').change().focus();}).on('click','.m_list .imgcode .right .m_icon_reload',function(event){var src=$(this).prev().attr('data-src');$(this).prev().attr('src',src.replace(/@time/gim,Model.timestamp()));}).on('click','.m_list .imgcode .right img',function(event){var src=$(this).attr('data-src');$(this).attr('src',src.replace(/@time/gim,Model.timestamp()));}).on('change','.m_list .password .right .m_setting input[type="checkbox"]',function(event){if($(this).prop('checked')){$(this).parent().parent().parent().children('input[type="text"],input[type="password"]').attr('type','text');}else{$(this).parent().parent().parent().children('input[type="text"],input[type="password"]').attr('type','password');};}).on('change','.m_list .select-text select',function(event){$(this).parent().children('input[type="text"]').val($(this).val());}).on('change','.m_list .select-text input[type="text"]',function(event){$(this).parent().children('select').val('');}).on('change','.m_select select',function(event){if($(this).val()!=''&&$(this).val()!='0'){$(this).prev().html($(this).children('option:selected').html()).removeClass('gray');}else{$(this).prev().html($(this).children('option:selected').html()).addClass('gray');};}).on('click','#js_classify_all',function(){var $list=$(this).next('#js_classify_list');if($(this).data('open')=='no'){$list.removeClass('hidden').animate({'top':'0.93rem'},500);$(this).data('open','yes');Model.mask({color:'#000000',opacity:.5,zIndex:1,time:500});}else{$list.animate({'top':'0'},300).addClass('hidden');$(this).data('open','no');$(".m_mask").hide();}}).on('change','.m_order_checkbox input[type="checkbox"]',function(event){if($(this).prop('checked')){$(this).parent().addClass('m_checked');$('.m_opera').each(function(){$(this).data('select','on').addClass('selected');});}else{$(this).parent().removeClass('m_checked');$('.m_opera').each(function(){$(this).data('select','off').removeClass('selected');});};}).on('click','.m_opera',function(event){if($(this).data('select')=='off'){$(this).data('select','on').addClass('selected');}else{$(this).data('select','off').removeClass('selected');};});var goodsid_str='';$('body').on('click','#js_goods_delete',function(){$('#goods_list').addClass('show_delete');$('.goods_bottom').animate({"opacity":"1"},300);$(this).addClass('hidden');$('#js_delete_goods_ok').removeClass('hidden');}).on('click','#js_cancel',function(){$('.m_opera').each(function(){$(this).data('select','off').removeClass('selected');});}).on('click','#js_delete_goods_ok',function(){$('#goods_list').removeClass('show_delete');$('.goods_bottom').animate({"opacity":"0"},300);window.location.reload();}).on('click','#js_goods_maybe_delete',function(){var url=$('#js_goods_maybe_delete').data('url');$('.m_opera').each(function(){var goodsid=$(this).parent('.m_goods_cell').data('goodsid');if($(this).data('select')=='on'){goodsid_str=goodsid_str+goodsid+',';$(this).parent('.m_goods_cell').remove();};});if(goodsid_str==''){Model.message('请选择商品',1000);}else{$.ajax({url:url,type:'post',data:{goodsid_str:goodsid_str},dataType:'json',error:function(){Model.alert('服务器连接失败');},success:function(data){if(data.IsSuccess){Model.message("删除成功");if(data.isEmpty){window.location.reload();}}else{Model.message(data.Message);}}});}}).on('click','.m_icon_gotop',function(event){$(window).scrollTop(0);return false;});$('#js_order_search').click(function(){$('#js_order_searchbox').animate({'display':'block'},300);Model.mask({color:'#000000',opacity:.5,zIndex:10,time:300});});$('#js_search_cancel').click(function(){$('#js_order_searchbox').animate({'display':'none'},300);$(".m_mask").hide();})
$('#js_search_input').keyup(function(){if($(this).val()!=''){$("#js_search_cancel").addClass('hidden');$("#js_search_ok").removeClass('hidden');}else{$("#js_search_cancel").removeClass('hidden');$("#js_search_ok").addClass('hidden');}});var _notice_count=$('.p_notice_list li').length;var _count_i=1;function notice(){$('.p_notice_list').animate({'margin-top':'-'+(0.6*_count_i)+'rem'},500);if(_notice_count==1){$('.p_notice_list').css('margin-top','0');_notice_count=$('.p_notice_list li').length+1;_count_i=0;}
_notice_count--;_count_i++;}
var notice=setInterval(notice,3000);$(document).ready(function(){try{$('img[truesrc]').lazyload({threshold:$(window).height()});}
catch(ex){};});var loadings=[];$('.m_loading').each(function(index,el){loadings.push($(this));});function _run_loading($el,index){if($el.hasClass('m_loaded')){var url=$el.removeClass('m_loaded m_manually').data('url');var lastid=$el.data('lastid');var listid=$el.data('listid');var templateid=$el.data('template');window['TEMPLATE_D']=window['TEMPLATE_D']||{};var _template=window['TEMPLATE_D'][templateid]||(window['TEMPLATE_D'][templateid]=template.compile($('#'+templateid).html()));url=url.replace(/@lastid/g,lastid);$.ajax({url:url,dataType:'json',error:function(){$el.addClass('m_loaded');if(index!=null){loadings.splice(index,1);};},success:function(data){if(data.notMessage){if(window['add_class']){$('.lib_content .'+add_class).html(data.notMessage);}else{$('.lib_content').html(data.notMessage);}}else{if($el.data('count')){$el.data('count',$el.data('count')+1);}else{$el.data('count',1);};$el.addClass('m_loaded');$('#'+listid).append(_template({data:data})).find('img[truesrc]').lazyload({threshold:$(window).height()});if(data.isend==0){$el.data('lastid',data.lastid);if($el.data('count')>=999999){if(index!=null){loadings.splice(index,1);};$el.addClass('m_manually');if(!$el.children('a').length){$el.html('<a class="m_button m_button_radius js_check_more" href="javascript:void(0);">查看更多<i class="m_icon m_icon_loading"></i></a>');};if(!$el.data('bindclick')){$el.data('bindclick',true);$el.children('a.m_button_radius').click(function(){_run_loading($el);});};};}else{if(index!=null){loadings.splice(index,1);};};};}});};};var $gotop=$('.m_icon_gotop');function run_loading(){var height=$(window).height();var top=$(window).scrollTop();if(top>height/2){$gotop.removeClass('hidden');}else{$gotop.addClass('hidden');};var bottom=top+height*1.5;top-=height*.5;$.each(loadings,function(index,$el){var _top=$el.offset().top;if(_top>bottom){return false;}else if(_top>top){_run_loading($el,index);};});};$(window).scroll(run_loading);run_loading();;;;
/*!art-template - Template Engine | http://aui.github.com/artTemplate/*/
!function(){function a(a){return a.replace(t,"").replace(u,",").replace(v,"").replace(w,"").replace(x,"").split(y)}function b(a){return"'"+a.replace(/('|\\)/g,"\\$1").replace(/\r/g,"\\r").replace(/\n/g,"\\n")+"'"}function c(c,d){function e(a){return m+=a.split(/\n/).length-1,k&&(a=a.replace(/\s+/g," ").replace(/<!--[\w\W]*?-->/g,"")),a&&(a=s[1]+b(a)+s[2]+"\n"),a}function f(b){var c=m;if(j?b=j(b,d):g&&(b=b.replace(/\n/g,function(){return m++,"$line="+m+";"})),0===b.indexOf("=")){var e=l&&!/^=[=#]/.test(b);if(b=b.replace(/^=[=#]?|[\s;]*$/g,""),e){var f=b.replace(/\s*\([^\)]+\)/,"");n[f]||/^(include|print)$/.test(f)||(b="$escape("+b+")")}else b="$string("+b+")";b=s[1]+b+s[2]}return g&&(b="$line="+c+";"+b),r(a(b),function(a){if(a&&!p[a]){var b;b="print"===a?u:"include"===a?v:n[a]?"$utils."+a:o[a]?"$helpers."+a:"$data."+a,w+=a+"="+b+",",p[a]=!0}}),b+"\n"}var g=d.debug,h=d.openTag,i=d.closeTag,j=d.parser,k=d.compress,l=d.escape,m=1,p={$data:1,$filename:1,$utils:1,$helpers:1,$out:1,$line:1},q="".trim,s=q?["$out='';","$out+=",";","$out"]:["$out=[];","$out.push(",");","$out.join('')"],t=q?"$out+=text;return $out;":"$out.push(text);",u="function(){var text=''.concat.apply('',arguments);"+t+"}",v="function(filename,data){data=data||$data;var text=$utils.$include(filename,data,$filename);"+t+"}",w="'use strict';var $utils=this,$helpers=$utils.$helpers,"+(g?"$line=0,":""),x=s[0],y="return new String("+s[3]+");";r(c.split(h),function(a){a=a.split(i);var b=a[0],c=a[1];1===a.length?x+=e(b):(x+=f(b),c&&(x+=e(c)))});var z=w+x+y;g&&(z="try{"+z+"}catch(e){throw {filename:$filename,name:'Render Error',message:e.message,line:$line,source:"+b(c)+".split(/\\n/)[$line-1].replace(/^\\s+/,'')};}");try{var A=new Function("$data","$filename",z);return A.prototype=n,A}catch(B){throw B.temp="function anonymous($data,$filename) {"+z+"}",B}}var d=function(a,b){return"string"==typeof b?q(b,{filename:a}):g(a,b)};d.version="3.0.0",d.config=function(a,b){e[a]=b};var e=d.defaults={openTag:"<%",closeTag:"%>",escape:!0,cache:!0,compress:!1,parser:null},f=d.cache={};d.render=function(a,b){return q(a,b)};var g=d.renderFile=function(a,b){var c=d.get(a)||p({filename:a,name:"Render Error",message:"Template not found"});return b?c(b):c};d.get=function(a){var b;if(f[a])b=f[a];else if("object"==typeof document){var c=document.getElementById(a);if(c){var d=(c.value||c.innerHTML).replace(/^\s*|\s*$/g,"");b=q(d,{filename:a})}}return b};var h=function(a,b){return"string"!=typeof a&&(b=typeof a,"number"===b?a+="":a="function"===b?h(a.call(a)):""),a},i={"<":"&#60;",">":"&#62;",'"':"&#34;","'":"&#39;","&":"&#38;"},j=function(a){return i[a]},k=function(a){return h(a).replace(/&(?![\w#]+;)|[<>"']/g,j)},l=Array.isArray||function(a){return"[object Array]"==={}.toString.call(a)},m=function(a,b){var c,d;if(l(a))for(c=0,d=a.length;d>c;c++)b.call(a,a[c],c,a);else for(c in a)b.call(a,a[c],c)},n=d.utils={$helpers:{},$include:g,$string:h,$escape:k,$each:m};d.helper=function(a,b){o[a]=b};var o=d.helpers=n.$helpers;d.onerror=function(a){var b="Template Error\n\n";for(var c in a)b+="<"+c+">\n"+a[c]+"\n\n";"object"==typeof console&&console.error(b)};var p=function(a){return d.onerror(a),function(){return"{Template Error}"}},q=d.compile=function(a,b){function d(c){try{return new i(c,h)+""}catch(d){return b.debug?p(d)():(b.debug=!0,q(a,b)(c))}}b=b||{};for(var g in e)void 0===b[g]&&(b[g]=e[g]);var h=b.filename;try{var i=c(a,b)}catch(j){return j.filename=h||"anonymous",j.name="Syntax Error",p(j)}return d.prototype=i.prototype,d.toString=function(){return i.toString()},h&&b.cache&&(f[h]=d),d},r=n.$each,s="break,case,catch,continue,debugger,default,delete,do,else,false,finally,for,function,if,in,instanceof,new,null,return,switch,this,throw,true,try,typeof,var,void,while,with,abstract,boolean,byte,char,class,const,double,enum,export,extends,final,float,goto,implements,import,int,interface,long,native,package,private,protected,public,short,static,super,synchronized,throws,transient,volatile,arguments,let,yield,undefined",t=/\/\*[\w\W]*?\*\/|\/\/[^\n]*\n|\/\/[^\n]*$|"(?:[^"\\]|\\[\w\W])*"|'(?:[^'\\]|\\[\w\W])*'|\s*\.\s*[$\w\.]+/g,u=/[^\w$]+/g,v=new RegExp(["\\b"+s.replace(/,/g,"\\b|\\b")+"\\b"].join("|"),"g"),w=/^\d[^,]*|,\d[^,]*/g,x=/^,+|,+$/g,y=/^$|,+/;"function"==typeof define?define(function(){return d}):"undefined"!=typeof exports?module.exports=d:this.template=d}();;;;(function($){var Queue=[];function loadimg(isimg,src,$element,srcProperty,outtime){try{var $img=$('<img/>').load(load).error(load);function load(){clearTimeout(_setTimeout);$img.unbind('load error');$img.remove();if(isimg){$element.attr('src',src).removeAttr(srcProperty);if($element.next().length&&$element.next()[0].nodeName.toUpperCase()=='DFN'){$element.parent().css({'background-image':'none'});};if($element.css('display')!='none'){$element.hide().stop(true,true).fadeIn();};}else{$element.css('background-image','url('+src+')').removeAttr(srcProperty);if($element.css('display')!='none'){$element.hide().stop(true,true).fadeIn();};};};var _setTimeout=setTimeout(load,outtime);$img.appendTo('body').hide().attr('src',src);}
catch(ex){if(isimg){$element.attr('src',src).removeAttr(srcProperty);if($element.next().length&&$element.next()[0].nodeName.toUpperCase()=='DFN'){$element.parent().css({'background-image':'none'});};}else{$element.css('background-image','url('+src+')').removeAttr(srcProperty);};};};function _run(lazyloadData){var length=0;if(length=lazyloadData.elements.length){var top=0;var left=0;var scrollTop=$(lazyloadData.settings.container).scrollTop()-lazyloadData.settings.threshold;var scrollLeft=$(lazyloadData.settings.container).scrollLeft()-lazyloadData.settings.threshold;var containerHeight=$(lazyloadData.settings.container).height()+lazyloadData.settings.threshold*2;var containerWidth=$(lazyloadData.settings.container).width()+lazyloadData.settings.threshold*2;if(lazyloadData.settings.container!==window){top=$(lazyloadData.settings.container).offset().top;left=$(lazyloadData.settings.container).offset().left;};for(var i=0;i<length;){var _top=lazyloadData.elements[i].offset().top-top;var _height=lazyloadData.elements[i].height();var _left=lazyloadData.elements[i].offset().left-left;var _width=lazyloadData.elements[i].width();if(_top>scrollTop+containerHeight){if(lazyloadData.settings.absolute){if(lazyloadData.settings.mode==='Row'){i+=lazyloadData.settings.rowItemNum;}else{i++;};}else{i=length;};}else if(_top+_height<scrollTop){if(lazyloadData.settings.mode==='Row'){i+=lazyloadData.settings.rowItemNum;}else{i++;};}else{length--;var _count=1;if(lazyloadData.settings.mode==='Row'){_count=lazyloadData.settings.rowItemNum;};while(_count--){var src=lazyloadData.elements[i].attr(lazyloadData.settings.srcProperty);var type=lazyloadData.elements[i][0].nodeName.toUpperCase();if(src){loadimg(type==='IMG',src,lazyloadData.elements[i],lazyloadData.settings.srcProperty,lazyloadData.settings.outTime);}else if(type!=='IMG'){lazyloadData.elements[i].find('['+lazyloadData.settings.srcProperty+']').each(function(){loadimg($(this)[0].nodeName.toUpperCase()==='IMG',$(this).attr(lazyloadData.settings.srcProperty),$(this),lazyloadData.settings.srcProperty,lazyloadData.settings.outTime);});};lazyloadData.elements.splice(i,1);}}};};};function windowscrollrun(lazyloadData){if(lazyloadData){_run(lazyloadData);}else{for(var i=Queue.length-1;i>=0;i--){if(Queue[i].elements.length){_run(Queue[i]);}else{Queue.splice(i,1);};};}};function windowscroll(){var _setTimeout=null;$(window).scroll(function(event){clearTimeout(_setTimeout);_setTimeout=setTimeout(function(){windowscrollrun();},100);});windowscroll=function(){};};$.fn.lazyload=function(options){var self=this;var settings={mode:'Single',itemSelecter:'>*',rowItemNum:1,threshold:0,container:window,outTime:5000,srcProperty:'truesrc',absolute:false};if(options){$.extend(settings,options);};var elements=[];if(settings.mode==='Row'){$(self).find(settings.itemSelecter).each(function(){elements.push($(this));});}else{$(self).each(function(){elements.push($(this));});};if(settings.container!==window){var _setTimeout=null;$(settings.container).scroll(function(){clearTimeout(_setTimeout);_setTimeout=setTimeout(function(){windowscrollrun({settings:settings,elements:elements});},100);});windowscrollrun({settings:settings,elements:elements});}else{Queue.push({settings:settings,elements:elements});windowscrollrun(Queue[Queue.length-1]);};windowscroll();return this;};})(jQuery);;;;var _url='';var text='';var _template=template.compile($('#tpl_search_list').html());$('.m_home_search').on('focus',function(){_url=$(this).data('url');}).on('blur',function(){text=$(this).val();if(text==''){$('#js_search').removeClass('hidden');$('#js_search_list').addClass('hidden');$('#js_clear').removeClass('hidden');}else{$('#js_search').addClass('hidden');$('#js_search_list').removeClass('hidden');$('#js_clear').addClass('hidden');}}).on('keyup',function(){text=$(this).val();if(text==''){$('#js_search').removeClass('hidden');$('#js_search_list').addClass('hidden');$('#js_clear').removeClass('hidden');}else{$('#js_search').addClass('hidden');$('#js_search_list').removeClass('hidden');$('#js_clear').addClass('hidden');}
$.ajax({url:_url,type:'post',data:{text:text},dataType:'json',error:function(){},success:function(data){$('#js_search_list').html(_template({data:data}));}});});$('#js_clear').on('click',function(){var url=$(this).data('url');var ids='';$('#js_clear_search_list li').each(function(index,element){ids+=$(this).data('id')+',';});$.ajax({url:url,type:'post',data:{goodsids:ids},dataType:'json',error:function(){Model.alert('服务器连接失败')},success:function(data){window.location.reload();}});});$('body').on('click','#js_search_list li',function(){$('.m_home_search').val($(this).find('a').html());$('#search_jump_to').submit();});