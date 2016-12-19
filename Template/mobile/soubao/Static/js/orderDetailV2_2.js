define("api/order",["config/url"],function(e){return{adminOrder:{url:e.sappsDomain+"order/AdminOrder",isOnlyData:1,post:{apiVersion:e.apiVersion,areaCode:"?",token:"?",body:"??"},body:{areaCode:"?",action:"?",orderId:"?",pay_code:"?",consignee:"?",pointId:"?",isCouponUsed:"?",card_used:"?",invoiceType:"?",invoiceTitle:"?",invoiceKind:"?",is_seperate:"?",group_id:"?",osType:"?",is_sensitive:"?",ticket:"?",pcash:"?",has_captcha:"?",captcha:"?",pay_pwd:"?","package":"?",vouchers:"?",use_score:"?",cookie_id:"",channel_edm_code:"?",channel_adr_id:"?",channel_alliance_id:"?",is_overseas:"?",merchant_id:"?",overseas_mode:"?",overseas_customs:"?",overseas_provider:"?",is_vvip:"?",ogno:"?",ogseq:"?",shop_point:"?",verification_code:"?",vvip_pwd:"?",card_number:"?",pre_sale_type:"?",mobile:"?"},method:"post"},orderList:{apiName:"orderGetorderlist",isOnlyData:1,post:{apiVersion:e.apiVersion,areaCode:"?",token:"?",body:"??"},body:{onePageSize:"?",pageIndex:"?",orderType:"?",isGroup:"?"},method:"post"},returnList:{url:e.mDomain+"api/ReturnOrderList/Index",isOnlyData:1,post:{apiVersion:e.apiVersion,areaCode:"?",token:"?",body:"??"},body:{onePageSize:"?",pageIndex:"?",orderType:"?"},method:"post"},orderDetail:{apiName:"orderGetorderdetail",isOnlyData:1,post:{areaCode:"?",token:"?",body:"??"},body:{orderId:"?"},method:"post"},returnDetail:{apiName:"orderGetreturndetail",isOnlyData:1,post:{areaCode:"?",token:"?",body:"??"},body:{orderId:"?",returnId:"?"},method:"post"},supplierReturnDetail:{url:e.mDomain+"api/ReturnOrderDetail/SupplierReturnDetail",isOnlyData:1,post:{apiVersion:e.apiVersion,token:"?",body:"??"},body:{id:"?"},method:"post"},getShipDetail:{apiName:"orderGetshipdetail",isOnlyData:1,post:{areaCode:"?",token:"?",body:"??"},body:{orderId:"?",pick_seq:"?"},method:"post"},getShipDetailV2:{apiName:"orderGetshipdetail",isOnlyData:1,post:{areaCode:"?",token:"?",body:"??"},body:{orderId:"?",dsNo:"?",subOrdersId:"?"},method:"post"},getOrderSummary:{apiName:"orderGetordersummary",isOnlyData:1,post:{areaCode:"?",token:"?",body:""},method:"post"},getReturnAdminOrder:{apiName:"orderGetreturnadminorder",isOnlyData:1,post:{areaCode:"?",token:"?",body:"??"},body:{orderId:"?"},method:"post"},confirmReceived:{apiName:"orderConfirmreceived",isOnlyData:1,post:{areaCode:"?",token:"?",body:"??"},body:{type:"",orderId:"",package_info:""},method:"post"},deleteOrder:{apiName:"orderInvisibleorder",isOnlyData:1,post:{apiVersion:e.apiVersion,areaCode:"?",token:"?",body:"??"},body:{ogSeq:"?"},method:"post"},getVvipCardList:{url:e.sappsDomain+"vvip/getVvipCardNumList",isOnlyData:1,post:{apiVersion:e.apiVersion,token:"?",body:"??"},body:{},method:"post"},delVvipCard:{url:e.sappsDomain+"vvip/delVvipCardNums",isOnlyData:1,post:{apiVersion:e.apiVersion,token:"?",body:"??"},body:{plseq:"?"},method:"post"},addVvipCard:{url:e.sappsDomain+"vvip/addVvipCardNum",isOnlyData:1,post:{apiVersion:e.apiVersion,token:"?",body:"??"},body:{card_num:"?"},method:"post"},getShopPoint:{url:e.sappsDomain+"vvip/getVvipShopPoint",isOnlyData:1,post:{apiVersion:e.apiVersion,token:"?",body:"??"},body:{card_num:"?"},method:"post"},getCellPhoneCheckCode:{url:e.sappsDomain+"vvip/getVerificationCode",isOnlyData:1,post:{apiVersion:e.apiVersion,token:"?",body:"??"},body:{card_num:"?",shop_point:"?",is_overseas:"?",zip:"?",is_seperate:"?",group_act_seq:"?",group_seq:"?",card_used:"?",vouchers:"?",use_score:"?"},method:"post"}}}),define("model/order",["lib/common","api/order"],function(e,t){function n(){var t={token:e.cookie.getH5("token"),areaCode:e.cookie.getH5("siteid"),body:{onePageSize:10,pageIndex:1,orderType:1}};return t}function r(n,r){var i={token:e.cookie.getH5("token"),areaCode:e.cookie.getH5("siteid"),body:{areaCode:"",action:1,orderId:"",pay_code:"",consigee:"",pointId:"",isCouponUsed:0,isCardUsed:0,invoiceType:0,invoiceTitle:"",isSeperate:1,osType:3,is_sensitive:"",ticket:"",pcash:"",has_captcha:0,captcha:"",order_flag:"",channel_edm_code:"",channel_adr_id:"",channel_alliance_id:""}},n=n||{};n.body&&e.merge(i.body,n.body),e.xsr(e.makeUrl(t.adminOrder,i),function(e){try{r&&r(e)}catch(t){throw t}})}function i(r,i){var s=n(),r=r||{};r.body&&e.merge(s.body,r.body),e.xsr(e.makeUrl(t.orderList,s),function(e){try{i&&i(e)}catch(t){throw t}})}function s(r,i){var s=n(),r=r||{};r.body&&e.merge(s.body,r.body),e.xsr(e.makeUrl(t.returnList,s),function(e){try{i&&i(e)}catch(t){throw t}})}function o(r,i){var s=n(),r=r||{};r.body&&e.merge(s.body,r.body),e.xsr(e.makeUrl(t.orderDetail,s),function(e){try{i&&i(e)}catch(t){throw t}})}function u(r,i){var s=n(),r=r||{};r.body&&e.merge(s.body,r.body),e.xsr(e.makeUrl(t.returnDetail,s),function(e){try{i&&i(e)}catch(t){throw t}})}function a(r,i){var s=n(),r=r||{};r.body&&e.merge(s.body,r.body),e.xsr(e.makeUrl(t.supplierReturnDetail,s),function(e){try{i&&i(e)}catch(t){throw t}})}function f(n,r){var i={token:e.cookie.getH5("token"),areaCode:e.cookie.getH5("siteid"),body:{}},n=n||{};n.body&&e.merge(i.body,n.body),e.xsr(e.makeUrl(t.getOrderSummary,i),function(e){try{r&&r(e)}catch(t){throw t}})}function l(n,r){var i={token:e.cookie.getH5("token"),areaCode:e.cookie.getH5("siteid"),body:{orderId:""}},n=n||{};n.body&&e.merge(i.body,n.body),e.xsr(e.makeUrl(t.getReturnAdminOrder,i),function(e){try{r&&r(e)}catch(t){throw t}})}function c(r,i,s){var o=n(),i=i||{};i.body&&e.merge(o.body,i.body),e.xsr(e.makeUrl(t[r],o),function(e){try{s&&s(e)}catch(t){throw t}})}function h(n,r){var i={token:e.cookie.getH5("token"),areaCode:e.cookie.getH5("siteid"),body:{type:"",orderId:"",package_info:""}},n=n||{};n.body&&e.merge(i.body,n.body),e.xsr(e.makeUrl(t.confirmReceived,i),function(e){try{r&&r(e)}catch(t){throw t}})}function p(n,r){var i={token:e.cookie.getH5("token"),areaCode:e.cookie.getH5("siteid"),body:{ogSeq:""}},n=n||{};n.body&&e.merge(i.body,n.body),e.xsr(e.makeUrl(t.deleteOrder,i),function(e){try{r&&r(e)}catch(t){throw t}})}return{createOrder:r,getOrderList:i,getOrderDetail:o,getReturnDetail:u,getSupplierReturnDetail:a,getOrderSummary:f,getReturnAdminOrder:l,confirmReceived:h,ge:c,getReturnOrderList:s,deleteOrder:p}}),define("widget/popAlert",["lib/common"],function(e){function t(t,n,r){if(typeof t=="undefined")return"";var i=n?"popbg tmbg":"popbg",r=r||3e3;window.popAlertIndex=(window.popAlertIndex||0)+1;var s="popalert_"+window.popAlertIndex,o=['<div class="'+i+'" id="'+s+'" >','<div class="popbox">','<p class="poptxt">'+t+"</p>","</div></div>"].join("");e("body").append(o);var u=e("#"+s);u.on("click",function(){u.remove()}),setTimeout(function(){u.remove()},r)}function n(t,n,r){if(typeof t=="undefined")return"";window.popAlertIndex=(window.popAlertIndex||0)+1;var i="popalert_"+window.popAlertIndex,s="close_popalert_"+window.popAlertIndex,o="fun_popalert_"+window.popAlertIndex,u=s,a="",f="";typeof n=="function"&&(u=o,a='<p id="'+s+'">取消</p>',f='<p class="poptip">提示</p>');var l=['<div class="popbg" id="'+i+'">','<div class="popbox">',f,'<p class="poptxt">'+t+"</p>",'<div class="popbtnbox">',a,'<p id="'+u+'">确定</p>',"</div></div></div>"].join("");e("body").append(l);var c=e("#"+i);e("#"+s).on("click",function(){c.remove()}),e("#"+o).on("click",function(){n(r),c.remove()})}function r(t,n,r,i){if(typeof t=="undefined")return"";if(typeof n=="undefined")return"";window.popAlertIndex=(window.popAlertIndex||0)+1;var s="popalert_"+window.popAlertIndex,o="close_popalert_"+window.popAlertIndex,u="fun_popalert_"+window.popAlertIndex,a=o,f="",l="";typeof i=="function"&&(a=u,f='<p id="'+o+'">取消</p>',l='<p class="poptip">'+t+"</p>");var c=['<div class="popbg" id="'+s+'">','<div class="popbox">',l,'<input type="'+r+'" class="popinput" placeholder="'+n+'" />','<div class="popbtnbox">',f,'<p id="'+a+'">确定</p>',"</div></div></div>"].join("");e("body").append(c);var h=e("#"+s);e("#"+o).on("click",function(){h.remove()}),e("#"+u).on("click",function(){i(),h.remove()})}function i(t){if(typeof t.msg=="undefined")return"";if(typeof t.one=="undefined"||typeof t.one.name=="undefined")return"";var n="",r="";t.icon&&t.icon.isIcon&&(n=t.icon.iconClass?t.icon.iconClass:"situs",r='<i class="'+n+'"></i>');var i=t.tip?t.tip:"提示";window.popAlertIndex=(window.popAlertIndex||0)+1;var s="popalert_"+window.popAlertIndex,o="one_popalert_"+window.popAlertIndex,u="two_popalert_"+window.popAlertIndex,a=t.popClass||"",f="";t.one&&(f+='<p id="'+o+'">'+t.one.name+"</p>"),t.two&&t.two.name!=""&&(f+='<p id="'+u+'">'+t.two.name+"</p>");var l=t.id||"",c=['<div class="popbg '+a+'" id="'+s+'">','<div class="popbox '+l+'">',r,'<p class="poptip">'+i+"</p>",'<p class="poptxt">'+t.msg+"</p>",'<div class="popbtnbox">',f,"</div></div></div>"].join("");e("body").append(c),typeof t.initFun=="function"&&t.initFun(s);var h=e("#"+s),p=function(){h.remove()},d=typeof t.one.fun=="function"?function(){var e=t.one.noClose?t.one.noClose:0;e||p(),t.one.fun()}:p;e("#"+o).on("click",d);if(t.two&&t.two.fun!=""){var v=typeof t.two.fun=="function"?function(){var e=t.two.noClose?t.two.noClose:0;e||p(),t.two.fun()}:p;e("#"+u).on("click",v)}}return{popalert:t,popconfirm:n,popinput:r,popdefine:i}}),define("widget/util",[],function(){return{getTime:function(){return(new Date).getTime()},oneOrZero:function(){return Math.round(Math.random())},padZero:function(e,t){var n=e.toString();do{var r=n.indexOf(".")>-1?n.indexOf("."):n.length;r<t&&(n="0"+n)}while(r<t);return n},trim:function(e){return e.replace(/(^\s*)|(\s*$)/g,"").replace(/(^　*)|(　*$)/g,"")},getId:function(e){return document.getElementById(e)},dateFormat:function(e,t){var e=new Date(e),n={M:e.getMonth()+1,d:e.getDate(),h:e.getHours(),m:e.getMinutes(),s:e.getSeconds(),q:Math.floor((e.getMonth()+3)/3),S:e.getMilliseconds()},t=t.replace(/([yMdhmsqS])+/g,function(t,r){var i=n[r];return i!==undefined?(t.length>1&&(i="0"+i,i=i.substr(i.length-2)),i):r==="y"?(e.getFullYear()+"").substr(4-t.length):t});return t},escapeHtml:function(e){var t={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;","/":"&#x2F;"};return String(e).replace(/[&<>"'\/]/g,function(e){return t[e]})},countdown:function(e,t,n,r){var i=setInterval(function(){if(0>=e){clearInterval(i);try{r&&r()}catch(s){throw s}return}var o=--e;e<10&&(o="0"+e),n.innerHTML=o+t},1e3)},xss:function(e){return e==undefined||typeof e!="string"?e:(e=e.replace(/</g,"&lt;").replace(/>/g,"&gt;"),e)}}}),define("widget/imgHelper",["lib/common"],function(e){function n(e){if(typeof t[e]!="undefined")return t[e];var n=new Image;n.src=e,t[e]=n.src}var t={};return{set_getImg:n}}),define("widget/templateHelper",["lib/common","widget/util","widget/imgHelper"],function(e,t,n){return{helper:function(){e.tpl.helper("dateFormat",function(e,n){var r=t.dateFormat(e,n);return r}),e.tpl.helper("dateTimeFormat",function(e,n){var r=/^(\d{4})(-|\/|\.)(\d{1,2})\2(\d{1,2})(\s+(\d{1,2}):(\d{1,2}):(\d{1,2}))*$/,i=e.match(r);if(i){var s=i[1],o=parseInt(i[3],10)-1,u=i[4],a=i[6]||"",f=i[7]||"",l=i[8]||"",c=new Date(s,o,u,a,f,l),h=c.getTime();return t.dateFormat(h,n)}return""}),e.tpl.helper("timeStampFormat",function(e,n){return t.dateFormat(e||0,n||"")}),e.tpl.helper("dateYMDFormat",function(e,t){var n=e||"",r=t||"";return n.split(" ")[0].replace(/[\.\-\\]/g,"/")}),e.tpl.helper("pointKind",function(e){var t=e||"",n="";switch(t){case"point":n="抵用券";break;case"voucher":n="优惠券";break;case"bonus":n="购物金"}return n}),e.tpl.helper("priceFormat",function(e,t){var t=t||0,e=e||0;return t==0?e=parseFloat(e):t==-1?e=parseInt(e):e=parseFloat(e).toFixed(t),e}),e.tpl.helper("idcardFormat",function(t){if(e.isNull(t))return;var n=4,r=4,i=t.length-n-r,s="";for(var o=0;o<i;o++)s+="*";return t.substr(0,n)+s+t.substr(t.length-r)}),e.tpl.helper("phoneOrEmailFormat",function(t,n){if(e.isNull(t))return;if(n==1){var r=3,i=4,s=t.length-r-i,o="";for(var u=0;u<s;u++)o+="*";return t.substr(0,r)+o+t.substr(t.length-i)}var a=t.substring(0,t.indexOf("@")),f=t.substring(t.indexOf("@"),t.length),r=1,i=1,s=a.length-r-i,o="";for(var u=0;u<s;u++)o+="*";return t.substr(0,r)+o+a.substr(a.length-i)+f}),e.tpl.helper("priceFormat2",function(e){return typeof e=="string"&&(e=parseFloat(e)),isNaN(e)?"0.00":e.toFixed(2)}),e.tpl.helper("getImg",function(e){return n.set_getImg(e)}),e.tpl.helper("intDecimalPrice",function(e,t){var e=e||"0.00",t=t||1,n="";typeof e!="string"&&(e=e.toString());switch(t){case 1:return((e.replace(",","")|0)+"").replace(/(\d{1,3})(?=(?:\d{3})+(?!\d))/g,"$1,");case 2:return n=e.split(".")[1],n=n===undefined?"00":n.length==1?n+"0":n,n}}),e.tpl.helper("deCodeHtml",function(e){return e.replace(/&gt;/gi,">").replace(/&lt;/gi,"<")}),e.tpl.helper("removeTag",function(e){return e.replace(/\<[^\<|^\>]*\>/gi,"")}),e.tpl.helper("forNumOpt",function(e){var t="";e=parseInt(e,10);for(var n=1;n<=e;n++)t+='<option value="'+n+'">'+n+"</option>";return t})}}}),define("config/constant",[],function(){return{kefutel:"400-920-6565",cod:6,apkUrl:"http://apk.feiniugo.com/FeiNiuWang.apk",iphoneAppUrl:"http://itunes.apple.com/cn/app/id921839681?ls=1&mt=8",payCode:[6,11]}}),function(e){function t(t){function n(){if(this.udid)return this.udid;var e="",t=this.getTime();return e+="H5_"+t+this.randomString(10),this.udid=e,e}t=t||{},this.ua=navigator.userAgent,this.udid="",this.env=null,this.resolution=e.screen.width+"|"+e.screen.height,this.cookieDomain=function(){var e=/m\.feiniu\.com/i.test(location.href);return e?".feiniu.com":location.hostname.split(".").slice(-2).join(".")},this.getTime=function(){return(new Date).getTime()},this.randomString=function(e){var t="0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz".split("");e||(e=Math.floor(Math.random()*t.length));var n="";for(var r=0;r<e;r++)n+=t[Math.floor(Math.random()*t.length)];return n},this.createUdid=typeof t.createUdid=="function"?t.createUdid:n,this.getcookie=function(e){var t=new RegExp("(^|;|\\s+)"+e+"=([^;]*)(;|$)"),n=document.cookie.match(t);return n?decodeURIComponent(n[2]):""},this.addcookie=function(e,t,n,r,i){var s=e+"="+encodeURIComponent(t)+"; path="+(n||"/")+(i?"; domain="+i:"");if(r>0){var o=new Date;o.setTime(o.getTime()+r*1e3),s+=";expires="+o.toGMTString()}document.cookie=s},this.delcookie=function(e,t,n){arguments.length==2&&(n=t,t="/"),document.cookie=e+"=;path="+t+";"+(n?"domain="+n+";":"")+"expires=Thu, 01-Jan-70 00:00:01 GMT"},this.getUdid=function(){var e="th5_stat_udid",t=this.getcookie(e);if(t)return t;var n=this.createUdid(),r=31536e3,i=/feiniu\.com/i.test(location.href),s=".feiniu.com";return i||(s=location.hostname.split(".").slice(-2).join(".")),this.addcookie(e,n,"/",r,s),n},this.getEnv=function(){if(this.env!=null)return this.env;var e=["m","preview","test","dev","dev1","local"],t="m",n=location.hostname.split(".");if(n[0])for(var r in e)if(e[r]==n[0]){t=n[0];continue}return this.setEnv(t),t},this.setEnv=function(e){this.env=e},this.getSystemType=function(){var e=this.ua;e=e.toLowerCase();var t="";return e.indexOf("android")>-1||e.indexOf("linux")>-1?t="android":e.indexOf("iphone")>-1||e.indexOf("ipad")>-1||e.indexOf("itouch")>-1||e.indexOf("ipod")>-1||e.indexOf("mac")>-1?t="ios":e.indexOf("windows phone")>-1?t="wp":t="windows",t},this.mix=function(){var e={};for(var t=0;t<arguments.length;t++){var n=arguments[t];for(var r in n)r in e?n[r]!=undefined&&(e[r]=n[r]):e[r]=n[r]}return e},this.getUrlParam=function(e){var t=new RegExp("(^|&)"+e+"=([^&]*)(&|$)"),n=location.search.substr(1).match(t);return n!=null?decodeURIComponent(n[2]):null},this.getMessage=function(){var e=this.getUrlParam("fromtype");return e==null&&(e=document.referrer?document.referrer:""),e},this.getRemarksCfg=function(){var e={terminal_os_ver:"",model:"",brand:"",resolution:this.resolution,browser_type:"",mac:""};return JSON.stringify(this.mix(e))},this.isClient=function(){var e="th5_stat_token",t=86400,n=this.getcookie("th5_token")||"",r=this.getcookie("th5_stat_token")||"";if(n&&r==n)return"";if(r=="-1")return n&&this.addcookie(e,n,"/",t,this.cookieDomain()),"";if(r!=n||!r){var n=n||"-1";this.addcookie(e,n,"/",t,this.cookieDomain())}return this.getRemarksCfg()};var r=this.getTime(),i=this.getcookie("th5_username")||"",s=this.getcookie("th5_sitename")||"",o=this.getcookie("th5_mem_guid")||"";!o&&i&&(o=i),this.getLandingUrl=function(){var t="th5_landing_url",n=this.getcookie(t)||"",r=1800;if(n)return this.addcookie(t,n,"/",r,this.cookieDomain()),n;var i=e.location.href;return this.addcookie(t,i,"/",r,this.cookieDomain()),i},this.getLandingSession=function(){var e="th5_landing_session",t=this.getcookie(e)||"",n=1800;if(t)return this.addcookie(e,t,"/",n,this.cookieDomain()),t;var r="";return r+="H5_"+this.getTime()+this.randomString(10),this.addcookie(e,r,"/",n,this.cookieDomain()),r},this.setLandingSession=function(e){var t="th5_landing_session",n=1800;this.addcookie(t,e,"/",n,this.cookieDomain())},this.getAppid=function(){var e=navigator.userAgent;e=e.toLowerCase();if(navigator.userAgent.indexOf("feiniuapp")>-1){var t=navigator.userAgent.split(" ");for(var n=0;n<t.length;n++)if(t[n].indexOf("feiniuapp")>-1){var r=t[n].split("/"),i=r[1].toLowerCase();if(i=="android")return 1;if(i=="iphone")return 2;if(i=="ipad")return 4;if(i=="winphone")return 5}}else{if(this.getUrlParam("osType")&&this.getUrlParam("osType")!="")return e.match(/MicroMessenger/i)=="micromessenger"?9:this.getUrlParam("osType");if(e.match(/MicroMessenger/i)=="micromessenger")return 9}return 3},this.statAppVal=function(){var e={},t=this.getcookie("th5_stat_app");if(t)try{e=JSON.parse(t)}catch(n){}if(typeof e=="undefined"||!e)e={};return e},this.urlConfigParam={udid:this.getUdid(),mem_guid:o,user_name:i,terminal_os:this.getSystemType(),track_code:this.getcookie("th5_channel_edm_code")||"",network:"",gps:"",city:s,track_tag_name:"",result:"",page_content:"",message:"",cur_req_url:location.href,landing_url:"",session_id:"",track_type:1,referer_url:document.referrer||"",startTime:r,endTime:r,abtest:0,remarks:"",ver:"",traffic_channel:"",dev_type:this.getAppid(),ref_page_id:"",client_type:0},this.shangbao=function(t,n,r){var i="",s=this.getEnv();s=="m"?i="http://flume.feiniu.com/AppCollectLogs/AddH5Log?v="+this.getTime():s=="preview"?i="/stat.php?env=preview&v="+this.getTime():i="/stat.php?env=test&v="+this.getTime(),i+=this.randomString(2);var t=t||{};t.message=="-9"&&(t.message=this.getMessage());var o=this.statAppVal();typeof o=="object"&&(t.client_type=o.client_type,t.ver=o.ver,t.traffic_channel=o.traffic_channel,t.gps=o.gps,t.network=o.network,o.session_id&&this.setLandingSession(o.session_id)),t.landing_url=this.getLandingUrl(),t.session_id=this.getLandingSession();var u=this.mix(this.urlConfigParam,t);for(j in u)u[j]=="-9"&&(u[j]="0"),i+="&"+j+"="+encodeURIComponent(u[j]);typeof n!="function"&&(n=function(){});if(navigator.sendBeacon)navigator.sendBeacon(i,""),n();else{var a=new Image,f;try{var l=new $.Deferred,c=function(){a.removeEventListener("load",c,!1),a.removeEventListener("error",c,!1),clearTimeout(f),n(),l.resolve()};a.addEventListener("load",c,!1),a.addEventListener("error",c,!1),f=setTimeout(c,r||1e3),a.src=i,e._deferRedirect=l}catch(h){a.src=i,n()}}}}var n={isObj:0,shangbao:function(e,n,r){var i="";if(this.isObj)i=this.isObj;else{i=new t(this.opt),this.isObj=i;if(e.h5_type=="edm"){if(i.getUrlParam("tracking_type")!="h5_edm")return"";var s=i.getUrlParam("type");(s=="h5_dev"||s=="h5_test"||s=="h5_beta")&&i.setEnv("test")}var o=i.isClient();if(o){var u={track_tag_name:"1000",result:"",page_content:"",message:"-9",track_type:"6",remarks:o};i.shangbao(u,n,r)}}i.shangbao(e,n,r)},getRemarksCfg:function(){var e="";return this.isObj?e=this.isObj:(e=new t,this.isObj=e),e.getRemarksCfg()}};e.h5stat=n;if(typeof define=="function"&&define.amd)define("widget/stat",["lib/common"],function(t){return e.h5stat});else if(typeof e.Zepto=="undefined"){var r=document.createElement("script");r.src=e.feiniu.url.jsBase+"/lib/zepto.min.js";var i=document.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)}}(window),define("widget/loadingV2",["lib/common"],function(e){function u(t,n,s,u){f();var l=e.extend(!0,{},o);typeof t=="object"?e.extend(!0,l,t):(l.off=t,l.topOn=typeof s=="boolean"?s:l.topOn,l.D_dom=u||l.D_dom,typeof n=="boolean"?(l.name=r,l.topOn=n):typeof n=="object"?(l.D_dom=n,l.name=i,l.topOn=!1):l.name=n||r),a(l)}function a(e){var n,r=0;n=t[e.name]||!1;if(n)return typeof e.off=="undefined"||typeof e.off=="string"?t[e.off||e.name].data("count")>>0:(r=n.data("count")>>0,e.off?(n.data("count",++r),r==1&&(e.D_dom.append(n),h(n,e),e.topOn&&e.name!="none"&&c(n,e.topOn))):(n.data("count",--r),r<=0&&(l(n,e),e.name!="none"&&c(n,!1))),name)}function f(){e("[data-load-name]").each(function(){var n=e(this);t[n.data("load-name")]=n})}function l(e,r){typeof e=="string"?e=t[e]:typeof e=="undefined"&&(e=t[r.name]),e.data("count",0),e.remove(),n.off("scroll.loading")}function c(t,r){var i=[],o=e(".top_nav");e.each(s,function(t,n){i=e(n);if(i.length)return!1}),r&&i.length?(n.off("scroll.loading").on("scroll.loading",function(){var e=i.height()+i.offset().top,r=e-n.scrollTop(),s=n.height()-r;t.css({"padding-top":r>0?r:0})}),h(i),i.addClass("z100")):(n.off("scroll.loading"),t.css({"padding-top":""}),i.removeClass("z100")),o.length&&(r?o.addClass("z100"):o.removeClass("z100"))}function h(e){e&&e.off("touchmove.preventDefault").on("touchmove.preventDefault",function(){event.preventDefault()})}var t={none:e("<div></div>"),p1:e('<p class="loading_pop all"><b></b></p>'),p2:e('<p class="loading_btm"><b></b><i>正在努力加载...</i></p>'),v2:e('<p class="loading_pop all"><b></b></p>')},n=e(window),r="p1",i="p2",s=["[data-loading-top]","header",".top_box"];(function(){var n=navigator.userAgent.toLowerCase();if(n.indexOf("qqbrowser")>-1||n.indexOf("ucbrowser")>-1){t.p2=e('<p class="loading_btm"><em></em><i>正在努力加载...</i></p>'),t.p1=e('<p class="loading_pop all"><em></em></p>'),t.v2=e('<p class="loading_pop all"><em></em></p>');var r=1;setInterval(function(){var n=r%18;e.each(t,function(){e(".loading_pop").find("em").css("background-position",-0.9*n+"rem 0")}),r++},40)}})();var o={off:r,name:r,topOn:!0,D_dom:e("body")};return{on:u,off:l}}),define("widget/fixed",["lib/common"],function(e){function n(n){e.extend(t,n)}function r(){t.D_list.each(function(n){var r={},i=e(this),s=e("#anchor-"+n);s.length||(s=e('<div id="anchor-'+n+'"></div>'),i.wrap(s)),r={D_this:i,D_anchor:s},s.css("position","relative").height(i.height()),i.data("fixed-top")>=0?t.list_top[i.data("fixed-top")]=r:i.data("fixed-bottom")>=0&&(t.list_bottom[i.data("fixed-bottom")]=r)})}function i(){var n=t.D_w.scrollTop(),r=0,s=0,o={position:"absolute",left:0,width:"100%","max-width":"100%"};t.way=i,e.each(t.list_top,function(t,i){n+r>i.D_anchor.offset().top?(i.D_this.css(e.extend({},o,{top:n})),r+=i.D_this.height()>>0):i.D_this.css({position:"",top:""})}),e.each(t.list_bottom,function(r,i){var u=i.D_this.height()>>0;n+t.D_w.height()-s-u<i.D_anchor.offset().top||i.D_this.data("state")=="far"?(i.D_this.css(e.extend({},o,{bottom:i.D_anchor.offset().top-n-t.D_w.height()+s+u})),s+=u):i.D_this.css({position:"",bottom:""})})}function s(){var n=t.D_w.scrollTop(),r=0,i=0,o={position:"fixed",left:0,width:"100%","max-width":"100%"};t.way=s,e.each(t.list_top,function(t,i){n+r>i.D_anchor.offset().top?(i.D_this.css(e.extend({},o,{top:r})),r+=i.D_this.height()>>0):i.D_this.css({position:"",top:""})}),e.each(t.list_bottom,function(r,s){var u=s.D_this.height()>>0;n+t.D_w.height()-i-u<s.D_anchor.offset().top||s.D_this.data("state")=="far"?(s.D_this.css(e.extend({},o,{bottom:i})),i+=u):s.D_this.css({position:"",bottom:""})})}function o(){typeof t.way=="function"&&(t.way=!1,t.D_list.css({position:"",top:"",bottom:""}))}function u(){t={D_w:e(window),D_b:e("body"),D_list:e("[data-fixed-top],[data-fixed-bottom]"),list_top:[],list_bottom:[],save:[]},t.D_w.on("resize",r).resize(),s(),t.D_w.on("scroll.fixed",function(){t.way&&t.way()})}var t={D_w:e(window),D_b:e("body"),D_list:e("[data-fixed-top],[data-fixed-bottom]"),list_top:[],list_bottom:[],save:[]};return{onFixed:u,wayAbsolute:i,wayFixed:s,iosScheme:o}}),require(["lib/common","model/order","widget/popAlert","widget/templateHelper","config/constant","widget/stat","widget/loadingV2","widget/fixed","config/url"],function(e,t,n,r,i,s,o,u,a){function h(t){e(".J_topback").off("click"),e(".J_topback").on("click",function(){document.referrer.indexOf("my/order/index.html")>-1?history.go(-1):e.url.redirect(e.url.getTouchBaseUrl()+"my/order/index.html")}),e(".J_cancel").on("click",function(){e(this).closest(".popbg").hide()}),e(".J_sure").on("click",function(){e.url.redirect(e(this).attr("data-href"))});var n=e(".moumou_chat").data("smseq");n&&(e(".moumou_chat").on("click",function(){s.shangbao({track_tag_name:"7003",message:"4",track_type:"2"}),setTimeout(function(){var t=e(this).data("smseq"),n=e(this).data("itno"),r=null;n?r=a.mmDomain+"webim/index/"+t+"?skuid="+n:r=a.mmDomain+"webim/index/"+t,e.url.redirect(r)},200)}),e(".moumou_chat_h").css("display","block"));var r=e("#identityCardNo").text()||"",i=r.length,o=r.substr(0,4)+"**********"+r.substr(i-4);e("#identityCardNo").text(o),e(".J_progressStatus").each(function(t){var n=e(this).find("li.on"),r=n.length;if(r>1)for(var i=0;i<r-1;i++)n.eq(i).removeClass("on").addClass("off")}),e(".J_special_offers").on("click",function(){var t=e(this).data("is-sel");t?e.url.redirect(e.url.getTouchBaseUrl()+"item/"+e(this).attr("data-sm")+"?isSel=1&from=order"):e.url.redirect(e.url.getTouchBaseUrl()+"item/"+e(this).attr("data-sm"))});var u=document.referrer;u.indexOf("/return_order")>-1&&(e.url.options.backUrl=e.url.getTouchBaseUrl()+"my/order/index.html"+(l?"?isGroup=1":""));var c=e(".J_kaipao").attr("data-is-oversea");c=="1"&&e(".J_kaipao").find("i").hide(),e(".J_kaipao").on("click",function(){c!="1"&&e.url.redirect(e.url.getTouchBaseUrl()+"my/invoice/kaipiao.html?orderId="+f)}),e(".J_makeInvoice").on("click",function(){if(t.invoiceBar&&t.invoiceBar.is_need_make_invoice==1){var n={orderId:t.orderId,name:t.consignee.name,zip:t.consignee.zip,province:t.consignee.province,city:t.consignee.city,area:t.consignee.area,addr:t.consignee.addr,anchorNum:Number(e.url.getParam("ds_no"))||""};e.url.redirect(e.url.getTouchBaseUrl()+"my/invoice/makeinvoice.html?makeInvoiceParamObj="+encodeURIComponent(JSON.stringify(n)))}else e.url.redirect(e.url.getTouchBaseUrl()+"my/invoice/noinvoice.html")})}function p(e){if(typeof e=="undefined"||e.length<16)return e;var t=e.substr(0,6)+"..."+e.substr(e.length-8);return t}function d(){var r={body:{orderId:f}};t.getOrderDetail(r,function(t){e.log(t),e(".J_loading").hide();if(t.errorCode!=0){e.log("获取定单详情失败");return}e.log("订单详情=",t.body.orderDetail);var r={},s=[];r=t.body.orderDetail;if(e.isNull(r)){n.popalert("数据获取失败");return}r.parcelTotal=r.dsList.length,r.cod=i.cod,r.orderPay=parseFloat(r.payList.amount.price.replace(/\,/g,""))+parseFloat(r.payList.shipFee.price.replace(/\,/g,"")),r.isCancel=0;for(var o=0;o<r.parcelTotal;o++){var u=r.dsList[o];(u.status==1||u.status>4)&&r.isCancel++}r.isCancel=r.parcelTotal==r.isCancel?!0:!1,r.is_oversea=0,r.is_return=0,e.each(r.dsList,function(e,t){s.push(t.ds_no),t.oversea==1&&(r.is_oversea=1),t.ds_r_qty&&(r.is_return=1)}),r.packNo=s.join(",");if(r.consignee&&r.consignee.cellPhone){var a=r.consignee.cellPhone,f=a.length,l=a.substr(0,3)+"****"+a.substr(f-4);r.consignee.cellPhone=l}r.dsList.forEach(function(e){e.operationList.reverse(),e.ds_r_in_qty==1&&(r.has_r_ds=!0),e.status==1?r.order_is_payed=!1:r.order_is_payed=!0}),r.accounttype=e.cookie.getH5("accountType")||0,e.tplRender("tpl_item",r),console.log(r),h(r),e(".J_package_tips").each(function(){var t=e(this).data("tips"),n=e(this).width(),r=e(this).parents(".package_title").width(),i=e(this).parents(".package_title").find(".package_num").width(),s=r-i-n-24;s>0?_html=t:_html=p(t),e(this).html(_html)}),e(".J_telPhone").on("click",function(){location.href="tel:400-920-6565"}),v(),m(),g()})}function v(){e(".J_confirmReceived").on("click",function(){var r=e(this),i=r.attr("data-dstype"),s=i==1?r.attr("data-fdlseq"):r.attr("data-subid"),u={body:{type:i,orderId:f,package_info:s}};n.popconfirm("请确认您已收到货",function(){o.on(!0,"v2",!0),t.confirmReceived(u,function(t){o.on(!1,"v2");if(t.errorCode==0){var i=e(".J_progressStatus");i.find("li").removeClass("on").addClass("off"),i.find("li").last().removeClass("off").addClass("on"),r.parent().find(".J_returnBtn").text("我要退货"),r.parent().append("交易成功"),r.remove()}else n.popalert("系统故障，确认收货失败")})})})}function m(){e(".J_delOrder span").on("click",function(){var r=e(this).hasClass("cannot_del");if(r){n.popalert("抱歉，该订单有商品正在退货中，无法删除");return}var i={body:{ogSeq:e(this).data("og-seq")}};n.popconfirm("确认删除订单？删除之后将无法恢复",function(){t.deleteOrder(i,function(t){t.errorCode==0&&(s.shangbao({track_tag_name:"5067",track_type:"2"}),e.url.redirect(e.url.getTouchBaseUrl()+"my/order/index.html"+(l?"?isGroup=1":"")))})})})}function g(){var t=Number(e.url.getParam("ds_no"));if(!t)return;var n=e("div.outbox>.box").eq(t-1).offset().top;e(window).scrollTop(n)}function y(){var t=Number(e(window).scrollTop()),n=Number(e(window).height()),r=Number(e(".total_pay").offset().top);t+n<r?e("#total").addClass("total_fix"):e("#total").removeClass("total_fix"),y}e.log("飞牛网--订单详情"),r.helper();var f=e.url.getParam("orderId"),l=e.url.getParam("isGroup");if(e.cookie.getH5("islogin")!=1){var c=e.url.getTouchBaseUrl()+"my/order/detail.html?orderId="+f;e.url.redirect(e.url.getTouchBaseUrl()+"login/index.html?gotourl="+encodeURIComponent(c));return}e.tpl.helper("sm_price",function(e){if(e!="0.00")return"&yen; "+e}),e.tpl.helper("bottom_pay_bar2_txt",function(e){return e.substr(0,5)}),e.tpl.helper("bottom_pay_bar2_time",function(e){return e.substr(7)}),e.getToken(function(){d(),e(window).on("scroll resize",function(){var t=e(".total_pay").length;t&&y()}).resize()});var b={track_tag_name:"5009",result:"",page_content:f,message:"-9"};s.shangbao(b)}),define("controller/my/order/orderDetailV2_2",function(){});