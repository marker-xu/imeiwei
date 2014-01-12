/**
 * ...
 * @author 小辉
 */
$(document).ready(function(){
	var phoneNum = 1; //当前的电话输入框个数
	$('#addPhone').click(function(){
		phoneNum ++;
		if(phoneNum>4){
			return;
		}
		var addPhoneHtml = '<br/><input type="text" class="b-phone-input" id="phone0'+phoneNum+'" name="phone0'+phoneNum+'" />';
		$(addPhoneHtml).insertBefore(this);
		if(phoneNum==4){
			$(this).replaceWith('<span class="margin-l-little tips">最多只能添加'+phoneNum+'条记录</span>');	
		}
		
		//var tips = new amw.tips(250,110);
		
	});
});