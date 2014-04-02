<script type="text/javascript">

$(function(){

	// 显示添加用户弹出层
	$('#modaltrigger').leanModal({ top: 150, overlay: 0.45, closeButton: ".hidemodal" });


	var param = {
		searchUrl: '/patient/get',
		addUrl: '/patient/create'
	};

	// 搜索
	$(":image[name=search]").bind("click", function(){
		var keyword = $.trim($("input[name=keyword]").val());
		if(keyword == ''){
			alert('请输入姓名或id');
			return false;
		}
		var url = param.searchUrl + '/keyword/' + keyword;
		$.get(url, function(json){
			if(result.status ==1){
				$("input[name='Record[patient_id]']").val(json.patient.id);
				$("input[name=name]").val(json.patient.name);
				$("input[name='Record[patient_age]']").val(json.patient.age);
			}else{
				alert(result.msg);
			}
		},'json');
	});
	
	// 添加用户
	$("#addUser").validationEngine({
		scroll:false,
		promptPosition:"centerRight",
		maxErrorsPerField:1,
		showOneMessage:true,
		addPromptClass:"formError-noArrow formError-text",
		ajaxFormValidation: true,
		ajaxFormValidationMethod: "POST",
		ajaxFormValidationURL: "/patient/create",
		onAjaxFormComplete: function(status,form,json,options){
			if(json.status == 1){
				alert('添加成功');
				$("input[name='Record[patient_id]']").val(json.patient.id);
				$("input[name=name]").val(json.patient.name);
				$("input[name='Record[patient_age]']").val(json.patient.age);
				$("#lean_overlay").hide();
				$("#loginmodal").css({"display":"none","position":"fixed","opacity":0,"z-index":11000});
			}else{
				alert(json.msg);
			}	
		}
	});


	// 开始检测
// 	$("#userCheck").validationEngine({
// 		scroll:false,
// 		promptPosition:"centerRight",
// 		maxErrorsPerField:1,
// 		showOneMessage:true,
// 		onBeforeAjaxFormValidation: function(){
// 			$("input[name=check]").attr("disabled","disabled");
// 		},
// 		addPromptClass:"formError-noArrow formError-text",
// 		ajaxFormValidation: true,
// 		ajaxFormValidationMethod: "POST",
// 		ajaxFormValidationURL: "/record/create",
// 		onAjaxFormComplete: function(status,form,json,options){
// 			if(json.status == 1){
				
// 			}
// 		}
// 	});

	
})
</script>