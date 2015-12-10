define(function (require) {
	var $ = require('jquery');
	var aci = require('aci');
	require('bootstrap');
	require('jquery-ui-dialog-extend');//ajax弹窗

$("#reverseBtn").click(function(){
			aci.ReverseChecked('pid[]');	
		});
		
		$("#deleteBtn").click(function(){
			var _arr = aci.GetCheckboxValue('pid[]');
			if(_arr.length==0)
			{
				alert("请先勾选明细");
				return false;
			}
			
			if(confirm("确定要删除菜单？"))
			{	

				$("#form_list").attr("action",SITE_URL+folder_name+"/WechatSite/delete/");
				
				$("#form_list").submit();
			}
		});

		
});

