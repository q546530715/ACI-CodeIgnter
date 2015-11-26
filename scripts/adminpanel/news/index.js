requirejs(['jquery','aci','bootstrap'],
	function($,aci) {
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
				$("#form_list").attr("action",SITE_URL+folder_name+"/news/delete/");
				$("#form_list").submit();
			}
		});
});