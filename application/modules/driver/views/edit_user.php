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

        <h4 class="">Edit user</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

    </div>

    <div class="oc-modal-form">

        <form enctype="multipart/form-data" class="form-horizontal"  action="<?php echo $this->config->base_url() ?>admin/users/update" method="post" role="form" id="register-form">

            <input type="hidden" value="<?php echo!empty($post['user_id']) ? $post['user_id'] : ''; ?>" name="user_id" id="user_id" />

            <div class="row">

                <div class="col-md-4">

                    <label class="control-label  ">Name<span class="vd_red">*</span></label>

                    <div id="first-name-input-wrapper"  class="controls ">

                        <input type="text" placeholder="John" value="<?php echo!empty($post['name']) ? $post['name'] : ''; ?>" class="width-120 required" name="name" id="name" required >

                    </div>

                </div>



                <div class="col-md-4">

                    <label class="control-label ">Mobile no.</label>

                    <div id="website-input-wrapper"  class="controls ">

                        <input type="text" placeholder="+66 1234 56789" class="width-120" value="<?php echo!empty($post['mobile']) ? $post['mobile'] : ''; ?>"  name="mobile" id="mobile">

                    </div>

                </div>

                <div class="col-md-4">

                    <label class="control-label" >Email <span class="vd_red">*</span></label>

                    <div id="email-input-wrapper"  class="controls ">

                        <input type="email" placeholder="Email" class="width-120 required" required value="<?php echo!empty($post['email']) ? $post['email'] : ''; ?>" name="email" id="email">

                    </div>

                </div>

                <div class="col-md-4">

                    <label class="control-label" >Profile Image <span class="vd_red">*</span></label>

                    <div id="email-input-wrapper"  class="controls ">

                        <a href="<?php echo base_url('uploads/profile_image/'.$post['user_id'].'/'.$post['avatar']);?>" data-fancybox="gallery">

                            <img id="img" src="<?php echo base_url('uploads/profile_image/'.$post['user_id'].'/'.$post['avatar']);?>" />

                            </a>

                       

                        

                    </div>

                </div>

                <div class="col-md-6 mt-20">

                    <label class="control-label ">Identification Document Type</label>

                    <div id="email-input-wrapper"  class="controls ">

                        <div class="vd_radio radio-success">

                            <select name="identification_document">

                            <?php foreach($identifications->result() as $identification){?>

                                <option value="<?php echo $identification->id?>" <?php echo ($post['identification_document_id']==$identification->id)?'selected':''?>><?php echo $identification->document_name?></option>

                            <?php }?>

                            </select>

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

        var mobile = $('#mobile').val();

        var email = $('#email').val();

        var user_id = $('#user_id').val();

        var status = $('.status:checked').val();

        $.ajax({

            url:base_url+'admin/update_user',

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