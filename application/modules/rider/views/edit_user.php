<!-- Editing the user  -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/modules/admin/css/fancybox.css');?>">

<style type="text/css">

    .heading-popup{padding:10px; background: #3c485c;  margin-bottom: 30px;}

    .heading-popup h4{margin-bottom: 0px; color: #fff; font-size: 14px; font-weight: 400; }

    .panel .panel-body {padding: 0px 0px 25px; }

    .mt-20{margin-top: 20px;}
    .img_limit{
        height:250px;
        width:auto;

    }
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
<div class="vd_content-wrapper">

    <div class="vd_container">

        <div class="vd_content clearfix">

            <div class="vd_head-section clearfix">

                <div class="vd_panel-header">

                    <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">

                        <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>

                        <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>

                        <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>

                    </div>

                </div>

            </div>

            <div class="vd_content-section clearfix">

                <div class="panel widget oc-panel light-widget">
                   
                    <div class="panel-body">
                        <div class="panel widget">
                            <div  class="search-filter">                       
                                    <div  class="row">  
                                    <div class="oc-modal-box">
                                        <div class="oc-modal-heading">
                                            <h4 class="">Edit user</h4>
                                        </button>

                                        </div>

                                        <div class="oc-modal-form">

                                            <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('rider/login/update_user')?>" method="post" role="form" id="register-form">

                                                <input type="hidden" value="<?php echo $post->user_id; ?>" name="user_id" id="user_id">

                                                <div class="row">

                                                    <div class="col-md-4">

                                                        <label class="control-label  ">Name<span class="vd_red">*</span></label>

                                                        <div id="first-name-input-wrapper" class="controls ">

                                                            <input type="text" placeholder="John" value="<?php echo $post->name; ?>" class="width-120 required" name="name" id="name" required="">

                                                        </div>

                                                    </div>



                                                    <div class="col-md-4">

                                                        <label class="control-label ">Mobile no.</label>

                                                        <div id="website-input-wrapper" class="controls ">

                                                            <input type="text" placeholder="<?php echo $post->mobile; ?>" class="width-120" value="6039316242" name="mobile" id="mobile">

                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label class="control-label">Email <span class="vd_red">*</span></label>

                                                        <div id="email-input-wrapper" class="controls ">

                                                            <input type="email" placeholder="Email" class="width-120 required" required="" value="<?php echo $post->email; ?>" name="email" id="email">

                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label class="control-label">Profile Image <span class="vd_red">*</span></label>

                                                        <div id="email-input-wrapper" class="controls ">
                                                        <input type="file" class="form-control" id="profile_image" name="avtar">
                                                            <a href="<?php echo base_url('uploads/profile_image/') ?><?php echo $post->user_id; ?>/<?php echo $post->avatar; ?>" data-fancybox="gallery">

                                                                <img id="img" src="<?php echo base_url('uploads/profile_image/') ?><?php echo $post->user_id; ?>/<?php echo $post->avatar; ?>">

                                                                </a>

                                                        

                                                            

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6 mt-20">

                                                        <label class="control-label ">Identification Document Type</label>

                                                        <div id="email-input-wrapper" class="controls ">

                                                            <div class="vd_radio radio-success">

                                                            <select name="identification_document">

                                                            <?php foreach($identifications->result() as $identification){?>

                                                                <option value="<?php echo $identification->id?>" <?php echo ($post->identification_document_id == $identification->id)?'selected':''?>><?php echo $identification->document_name?></option>

                                                            <?php }?>

                                                            </select>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label class="control-label">Identification Document <span class="vd_red">*</span></label>

                                                        <div id="email-input-wrapper" class="controls">
                                                        <input type="file" class="form-control" id="verification_id" name="verification_id">
                                                            <a href="<?php echo base_url('uploads/verification_document/') ?><?php echo $post->user_id; ?>/<?php echo $post->verification_id; ?>" data-fancybox="gallery">
                                                                <img id="img" src="<?php echo base_url('uploads/verification_document/') ?><?php echo $post->user_id; ?>/<?php echo $post->verification_id; ?>" class="img_limit">
                                                            </a>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6 mt-20">

                                                        <label class="control-label ">Status</label>

                                                        <div id="email-input-wrapper" class="controls ">

                                                        <div class="vd_radio radio-success">

                                                            <input type="radio" <?php echo!empty($post->status) ? $post->status == 1 ? 'checked' : ''  : '' ?> class="radiochk status" value="1" id="optionsRadios8" name="status">

                                                            <label for="optionsRadios8"> Active</label>

                                                            <input type="radio" <?php echo ($post->status==4) ? 'checked' : '' ?> value="4" class="radiochk status" id="optionsRadios9" name="status">

                                                            <label for="optionsRadios9"> Inactive</label>

                                                        </div>

                                                        </div>

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

                                                    <div class="col-md-12 mt-20">

                                                        <button class="btn btn-gr" type="button" id="submit-register" name="submit-register">Submit</button>

                                                    </div>

                                                </div>

                                                    

                                            </form>

                                        </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div> 
                </div>       
            </div>
        </div>        
    </div>        

<script src="<?php echo base_url('assets/modules/admin/js/fancybox.js');?>"></script>

<script type="text/javascript">

    $(document).on('click','#submit-register',function(){

        var name = $('#name').val();

        var mobile = $('#mobile').val();

        var email = $('#email').val();

        var user_id = $('#user_id').val();

        var status = $('.status:checked').val();

        $.ajax({

            url:base_url+'login/update_user',

            type:'post',

            dataType:'json',

            data:{name:name,mobile:mobile,email:email,status:status,user_id:user_id},

            success:function(data){

                alert(data.message);

                location.reload();

            }

        });

    });

</script>