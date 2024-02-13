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
        });
});