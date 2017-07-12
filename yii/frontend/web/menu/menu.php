<!DOCTYPE html>
<!-- saved from url=(0046)http://1.wqing7.applinzi.com/wq/menu.php?act=& -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=8">

<title>微擎 - 微信公众平台自助引擎 -  Powered by WE7.CC</title>
<meta name="keywords" content="微擎,微信,微信公众平台">
<meta name="description" content="微信公众平台自助引擎，简称微擎，微擎是一款免费开源的微信公众平台管理系统。">
<link type="text/css" rel="stylesheet" href="bootstrap.css">
<link type="text/css" rel="stylesheet" href="font-awesome.css">
<link type="text/css" rel="stylesheet" href="common(1).css">
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="bootstrap.js"></script>
<script type="text/javascript" src="common(2).js"></script>
<script type="text/javascript" src="emotions.js"></script>
<script type="text/javascript">
cookie.prefix = '6e34_';
</script>
<!--[if IE 7]>
<link rel="stylesheet" href="./resource/style/font-awesome-ie7.min.css">
<![endif]-->
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="./resource/style/bootstrap-ie6.min.css">
<link rel="stylesheet" type="text/css" href="./resource/style/ie.css">
<![endif]-->
</head>
<body>
<script type="text/javascript" src="jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript">
	var pIndex = 1;
	var currentEntity = null;
	$(function(){
		$('tbody.mlist').sortable({handle: '.icon-move'});
		$('.smlist').sortable({handle: '.icon-move'});
		$('.mlist .hover').each(function(){
			$(this).data('do', $(this).attr('data-do'));
			$(this).data('url', $(this).attr('data-url'));
			$(this).data('forward', $(this).attr('data-forward'));
		});
		$('.mlist .hover .smlist div').each(function(){
			$(this).data('do', $(this).attr('data-do'));
			$(this).data('url', $(this).attr('data-url'));
			$(this).data('forward', $(this).attr('data-forward'));
		});
		$(':radio[name="ipt"]').click(function(){
			if(this.checked) {
				if($(this).val() == 'url') {
					$('#url-container').show();
					$('#forward-container').hide();
				} else {
					$('#url-container').hide();
					$('#forward-container').show();
				}
			}
		});
		$('#dialog').modal({keyboard: false, show: false});
		$('#dialog').on('hide', saveMenuAction);
	});
	function addMenu() {
		if($('.mlist .hover').length >= 3) {
			return;
		}
		var html = '<tr class="hover">'+
						'<td>'+
							'<div>'+
								'<input type="text" class="span4" value=""> &nbsp; &nbsp; '+
								'<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp; '+
								'<a href="javascript:;" onclick="setMenuAction($(this).parent().parent().parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp; '+
								'<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a> &nbsp; '+
								'<a href="javascript:;" onclick="addSubMenu($(this).parent().next());" title="添加子菜单" class="icon-plus-sign" title="添加菜单"></a> '+
							'</div>'+
							'<div class="smlist"></div>'+
						'</td>'+
					'</tr>';
		$('tbody.mlist').append(html);
	}
	function addSubMenu(o) {
		if(o.find('div').length >= 5) {
			return;
		}
		var html = '' +
				'<div style="margin-top:20px;padding-left:80px;background:url(\'./resource/image/bg_repno.gif\') no-repeat -245px -545px;">'+
					'<input type="text" class="span3" value=""> &nbsp; &nbsp; '+
					'<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp; '+
					'<a href="javascript:;" onclick="setMenuAction($(this).parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp; '+
					'<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a> '+
				'</div>';
		o.append(html);
	}
	function deleteMenu(o) {
		if($(o).parent().parent().hasClass('smlist')) {
			$(o).parent().remove();
		} else {
			$(o).parent().parent().parent().remove();
		}
	}
	function setMenuAction(o) {
		if(o == null) return;
		if(o.find('.smlist div').length > 0) {
			return;
		}
		currentEntity = o;
		$('#ipt-url').val($(o).data('url'));
		$('#ipt-forward').val($(o).data('forward'));
		if($(o).data('do') != 'forward') {
			$(':radio').eq(0).attr('checked', 'checked');
		} else {
			$(':radio').eq(1).attr('checked', 'checked');
		}
		$(':radio:checked').trigger('click');
		$('#dialog').modal('show');
	}
	function saveMenuAction(e) {
		var o = currentEntity;
		var t = $(':radio:checked').val();
		t = t == 'url' ? 'url' : 'forward';
		if(o == null) return;
		$(o).data('do', t);
		$(o).data('url', $('#ipt-url').val());
		$(o).data('forward', $('#ipt-forward').val());
	}
	function saveMenu() {
		if($('.span4:text').length > 3) {
			message('不能输入超过 3 个主菜单才能保存.', '', 'error');
			return;
		}
		if($('.span4:text,.span3:text').filter(function(){ return $.trim($(this).val()) == '';}).length > 0) {
			message('存在未输入名称的菜单.', '', 'error');
			return;
		}
		if($('.span4:text').filter(function(){ return $.trim($(this).val()).length > 5;}).length > 0) {
			message('主菜单的名称长度不能超过5个字.', '', 'error');
			return;
		}
		if($('.span3:text').filter(function(){ return $.trim($(this).val()).length > 8;}).length > 0) {
			message('子菜单的名称长度不能超过8个字.', '', 'error');
			return;
		}
		var dat = '[';
		var error = false;
		$('.mlist .hover').each(function(){
			var name = $.trim($(this).find('.span4:text').val()).replace(/"/g, '\"');
			var type = $(this).data('do') != 'forward' ? 'view' : 'click';
			var url = $(this).data('url');
			if(!url) {
				url = '';
			}
			var forward = $.trim($(this).data('forward'));
			if(!forward) {
				forward = '';
			}
			dat += '{"name": "' + name + '"';
			if($(this).find('.smlist div').length > 0) {
				dat += ',"sub_button": [';
				$(this).find('.smlist div').each(function(){
					var sName = $.trim($(this).find('.span3:text').val()).replace(/"/g, '\"');
					var sType = $(this).data('do') != 'forward' ? 'view' : 'click';
					var sUrl = $(this).data('url');
					if(!sUrl) {
						sUrl = '';
					}
					var sForward = $.trim($(this).data('forward'));
					if(!sForward) {
						sForward = '';
					}
					dat += '{"name": "' + sName + '"';
					if((sType == 'click' && sForward == '') || (sType == 'view' && !sUrl)) {
						message('子菜单项 “' + sName + '”未设置对应规则.', '', 'error');
						error = true;
						return false;
					}
					if(sType == 'click') {
						dat += ',"type": "click","key": "' + encodeURIComponent(sForward) + '"';
					}
					if(sType == 'view') {
						dat += ',"type": "view","url": "' + sUrl + '"';
					}
					dat += '},';
				});
				if(error) {
					return false;
				}
				dat = dat.slice(0,-1);
				dat += ']';
			} else {
				if((type == 'click' && forward == '') || (type == 'view' && !url)) {
					message('菜单 “' + name + '”不存在子菜单项, 且未设置对应规则.', '', 'error');
					error = true;
					return false;
				}
				if(type == 'click') {
					dat += ',"type": "click","key": "' + encodeURIComponent(forward) + '"';
				}
				if(type == 'view') {
					dat += ',"type": "view","url": "' + url + '"';
				}
			}
			dat += '},';
		});
		if(error) {
			return;
		}
		dat = dat.slice(0,-1);
		dat += ']';
		$('#do').val(dat);
		$('#form')[0].submit();
	}
</script>
<style type="text/css">
	.table-striped td{padding-top: 10px;padding-bottom: 10px}
	a{font-size:14px;}
	a:hover, a:active{text-decoration:none; color:red;}
	.hover td{padding-left:10px;}
</style>
<div class="main">
	<div class="form form-horizontal">
		<h4>菜单设计器 <small>编辑和设置微信公众号码, 必须是服务号才能编辑自定义菜单。</small></h4>
		<table class="tb table-striped">
			<tbody class="mlist ui-sortable">
									<tr class="hover" data-do="forward" data-url="" data-forward="V1001_TODAY_MUSIC">
					<td>
						<div>
							<input type="text" class="span4" value="推荐歌曲"> &nbsp; &nbsp;
							<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp;
							<a href="javascript:;" onclick="setMenuAction($(this).parent().parent().parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp;
							<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a> &nbsp;
							<a href="javascript:;" onclick="addSubMenu($(this).parent().next());" title="添加子菜单" class="icon-plus-sign"></a>
						</div>
						<div class="smlist ui-sortable">
													</div>
					</td>
				</tr>
						<tr class="hover" data-do="view" data-url="" data-forward="">
					<td>
						<div>
							<input type="text" class="span4" value="菜单"> &nbsp; &nbsp;
							<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp;
							<a href="javascript:;" onclick="setMenuAction($(this).parent().parent().parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp;
							<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a> &nbsp;
							<a href="javascript:;" onclick="addSubMenu($(this).parent().next());" title="添加子菜单" class="icon-plus-sign"></a>
						</div>
						<div class="smlist ui-sortable">
																					<div style="margin-top:20px;padding-left:80px;background:url(&#39;./resource/image/bg_repno.gif&#39;) no-repeat -245px -545px;" data-do="view" data-url="https://www.baidu.com/" data-forward="">
								<input type="text" class="span3" value="搜索"> &nbsp; &nbsp;
								<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp;
								<a href="javascript:;" onclick="setMenuAction($(this).parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp;
								<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a>
							</div>
														<div style="margin-top:20px;padding-left:80px;background:url(&#39;./resource/image/bg_repno.gif&#39;) no-repeat -245px -545px;" data-do="view" data-url="http://v.qq.com/" data-forward="">
								<input type="text" class="span3" value="视频"> &nbsp; &nbsp;
								<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp;
								<a href="javascript:;" onclick="setMenuAction($(this).parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp;
								<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a>
							</div>
														<div style="margin-top:20px;padding-left:80px;background:url(&#39;./resource/image/bg_repno.gif&#39;) no-repeat -245px -545px;" data-do="forward" data-url="" data-forward="V1001_GOOD">
								<input type="text" class="span3" value="赞一下我们"> &nbsp; &nbsp;
								<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp;
								<a href="javascript:;" onclick="setMenuAction($(this).parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp;
								<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a>
							</div>
																				</div>
					</td>
				</tr>
									</tbody>
		</table>
		<div class="well well-small" style="margin-top:20px;">
			<a href="javascript:;" onclick="addMenu();">添加菜单 <i class="icon-plus-sign" title="添加菜单"></i></a> &nbsp; &nbsp; &nbsp;  <span class="help-inline">可以使用 <i class="icon-move"></i> 进行拖动排序</span>
		</div>

		<h4>操作 <small>设计好菜单后再进行保存操作</small></h4>
		<table class="tb">
			<tbody>
				<tr>
					<td>
						<input type="button" value="保存菜单结构" class="btn btn-primary span3" onclick="saveMenu();">
						<span class="help-block">保存当前菜单结构至公众平台, 由于缓存可能需要在24小时内生效</span>
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" value="删除" class="btn btn-primary span3" onclick="$(&#39;#do&#39;).val(&#39;remove&#39;);$(&#39;#form&#39;)[0].submit();">
						<div class="help-block">清除自定义菜单</div>
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" value="刷新" class="btn btn-primary span3" onclick="$(&#39;#do&#39;).val(&#39;refresh&#39;);$(&#39;#form&#39;)[0].submit();">
						<div class="help-block">重新从公众平台获取菜单信息</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<form action="" method="post" id="form"><input id="do" name="do" type="hidden"></form>
<div id="dialog" class="modal hide">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>选择要执行的操作</h3>
	</div>
	<div class="tab-pane" id="url">
		<div class="well">
			<label class="radio inline">
				<input type="radio" name="ipt" value="url" checked="checked"> 链接
			</label>
			<label class="radio inline">
				<input type="radio" name="ipt" value="forward"> 模拟关键字
			</label>
			<hr>
			<div id="url-container">
				<input class="span6" id="ipt-url" type="text" value="http://">
				<span class="help-block">指定点击此菜单时要跳转的链接（注：链接需加http://）</span>
				<span class="help-block"><strong>注意: 由于接口限制. 如果你没有网页oAuth接口权限, 这里输入链接直接进入微站个人中心时将会有缺陷(有可能获得不到当前访问用户的身份信息. 如果没有oAuth接口权限, 建议你使用图文回复的形式来访问个人中心)</strong></span>
			</div>
			<div id="forward-container" class="hide">
				<input class="span6" id="ipt-forward" type="text">
				<span class="help-block">指定点击此菜单时要执行的操作, 你可以在这里输入关键字, 那么点击这个菜单时就就相当于发送这个内容至微擎系统</span>
				<span class="help-block"><strong>这个过程是程序模拟的, 比如这里添加关键字: 优惠券, 那么点击这个菜单是, 微擎系统相当于接受了粉丝用户的消息, 内容为"优惠券"</strong></span>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="rules"></div>
</div>
	<div id="footer">
		<span class="pull-left">
			<p>Powered by <a href="http://www.we7.cc/"><b>微擎</b></a> v0.52 © 2014 <a href="http://www.we7.cc/">www.we7.cc</a></p>
		</span>
		<span class="pull-right">
			<p><a href="http://www.we7.cc/">关于微擎</a>&nbsp;&nbsp;<a href="http://bbs.we7.cc/">微擎帮助</a></p>
		</span>
	</div>
	<div class="emotions" style="display:none;"><table cellspacing="0" cellpadding="0"><tbody><tr><td><div class="eItem" style="background-position:0px 0;" data-title="微笑" data-code="::)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/0.gif"></div></td><td><div class="eItem" style="background-position:-24px 0;" data-title="撇嘴" data-code="::~" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/1.gif"></div></td><td><div class="eItem" style="background-position:-48px 0;" data-title="色" data-code="::B" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/2.gif"></div></td><td><div class="eItem" style="background-position:-72px 0;" data-title="发呆" data-code="::|" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/3.gif"></div></td><td><div class="eItem" style="background-position:-96px 0;" data-title="得意" data-code=":8-)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/4.gif"></div></td><td><div class="eItem" style="background-position:-120px 0;" data-title="流泪" data-code="::&lt;" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/5.gif"></div></td><td><div class="eItem" style="background-position:-144px 0;" data-title="害羞" data-code="::$" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/6.gif"></div></td><td><div class="eItem" style="background-position:-168px 0;" data-title="闭嘴" data-code="::X" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/7.gif"></div></td><td><div class="eItem" style="background-position:-192px 0;" data-title="睡" data-code="::Z" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/8.gif"></div></td><td><div class="eItem" style="background-position:-216px 0;" data-title="大哭" data-code="::&#39;(" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/9.gif"></div></td><td><div class="eItem" style="background-position:-240px 0;" data-title="尴尬" data-code="::-|" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/10.gif"></div></td><td><div class="eItem" style="background-position:-264px 0;" data-title="发怒" data-code="::@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/11.gif"></div></td><td><div class="eItem" style="background-position:-288px 0;" data-title="调皮" data-code="::P" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/12.gif"></div></td><td><div class="eItem" style="background-position:-312px 0;" data-title="呲牙" data-code="::D" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/13.gif"></div></td><td><div class="eItem" style="background-position:-336px 0;" data-title="惊讶" data-code="::O" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/14.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-360px 0;" data-title="难过" data-code="::(" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/15.gif"></div></td><td><div class="eItem" style="background-position:-384px 0;" data-title="酷" data-code="::+" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/16.gif"></div></td><td><div class="eItem" style="background-position:-408px 0;" data-title="冷汗" data-code=":--b" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/17.gif"></div></td><td><div class="eItem" style="background-position:-432px 0;" data-title="抓狂" data-code="::Q" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/18.gif"></div></td><td><div class="eItem" style="background-position:-456px 0;" data-title="吐" data-code="::T" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/19.gif"></div></td><td><div class="eItem" style="background-position:-480px 0;" data-title="偷笑" data-code=":,@P" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/20.gif"></div></td><td><div class="eItem" style="background-position:-504px 0;" data-title="可爱" data-code=":,@-D" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/21.gif"></div></td><td><div class="eItem" style="background-position:-528px 0;" data-title="白眼" data-code="::d" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/22.gif"></div></td><td><div class="eItem" style="background-position:-552px 0;" data-title="傲慢" data-code=":,@o" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/23.gif"></div></td><td><div class="eItem" style="background-position:-576px 0;" data-title="饥饿" data-code="::g" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/24.gif"></div></td><td><div class="eItem" style="background-position:-600px 0;" data-title="困" data-code=":|-)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/25.gif"></div></td><td><div class="eItem" style="background-position:-624px 0;" data-title="惊恐" data-code="::!" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/26.gif"></div></td><td><div class="eItem" style="background-position:-648px 0;" data-title="流汗" data-code="::L" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/27.gif"></div></td><td><div class="eItem" style="background-position:-672px 0;" data-title="憨笑" data-code="::&gt;" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/28.gif"></div></td><td><div class="eItem" style="background-position:-696px 0;" data-title="大兵" data-code="::,@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/29.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-720px 0;" data-title="奋斗" data-code=":,@f" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/30.gif"></div></td><td><div class="eItem" style="background-position:-744px 0;" data-title="咒骂" data-code="::-S" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/31.gif"></div></td><td><div class="eItem" style="background-position:-768px 0;" data-title="疑问" data-code=":?" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/32.gif"></div></td><td><div class="eItem" style="background-position:-792px 0;" data-title="嘘" data-code=":,@x" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/33.gif"></div></td><td><div class="eItem" style="background-position:-816px 0;" data-title="晕" data-code=":,@@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/34.gif"></div></td><td><div class="eItem" style="background-position:-840px 0;" data-title="折磨" data-code="::8" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/35.gif"></div></td><td><div class="eItem" style="background-position:-864px 0;" data-title="衰" data-code=":,@!" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/36.gif"></div></td><td><div class="eItem" style="background-position:-888px 0;" data-title="骷髅" data-code=":!!!" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/37.gif"></div></td><td><div class="eItem" style="background-position:-912px 0;" data-title="敲打" data-code=":xx" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/38.gif"></div></td><td><div class="eItem" style="background-position:-936px 0;" data-title="再见" data-code=":bye" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/39.gif"></div></td><td><div class="eItem" style="background-position:-960px 0;" data-title="擦汗" data-code=":wipe" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/40.gif"></div></td><td><div class="eItem" style="background-position:-984px 0;" data-title="抠鼻" data-code=":dig" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/41.gif"></div></td><td><div class="eItem" style="background-position:-1008px 0;" data-title="鼓掌" data-code=":handclap" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/42.gif"></div></td><td><div class="eItem" style="background-position:-1032px 0;" data-title="糗大了" data-code=":&amp;-(" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/43.gif"></div></td><td><div class="eItem" style="background-position:-1056px 0;" data-title="坏笑" data-code=":B-)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/44.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-1080px 0;" data-title="左哼哼" data-code=":&lt;@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/45.gif"></div></td><td><div class="eItem" style="background-position:-1104px 0;" data-title="右哼哼" data-code=":@&gt;" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/46.gif"></div></td><td><div class="eItem" style="background-position:-1128px 0;" data-title="哈欠" data-code="::-O" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/47.gif"></div></td><td><div class="eItem" style="background-position:-1152px 0;" data-title="鄙视" data-code=":&gt;-|" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/48.gif"></div></td><td><div class="eItem" style="background-position:-1176px 0;" data-title="委屈" data-code=":P-(" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/49.gif"></div></td><td><div class="eItem" style="background-position:-1200px 0;" data-title="快哭了" data-code="::&#39;|" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/50.gif"></div></td><td><div class="eItem" style="background-position:-1224px 0;" data-title="阴险" data-code=":X-)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/51.gif"></div></td><td><div class="eItem" style="background-position:-1248px 0;" data-title="亲亲" data-code="::*" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/52.gif"></div></td><td><div class="eItem" style="background-position:-1272px 0;" data-title="吓" data-code=":@x" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/53.gif"></div></td><td><div class="eItem" style="background-position:-1296px 0;" data-title="可怜" data-code=":8*" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/54.gif"></div></td><td><div class="eItem" style="background-position:-1320px 0;" data-title="菜刀" data-code=":pd" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/55.gif"></div></td><td><div class="eItem" style="background-position:-1344px 0;" data-title="西瓜" data-code=":&lt;W&gt;" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/56.gif"></div></td><td><div class="eItem" style="background-position:-1368px 0;" data-title="啤酒" data-code=":beer" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/57.gif"></div></td><td><div class="eItem" style="background-position:-1392px 0;" data-title="篮球" data-code=":basketb" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/58.gif"></div></td><td><div class="eItem" style="background-position:-1416px 0;" data-title="乒乓" data-code=":oo" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/59.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-1440px 0;" data-title="咖啡" data-code=":coffee" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/60.gif"></div></td><td><div class="eItem" style="background-position:-1464px 0;" data-title="饭" data-code=":eat" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/61.gif"></div></td><td><div class="eItem" style="background-position:-1488px 0;" data-title="猪头" data-code=":pig" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/62.gif"></div></td><td><div class="eItem" style="background-position:-1512px 0;" data-title="玫瑰" data-code=":rose" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/63.gif"></div></td><td><div class="eItem" style="background-position:-1536px 0;" data-title="凋谢" data-code=":fade" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/64.gif"></div></td><td><div class="eItem" style="background-position:-1560px 0;" data-title="示爱" data-code=":showlove" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/65.gif"></div></td><td><div class="eItem" style="background-position:-1584px 0;" data-title="爱心" data-code=":heart" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/66.gif"></div></td><td><div class="eItem" style="background-position:-1608px 0;" data-title="心碎" data-code=":break" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/67.gif"></div></td><td><div class="eItem" style="background-position:-1632px 0;" data-title="蛋糕" data-code=":cake" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/68.gif"></div></td><td><div class="eItem" style="background-position:-1656px 0;" data-title="闪电" data-code=":li" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/69.gif"></div></td><td><div class="eItem" style="background-position:-1680px 0;" data-title="炸弹" data-code=":bome" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/70.gif"></div></td><td><div class="eItem" style="background-position:-1704px 0;" data-title="刀" data-code=":kn" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/71.gif"></div></td><td><div class="eItem" style="background-position:-1728px 0;" data-title="足球" data-code=":footb" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/72.gif"></div></td><td><div class="eItem" style="background-position:-1752px 0;" data-title="瓢虫" data-code=":ladybug" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/73.gif"></div></td><td><div class="eItem" style="background-position:-1776px 0;" data-title="便便" data-code=":shit" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/74.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-1800px 0;" data-title="月亮" data-code=":moon" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/75.gif"></div></td><td><div class="eItem" style="background-position:-1824px 0;" data-title="太阳" data-code=":sun" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/76.gif"></div></td><td><div class="eItem" style="background-position:-1848px 0;" data-title="礼物" data-code=":gift" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/77.gif"></div></td><td><div class="eItem" style="background-position:-1872px 0;" data-title="拥抱" data-code=":hug" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/78.gif"></div></td><td><div class="eItem" style="background-position:-1896px 0;" data-title="强" data-code=":strong" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/79.gif"></div></td><td><div class="eItem" style="background-position:-1920px 0;" data-title="弱" data-code=":weak" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/80.gif"></div></td><td><div class="eItem" style="background-position:-1944px 0;" data-title="握手" data-code=":share" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/81.gif"></div></td><td><div class="eItem" style="background-position:-1968px 0;" data-title="胜利" data-code=":v" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/82.gif"></div></td><td><div class="eItem" style="background-position:-1992px 0;" data-title="抱拳" data-code=":@)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/83.gif"></div></td><td><div class="eItem" style="background-position:-2016px 0;" data-title="勾引" data-code=":jj" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/84.gif"></div></td><td><div class="eItem" style="background-position:-2040px 0;" data-title="拳头" data-code=":@@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/85.gif"></div></td><td><div class="eItem" style="background-position:-2064px 0;" data-title="差劲" data-code=":bad" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/86.gif"></div></td><td><div class="eItem" style="background-position:-2088px 0;" data-title="爱你" data-code=":lvu" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/87.gif"></div></td><td><div class="eItem" style="background-position:-2112px 0;" data-title="NO" data-code=":no" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/88.gif"></div></td><td><div class="eItem" style="background-position:-2136px 0;" data-title="OK" data-code=":ok" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/89.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-2160px 0;" data-title="爱情" data-code=":love" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/90.gif"></div></td><td><div class="eItem" style="background-position:-2184px 0;" data-title="飞吻" data-code=":&lt;L&gt;" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/91.gif"></div></td><td><div class="eItem" style="background-position:-2208px 0;" data-title="跳跳" data-code=":jump" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/92.gif"></div></td><td><div class="eItem" style="background-position:-2232px 0;" data-title="发抖" data-code=":shake" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/93.gif"></div></td><td><div class="eItem" style="background-position:-2256px 0;" data-title="怄火" data-code=":&lt;O&gt;" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/94.gif"></div></td><td><div class="eItem" style="background-position:-2280px 0;" data-title="转圈" data-code=":circle" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/95.gif"></div></td><td><div class="eItem" style="background-position:-2304px 0;" data-title="磕头" data-code=":kotow" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/96.gif"></div></td><td><div class="eItem" style="background-position:-2328px 0;" data-title="回头" data-code=":turn" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/97.gif"></div></td><td><div class="eItem" style="background-position:-2352px 0;" data-title="跳绳" data-code=":skip" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/98.gif"></div></td><td><div class="eItem" style="background-position:-2376px 0;" data-title="挥手" data-code=":oY" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/99.gif"></div></td><td><div class="eItem" style="background-position:-2400px 0;" data-title="激动" data-code=":#-0" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/100.gif"></div></td><td><div class="eItem" style="background-position:-2424px 0;" data-title="街舞" data-code=":hiphot" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/101.gif"></div></td><td><div class="eItem" style="background-position:-2448px 0;" data-title="献吻" data-code=":kiss" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/102.gif"></div></td><td><div class="eItem" style="background-position:-2472px 0;" data-title="左太极" data-code=":&lt;&amp;" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/103.gif"></div></td><td><div class="eItem" style="background-position:-2496px 0;" data-title="右太极" data-code=":&amp;&gt;" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/104.gif"></div></td></tr></tbody></table><div class="emotionsGif" style=""></div></div>
	
</body></html>