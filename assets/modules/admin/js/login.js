$(document).ready(function() {
	
	$('#forgot-password').on('click',function(){
		$.ajax({
			url:base_url+'admin/forgot_form',
			type:'get',
			
			success:function(data){
				$('#forgot-form').modal('show');
				$('.forgot-form').html(data);
			}
		})
	})
	
	$('#forgot-password-driver').on('click',function(){
		
		$.ajax({
			url:base_url+'driver/login/forgot_form',
			type:'get',
			
			success:function(data){
				$('#forgot-form').modal('show');
				$('.forgot-form').html(data);
			}
		})
	})
});