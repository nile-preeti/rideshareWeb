$(document).on('click', '.btnaction', function () {
    var action = $(this).attr('data-original-title');
    var id = $(this).attr('id');
    if (action == 'view') {
		
        $.ajax({
            type: 'post',
            url: base_url+'admin/viewDriver',
            data: "user_id=" + id,
            success: function (data) {
                $("#confirm").modal("show");
                $("#response").html(data);
            }
        });
    }

    if (action == 'edit') {
        $.ajax({
            type: 'post',
            url: base_url+'admin/getDriver',
            data: "user_id=" + id,
            success: function (data) {
                $("#confirm").modal("show");
                $("#response").html(data);
            }
        });
    }           
    if (action == 'edit_bankdetails') {
        $.ajax({   
            
            type: 'post', 
            url: base_url+'admin/getbankdetails',  
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
					url: base_url+'admin/delete_driver',
					data: "user_id=" + id,
					success:function(data){
						alert('Driver record has been deleted successfully');
						$('.hiderow' + id).closest('tr').hide();
					   location.reload();
					}
				});
		});
    }
	
	
	if (action == 'permanently_delete') {
        $('#confirmdeldeldriver')
		.modal('show', {backdrop: 'static', keyboard: false})
			.one('click', '#deleteDriver', function (e) {
				$.ajax({
					type: 'post',
					url: base_url+'admin/delete_driver_permanet',
					data: "user_id=" + id,
					success:function(data){
						alert('Driver record has been deleted successfully');
						$('.hiderow' + id).closest('tr').hide();
					   location.reload();
					}
				});
		});
    }
	
	
	
	if (action == 'recover_account') {
        $('#confrecover')
		.modal('show', {backdrop: 'static', keyboard: false})
			.one('click', '#recover_account', function (e) {
				$.ajax({
					type: 'post',
					url: base_url+'admin/recover_driver_acccount',
					data: "user_id=" + id,
					success:function(data){
						alert('Driver account has been recovered successfully');
						$('.hiderow' + id).closest('tr').hide();
					   location.reload();
					}
				});
		});
    }
	
	
	if (action == 'change_password')
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



         // Check box
        $("#checkAll").click(function () {
             $(".check").prop('checked', $(this).prop('checked'));           
            
        });

        $('#approved').click(function(){
            var unapproved = [];
            $.each($("input[name='approve[]']:checked"), function(){            
                unapproved.push($(this).val());
            });            
                   
            $.ajax({
                url:base_url+'admin/approve_driver',
                type:'post',
                data:{unapproved:unapproved},
                dataType:'json',
                success:function(res){
                    if (res.status==true) {
                        alert(res.message);
                        location.reload();
                    }
                }
            });
        });
});

