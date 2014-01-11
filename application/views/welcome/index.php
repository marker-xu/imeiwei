<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<%/block%>

<%block name="custom_js"%>
<%/block%>
<%block name="bd"%>
<div id="bodyer">
	<div class="bodyone">
		<div class="focus-pic"></div>
		<div class="login-and-reg">点此登录<a href="javascript:" class="btn_login" >QQ登录</a> </div>
	</div>
	<div class="bodytwo">
		<div class="news">
			<h3>今日话题</h3>
			<div>
				<h4>2012 爱美味全网商家活动</h4>
				<p>的撒的撒范德萨的发生发松岛枫松岛枫松岛枫松岛枫</p>
			</div>
		</div>
		<div class="addcom">
			<h3>爱美味入住商家</h3>
			<ul>
				<li>必胜客</li>
				<li>DQ</li>
				<li>星巴克</li>
				<li>肯德基</li>
			</ul>
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<script type="text/javascript">
var login_url = "<%$login_url%>";     
	$(document).ready(function(){
		$(".btn_login").click(function(){
			var oauth_login_window = window.open(login_url, "oauth_login_window", "width=700,height=600,toolbar=yes,menubar=yes,resizable=yes,status=yes");

		    oauth_login_window.focus();
		});
	});
</script>
<%/block%>
