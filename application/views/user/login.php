<%extends file="common/base.tpl"%>

<%block name="title"%>登陆<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<%/block%>

<%block name="custom_js"%>
<%/block%>
<%block name="bd"%>
<div id="bd">
<h3>How do you see?</h3>
<div style="width:186px;">
<a href="javascript:void(0);"  class="btn_login" ></a>您还没有登录，
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
