			<div class="navgations">
			<div class="head-pic">
				<div class="pic">
					<img src="<%#resUrl#%>/css/img/headphoto.jpg?v=<%#v#%>" class="head" />
				</div>
			</div>
			<ul id="navlist">
				<li class="<%if $current_action=="index"%>active<%/if%> nav1 "><a href="/admin">基本信息</a></li>
				<li class="<%if $current_action=="environment" or $current_action=="env_add"%>active<%/if%> nav2"><a href="/admin/shop/environment">就餐环境</a></li>
				<li class="<%if $current_action=="category"%>active<%/if%> nav3"><a href="javascript:void(0);">菜单品类</a></li>
				<li class="<%if $current_action=="preferential"%>active<%/if%> nav4"><a href="javascript:void(0);">优惠设置</a></li>
				<li class="<%if $current_action=="takeaway"%>active<%/if%> nav5"><a href="javascript:void(0);">外送设置</a></li>
				<li class="<%if $current_action=="comments"%>active<%/if%> nav6"><a href="javascript:void(0);">用户评论</a></li>
			</ul>
		</div>
			
