<!-- Editing the user  -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/modules/admin/css/fancybox.css');?>">

<style type="text/css">

    .heading-popup{padding:10px; background: #3c485c;  margin-bottom: 30px;}

    .heading-popup h4{margin-bottom: 0px; color: #fff; font-size: 14px; font-weight: 400; }

    .panel .panel-body {padding: 0px 0px 25px; }

    .mt-20{margin-top: 20px;}

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

  .swal-modal {
    width: 378px !important;
    opacity: 0;
    pointer-events: none;
    background-color: #FFF8A6 !important;
  }
  

</style>



<script>

    function imageIsLoadededit(e) {

        $('#myImgedit').show();

        $('#myno_img').hide();

        $('#myImgedit').attr('src', e.target.result);

        $('#image-div').hide();

    };

    $(function(){

        $('#myImgedit').hide();

        $("#edituploadBtn").change(function () {

            $(".edit-file").val($("#edituploadBtn").val());

            if (this.files && this.files[0]) {

                var reader = new FileReader();

                reader.onload = imageIsLoadededit;

                reader.readAsDataURL(this.files[0]);

            }

        });

       

    });

</script>

<div class="oc-modal-box">

    <div class="oc-modal-heading">

        <h4 class="">Edit Rider</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

    </div>

    <div class="oc-modal-form">

        <form enctype="multipart/form-data" class="form-horizontal"  action="<?php echo $this->config->base_url() ?>admin/users/update" method="post" role="form" id="register-form">

            <input type="hidden" value="<?php echo!empty($post['user_id']) ? $post['user_id'] : ''; ?>" name="user_id" id="user_id" />

            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Name<span class="vd_red">*</span></label>
					<div class="form-group mt-2 d-inline" style="display:flex">
						<span class="border-end country-code px-2" style="margin-left:10px">			
							<select class="form-control" id="name_title" name="name_title">
								<option value="Mr." <?php echo ($post['name_title']=='Mr.')?'selected':''; ?>>Mr.</option>
							   <option value="Ms." <?php echo ($post['name_title']=='Ms.')?'selected':''; ?>>Ms.</option>
							   <option value="Boss" <?php echo ($post['name_title']=='Boss')?'selected':''; ?>>Boss</option>
							</select>
						</span>															
						<input type="text" class="form-control" id="name" style=" width: 70%;" name="name" value="<?php echo!empty($post['name']) ? $post['name'] : ''; ?>">
					</div>                    
                </div>

                <div class="col-md-6">
                    <label class="control-label  ">Last Name<span class="vd_red">*</span></label>
                    <div id="first-name-input-wrapper"  class="controls ">
                        <input type="text" value="<?php echo!empty($post['last_name']) ? $post['last_name'] : ''; ?>" class="width-120 required form-control" name="last_name" id="last_name" required >
                    </div>
                </div>
			</div>
			
			<div class="row">
                <div class="col-md-6">
                    <label class="control-label ">Mobile no.</label>
					<div class="form-group mt-2 d-inline" style="display:flex">					
						<span class="border-end country-code px-2" style="margin-left:10px">
						<?php $flag= "+";?>
							<select class="form-control" id="country_code" name="country_code">						   
								<?php 							
								foreach($countryCode->result() as $country_code){
								   if($country_code->phone_code==$post['country_code']){ 
								?>
									<option value="<?php echo $flag.$country_code->phone_code;?>" selected ><?php echo $flag.$country_code->phone_code;?></option>
									
								<?php }else{ ?>
									<option value="<?php echo $flag.$country_code->phone_code;?>"> <?php echo $flag.$country_code->phone_code;?></option>
								<?php } }?>
							</select>
						</span>
                        
						<input type="text" class="form-control" id="mobile" placeholder="Mobile" name="mobile" value="<?php echo!empty($post['mobile']) ? $post['mobile'] : ''; ?>" onInput="this.value = phoneFormat(this.value)" min="9" max="14"  name="mobile" id="mobile" style=" width: 70%;">
                    </div>

                </div>

                <div class="col-md-6">
                    <label class="control-label" >Email <span class="vd_red">*</span></label>

                    <div id="email-input-wrapper"  class="controls">

                        <input type="email" placeholder="Email" class="width-120 form-control required" required value="<?php echo!empty($post['email']) ? $post['email'] : ''; ?>" name="email" id="email">
                    </div>
                </div>
				
				
				<div class="col-md-6 mt-20">
                    <label class="control-label ">Status</label>
                    <div id="email-input-wrapper"  class="controls ">
                        <div class="vd_radio radio-success">
                            <input type="radio" <?php echo!empty($post['status']) ? $post['status'] == 1 ? 'checked' : ''  : '' ?> class="radiochk status" value="1" id="optionsRadios8" name="status">
                            <label for="optionsRadios8"> Active</label>
                            <input type="radio" <?php echo ($post['status']==4) ? 'checked' : '' ?> value="4" class="radiochk status" id="optionsRadios9" name="status">
                            <label for="optionsRadios9"> Inactive</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="control-label" >Profile Image <span class="vd_red">*</span></label>
                    <div id="email-input-wrapper"  class="controls ">
                        <!--a href="<?php echo base_url('uploads/profile_image/'.$post['user_id'].'/'.$post['avatar']);?>" data-fancybox="gallery"-->
						<?php if($post['avatar']){?>
							<img id="img" src="<?php echo base_url('uploads/profile_image/'.$post['user_id'].'/'.$post['avatar']);?>" />
						<?php }else{ ?> 
							<img id="img" src="<?php echo base_url('uploads/profile_image/no-img.jpg');?>" />
						<?php } ?>
                            
                            
                    </div>
                </div>

                <!--div class="col-md-6 mt-20">

                    <label class="control-label ">Identification Document Type</label>

                    <div id="email-input-wrapper"  class="controls ">

                        <div class="vd_radio radio-success">                         
                            <?php foreach($identifications->result() as $identification){?>
								<input type="text" placeholder="identification document" class="width-120 required" required value="<?php echo !empty($identification->id) ? $identification->document_name : ''; ?>" name="identification_document">
                                <!--input type="text" value="<--?php echo $identification->id?>" <--?php echo ($post['identification_document_id']==$identification->id)?'selected':''?>><--?php echo $identification->document_name?></option->

                            <?php }?>                           
						</div>

                    </div>

                </div>

                <div class="col-md-4">

                    <label class="control-label" >Identification Document <span class="vd_red">*</span></label>

                    <div id="email-input-wrapper"  class="controls ">

                        <a href="<?php echo base_url('uploads/verification_document/'.$post['user_id'].'/'.$post['verification_id']);?>" data-fancybox="gallery">

                            <img id="img" src="<?php echo base_url('uploads/verification_document/'.$post['user_id'].'/'.$post['verification_id']);?>" />

                            </a>

                       

                       

                    </div>

                </div-->

                

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

                <div class="col-md-12 mt-20">

                    <button class="btn btn-gr" type="button" id="submit-register" name="submit-register">Submit</button>

                </div>

            </div>

                

        </form>

    </div>

</div>

<script src="<?php echo base_url('assets/modules/admin/js/fancybox.js');?>"></script>

<script type="text/javascript">

    $(document).on('click','#submit-register',function(){

        var name = $('#name').val();
        var name_title = $('#name_title').val();
        var last_name = $('#last_name').val();

        var country_code= $('#country_code').val();
		//alert(country_code);

        var mobile = $('#mobile').val();

        var countrycode_mobile = country_code+mobile;
        
        var email = $('#email').val();

        var user_id = $('#user_id').val();

        var status = $('.status:checked').val();

        $.ajax({

            url:base_url+'admin/update_user',

            type:'post',

            dataType:'json',

            //data:{name:name,mobile:mobile,email:email,status:status,user_id:user_id},
            data:{name_title:name_title,name:name,last_name:last_name,country_code:country_code,countrycode_mobile:countrycode_mobile,mobile:mobile,email:email,status:status,user_id:user_id},

            success:function(data){

                //alert(data.message);
				
					swal("Success!!!", data.message);
                setTimeout(() => window.location.reload(), 2500);

            }

        });

    });
	
	function phoneFormat(input) {
		input = input.replace(/\D/g,'').substring(0,10); //Strip everything but 1st 10 digits
		var size = input.length;
		if (size>0) {input="("+input}
		if (size>3) {input=input.slice(0,4)+") "+input.slice(4)}
		if (size>6) {input=input.slice(0,9)+"-" +input.slice(9)}
		return input;
	}

</script>