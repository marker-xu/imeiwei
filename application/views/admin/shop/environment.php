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
		<%include file="inc/admin/left.inc"%>
		<div class="contents">
			<%include file="inc/admin/shop_header.inc"%>
			
			<div id="base-info">
				<h4 class="tit2">就餐环境</h4>
				<div class="form-body">
					<ul class="shop-photo float_box">
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
					</ul>
					<ol class="pages">
						<li>4</li><li>3</li><li>2</li><li class="active">1</li>
					</ol>
				</div>
			</div>
			
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<script type="text/javascript">
</script>
<%/block%>