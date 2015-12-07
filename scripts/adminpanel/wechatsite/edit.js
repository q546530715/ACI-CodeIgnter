define(function (require) {
	var $ = require('jquery');
	var aci = require('aci');
	require('bootstrap');
	require('jquery-ui-dialog-extend');
	require('bootstrapValidator');
	
	$(".uploadThumb_a").click(function(){

		$.extDialogFrame(SITE_URL+folder_name+"/user/upload/thumb/thumb/1",{model:true,width:600,height:250,title:'请上传...',buttons:null});
	});

	

});
