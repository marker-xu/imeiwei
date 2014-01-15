<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/css/main-b.min.css?v=<%#v#%>">
<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/js/third/numkeybord/numkeybord.min.css?v=<%#v#%>">
<%/block%>

<%block name="custom_js"%>
<script type="text/javascript" src="<%#resUrl#%>/js/admin/common/main-b.js?v=<%#v#%>"></script>
<script type="text/javascript" src="<%#resUrl#%>/js/third/numkeybord/numkeybord.js?v=<%#v#%>"></script>
<script type="text/javascript" src="<%#resUrl#%>/js/third/bootstrap/bootstrap.js"></script>
<%/block%>
<%block name="bd"%>
<div id="main-body">
	<div class="center float_box">
		<div class="navgations">
			<div class="head-pic">
				<div class="pic">
					<img src="<%#resUrl#%>/css/img/headphoto.jpg?v=<%#v#%>" class="head" />
				</div>
			</div>
			<%include file="inc/left.inc"%>
		</div>
		<div class="contents">
			
			
			<div id="store-info-header">
				<div class="lefter">
					<h3 class="float_box"><span class="name">家乡人猫肉馆</span><span class="staic">正常营业</span></h3>
					<ul class="star-ul">
						<li class="all-star"></li>
						<li class="all-star"></li>
						<li class="all-star"></li>
						<li class="all-star"></li>
						<li class="half-star"></li>
					</ul>
				</div>
				<div class="righter">
					<div class="now-time">2013年12月12号 11:30</div>
				</div>
			</div>
			<div id="base-info">
				<h4>基本信息</h4>
				<div class="form-body">
					<table class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr><td class="keys">商户名称:</td><td class="values"><input class="b-name-input" type="input" /></td></tr>
						<tr><td>地　　址:</td><td class="values"><select><option value="111">上海浦东新区</option></select><input class="b-sdr-input margin-l-little" type="input" /></td></tr>
						<tr><td>主打菜系:</td><td class="values"><select><option value="111">港式茶餐厅</option></select><a class="margin-l-little" href="#">没有你要的选项？</a></td></tr>
						<tr><td>服务电话:</td><td class="values add-phones"><input type="text" class="b-phone-input" id="phone01" name="phone01" /><a id="addPhone" class="margin-l-little" href="javascript:void(0)">增加</a></td></tr>
					</table>
					<script>
					$(function(){
					   $("#phone01").numkeybord();
						
					});
					</script>
					<input id="submiter" type="button" name="submiter" class="submiter" value="保存" />
				</div>
			</div>
			
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<script type="text/javascript">
$(function(){
					   $("#phone01").numkeybord();
					});
</script>
<%/block%>