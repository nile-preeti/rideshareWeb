$(document).ready(function () {
	$(document).on('click', '#vehicle_type', function () {
		$.ajax({
			url: base_url + "admin/vehicle_type_form",
			type: 'get',
			success: function (data) {
				$('#vehicle_type_model').modal('show');
				$('.vehicle_type_model').html(data);
			}
		});
	});
	$(document).on('click', '#vehicle_subcategory_type', function () {
		$.ajax({
			url: base_url + "admin/vehicle_subcategorytype_form",
			type: 'get',
			success: function (data) {
				$('#vehicle_subcategory_model').modal('show');
				$('.vehicle_subcategory_model').html(data);
			}
		});
	});
	
	
	
	$(document).on('click', '.btnaction', function () {
		
		var action = $(this).attr('data-original-title');
		var id = $(this).attr('id');           
		if (action == 'delete'){
			$('#confirmdel')
			.modal('show', {backdrop: 'static', keyboard: false})
			.one('click', '#delete', function (e) {
				$.ajax({
					type: 'post',
					url: base_url+'admin/delete_vehicle_category',
					data: "id=" + id,
					success:function(data){
						alert('Vehicle Category has been deleted successfully');
						$('.hiderow' + id).closest('tr').hide();
					   location.reload();
					}
				});
			});
		}
	});
	
	$(document).on('click', '.subcategory_delete', function () {
		
		var action = $(this).attr('data-original-title');
		var id = $(this).attr('id');           
		if (action == 'delete'){
			$('#confirmdelsubcategory')
			.modal('show', {backdrop: 'static', keyboard: false})
			.one('click', '#delete', function (e) {
				$.ajax({
					type: 'post',
					url: base_url+'admin/delete_vehicle_subcategory',
					data: "id=" + id,
					success:function(data){
						alert('Vehicle Subcategory has been deleted successfully');
						$('.hiderow' + id).closest('tr').hide();
					   location.reload();
					}
				});
			});
		}
	});
		
		
		

});