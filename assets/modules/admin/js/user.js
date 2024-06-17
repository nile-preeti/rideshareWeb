$(document).ready(function() {
	$(document).on('click', '.btnaction', function () {
            var action = $(this).attr('data-original-title');
            var id = $(this).attr('id');
            if (action == 'edit' || action == "view"){
                $.ajax({
                    type: 'post',
                    url: base_url+'admin/getUser',
                    data: "user_id=" + id,
                    success: function (data) {
                        $("#confirm").modal("show");
                        $("#response").html(data);
                    }
                });
            }
			
			if (action == 'change_password' || action == "view")
			{
				
				$.ajax({

					type: 'post',

					url: base_url + 'admin/getPassword',

					data: "user_id=" + id,

					success: function (data) {

						$("#confirm").modal("show");

						$("#response").html(data);

					}
				});
				
			}
		
            if (action == 'delete') {
                $('#confirmdel')
				.modal('show', {backdrop: 'static', keyboard: false})
				.one('click', '#delete', function (e) {
					$.ajax({
						type: 'post',
						url: base_url+'admin/delete_user',
						data: "user_id=" + id,
						success: function () {
							alert('Rider record has been deleted successfully'); 
							
							$('.hiderow' + id).closest('tr').hide();
							setTimeout(() => window.location.reload(), 1800);                                    
						}
					});
				});
            }
			
			
			if (action == 'recover_account') {
                $('#confrecover')
				.modal('show', {backdrop: 'static', keyboard: false})
				.one('click', '#recover', function (e) {
					$.ajax({
						type: 'post',
						url: base_url+'admin/recover_user',
						data: "user_id=" + id,
						success: function () {
							alert('Rider record has been recovered successfully'); 
							
							$('.hiderow' + id).closest('tr').hide();
							setTimeout(() => window.location.reload(), 1800);                                    
						}
					});
				});
            }
			
			
			if (action == 'permanently_delete') {
				
                $('#confirmdeldelete')
				.modal('show', {backdrop: 'static', keyboard: false})
				.one('click', '#deleteall', function (e) {
					$.ajax({
						type: 'post',
						url: base_url+'admin/delete_user_permanent',
						data: "user_id=" + id,
						success: function () {
							alert('Rider record has been deleted successfully'); 
							
							$('.hiderow' + id).closest('tr').hide();
							setTimeout(() => window.location.reload(), 1800);                                    
						}
					});
				});
            }
        });
});