<div id="box">
	<div class="title_sel">
		<label>类别：</label>
		<select class="validate[required]" name="category_id">
			<option value="0">请选择类别</option>
			<?php if(!empty($categorys))
				foreach ($categorys as $category):	
			?>
				<option value="<?php echo $category->id; ?>"><?php echo $category->name;?></option>
			<?php endforeach;?>
		</select>
	</div>
	<form method="post" id="user_form" class="user_form formular">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tab" class="table_box list_t_c">
		  <tr class="bj_g">
		  	<td>全选&nbsp;&nbsp;<input type="checkbox" class="check" name="checkall"/></td>
		    <td>项目名称</td>
		    <td>字符测试</td>
		  </tr>
		</table>
		<div class="button_c">
			<input type="image" src="/images/button2.jpg" name="add" />
			<input type="image" src="/images/button21.jpg" name="delete" />
			<input type="image" src="/images/button3.jpg" name="save" />
			<input type="image" src="/images/button4.jpg" onclick="window.print()" name="print"> 
		</div>
	</form>
</div>


<script type="text/javascript">

$(function(){
	
	var record = function(){
		// 分类id及分类下的item
		var param = {
			getItemUrl: 'getItems',          //获取分类下的自定义参数
		}; 

		// 当前分类id
		var category_id = 0;

		// 该分类下的自定义配置参数
		var items = null;
		
		// 将个自定义选项组合成select
		var formatItems = function(){
			var html = '<select name="Custom[itemName][]">';
			$.each(items,function(i, item){
				html += '<option value="'+item.value+'">'+item.name+'</option>';
			});
			html += '</select>';
			return html;
		};

		// 增加一条
		var add = function(){
			if(items != null){
				var tr = "<tr><td><input type=\"checkbox\" class=\"key\" /></td><td>";
				tr += formatItems();
				tr += "<td><input class=\"validate[required] text-input\" type=\"text\" name=\"Custom[itemValue][]\" /></td>";
				$("table tr:first").after(tr);
			}
		};
		
		// 事件绑定
		var bind = function(){
			// 选择分类
			$("select[name=category_id]").bind("change", function(){
				var id = $(this).val();
				if(id != 0 && id != category_id){
					category_id = id;
					var url = param.getItemUrl + '/category_id/'+category_id;
					$.get(url,function(result){
						if(result.status == 1){
							items = result.data;
							add();
						}
					}, 'Json');
				}
			});

			// 增加一条
			$(":image[name=add]").bind("click", function(){
				add();
				return false;
			});

			// 全选 | 反选
			$(":checkbox[name=checkall]").bind("click", function(){
				if(this.checked)
					 $('table tr td input[type=checkbox]').attr('checked', true);
				else
					$('table tr td input[type=checkbox]').attr('checked', false);
			});

			// 删除
			$(":image[name=delete]").bind("click", function(){
				var list = $(":checkbox.key:checked");
				if(list.length == 0){
					alert('请选择要删除的选项');
					return false;
				}
				list.each(function(i){
					$(this).closest("tr").remove();
				});
			});
		};

		return function(){
			bind();
		};
	}();

	record();
})
</script>