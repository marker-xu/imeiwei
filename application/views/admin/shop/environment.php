<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台-环境设置<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/css/main-b.min.css?v=<%#v#%>">
<%/block%>

<%block name="custom_js"%>
<script type="text/javascript" src="<%#resUrl#%>/js/admin/common/main-b.js?v=<%#v#%>"></script>
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
				<h4 class="tit2">就餐环境</h4>
				<div class="form-body">
					<div class="no-shop-photo">
						<br/><br/><br/>
						你还没有上传就餐的环境照片，现在就来上传吧<br/>
						<input type="button" name="submit-shop-photo" class="submit-shop-photo submit-mix" value="浏览..." />
					</div>
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