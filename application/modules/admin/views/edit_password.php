<!-- Editing the user  -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/modules/admin/css/fancybox.css');?>">

<style type="text/css">

    .heading-popup{padding:10px; background: #3c485c;  margin-bottom: 30px;}

    .heading-popup h4{margin-bottom: 0px; color: #fff; font-size: 14px; font-weight: 400; }

    .panel .panel-body {padding: 0px 0px 25px; }

    .mt-20{margin-top: 40px;}

    button.close {

    -webkit-appearance: none;

    padding: 1px 8px 3px;

    background: #f44336;

    border: 0;

    position: absolute;

    right: 10px;

    top: 6px;

    color: #fff;

    border-radius: 5px;

    opacity: inherit;}

    .close:hover, .close:focus {

    color: #fff;

    text-decoration: none;

    cursor: pointer;

    filter: alpha(opacity=50);

    opacity: .5;

}
.Short {  
    width: 100%;  
    background-color: #dc3545;  
    margin-top: 5px;  
    height: 3px;  
    color: #dc3545;  
    font-weight: 500;  
    font-size: 12px;  
}  
.Weak {  
    width: 100%;  
    background-color: #ffc107;  
    margin-top: 5px;  
    height: 3px;  
    color: #ffc107;  
    font-weight: 500;  
    font-size: 12px;  
}  
.Good {  
    width: 100%;  
    background-color: #28a745;  
    margin-top: 5px;  
    height: 3px;  
    color: #28a745;  
    font-weight: 500;  
    font-size: 12px;  
}  
.Strong {  
    width: 100%;  
    background-color: #d39e00;  
    margin-top: 5px;  
    height: 3px;  
    color: #d39e00;  
    font-weight: 500;  
    font-size: 12px;  
} 


</style>





<div class="oc-modal-box">

    <div class="oc-modal-heading">

        <h4 class="">Change Password</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-bs-backdrop="static">

          <span aria-hidden="true">&times;</span>

        </button>

    </div>

    <div class="oc-modal-form">

        <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('admin/update_passpord'); ?>" method="post" role="form" id="register-form">

            <input type="hidden" value="<?php echo!empty($post['user_id']) ? $post['user_id'] : ''; ?>" name="user_id" id="user_id" />

            <div class="row">

                <div class="col-md-8">

                    <label class="control-label ">Add New Password</label>

                    <div id="website-input-wrapper" class="controls">

                        <input type="password" placeholder="New Password" class="width-120 form-controls" name="password" id="password" onChange="validtxt()" required / >
						<div id="strengthMessage"></div> 
                    </div>

                </div>
				<div class="col-md-4" style="margin-top:27px !important">

                    <button class="btn btn-gr" style="padding:10px !important" type="submit" id="submit-register" name="submit-register">Submit</button>

                </div>

                <div class="col-md-6 mt-20">

                    <div id="vd_login-error" class="alert alert-danger hidden"><i class="fa fa-exclamation-circle fa-fw"></i> Please fill the necessary field </div>

                    <div class="form-group">

                        <div class="col-md-9"></div>

                        <div class="col-md-3 mgbt-xs-10 mgtp-20">

                            <div class="vd_checkbox  checkbox-success"></div>

                            <div class="vd_checkbox checkbox-success"></div>

                        </div>

                        <div class="col-md-12 mgbt-xs-5"> </div>

                    </div>

                </div>

                

            </div>

                

        </form>

    </div>

</div>

<script src="<?php echo base_url('assets/modules/admin/js/fancybox.js');?>"></script>
<script type="text/javascript">

    $(document).on('click','#submit-register',function(){

        var password = $('#password').val();
        var user_id = $('#user_id').val();

        if(password.length>2){
			$.ajax({

				url:base_url+'admin/update_passpord',

				type:'post',

				dataType:'json',

				data:{password:password,user_id:user_id},

				success:function(data){
                    console.log(data);
					//alert(data.message);

					location.reload();

				}

			});
			
		}else{
			//alert('Please provide password value');
		}

        

    });


/* function validtxt(){
        var txt = document.getElementById("password").value;
		//alert(txt);
        var len =txt.trim().length;
		if (txt=="") {
			alert("Please fill the new password !");		
		  }else if (len < 6) {
			alert("Password length must be greater than 6. ");		
		  }
	} */
	
	$(document).ready(function () {  
		$('#password').keyup(function () {  
			$('#strengthMessage').html(checkStrength($('#password').val()))  
		})  
		function checkStrength(password) {  
			var strength = 0  
			if (password.length < 6) {  
				$('#strengthMessage').removeClass()  
				$('#strengthMessage').addClass('Short')  
				return 'Too short'  
			}  
			if (password.length > 7) strength += 1  
			// If password contains both lower and uppercase characters, increase strength value.  
			if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1  
			// If it has numbers and characters, increase strength value.  
			if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1  
			// If it has one special character, increase strength value.  
			if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1  
			// If it has two special characters, increase strength value.  
			if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1  
			// Calculated strength value, we can return messages  
			// If value is less than 2  
			if (strength < 2) {  
				$('#strengthMessage').removeClass()  
				$('#strengthMessage').addClass('Weak')  
				return 'Weak'  
			} else if (strength == 2) {  
				$('#strengthMessage').removeClass()  
				$('#strengthMessage').addClass('Good')  
				return 'Good'  
			} else {  
				$('#strengthMessage').removeClass()  
				$('#strengthMessage').addClass('Strong')  
				return 'Strong'  
			}  
		}  
	}); 
</script>