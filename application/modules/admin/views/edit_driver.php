<!-- Editing an driver details -->

<style type="text/css">

    .heading-popup{padding:10px; background: #3c485c;  margin-bottom: 20px;}

    .heading-popup h4{margin-bottom: 0px; color: #fff; font-size: 14px;}

    .panel .panel-body {padding: 0px 0px 0px; }

    .mt-20{margin-top: 20px;}

    .label-H label{font-weight: 400; color: #494848; font-size: 12px;}

     button.close {

    -webkit-appearance: none;

    padding: 1px 8px 3px;

    background: #4a5669;

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

<?php $post = $post->row_array();?>

<div class="panel widget oc-panel light-widget">

   <div class="panel-heading">

        <div class="row">

            <div class="col-md-6"> 

                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Edit Driver </h3>

            </div>

            <div class="col-md-6">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

        </div>

    </div>

    <div class="panel-body">

        <div class="panel widget">

            <div  class="search-filter">

                <form enctype="multipart/form-data" class="form-horizontal"  action="<?php echo $this->config->base_url() ?>admin/drivers/update" method="post" role="form" id="register-form">

                    <input type="hidden" value="<?php echo!empty($post['user_id']) ? $post['user_id'] : ''; ?>" name="user_id" id="user_id"/>

                    <div class="row">

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label">Name<span class="vd_red">*</span></label>

                            <div id="first-name-input-wrapper"  class="controls">

                                <input type="text" placeholder="John" value="<?php echo!empty($post['name']) ? $post['name'] : ''; ?>" class="width-120 required" name="name" id="name" required >

                            </div>

                        </div>

        

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label">Mobile no.</label>

                            <div id="website-input-wrapper"  class="controls">

                                <input type="text" placeholder="+66 1234 56789" class="width-120" value="<?php echo!empty($post['mobile']) ? $post['mobile'] : ''; ?>"  name="mobile" id="mobile">

                            </div>

                        </div>

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label" >Email <span class="vd_red">*</span></label>

                            <div id="email-input-wrapper"  class="controls">

                                <input type="email" placeholder="Email" class="width-120 required" required value="<?php echo!empty($post['email']) ? $post['email'] : ''; ?>" name="email" id="email">

                            </div>

                        </div>

                    

                    

                        <div class="col-md-4 mb-10 label-H">

                            <label for="brand"> Vehicle make<span class="text-danger">*</span></label>

                            <select class="form-control" name="brand" id="brand">

                                <option value=""> Select Make </option>

                                <?php if ($brands->num_rows()>0) { 

                                  foreach ($brands->result() as $brand) {?>

                                <option value="<?php echo $brand->id;?>" <?php echo ($brand->id==$post['brand'])?'selected':'';?>>

                                    <?php echo $brand->brand_name;?>

                                </option

                                <?php }

                                    }?>

                            </select>                   

                            <?php echo form_error('brand'); ?>

                        </div>

                        <div class="col-md-4 mb-10 label-H">

                            <label for="set_option">Vehicle model make <span class="text-danger">*</span></label>

                            <select class="form-control" name="model" id="set_option">

                                <?php $query = get_table_record(Tables::MODEL,array('status'=>1,'brand_id'=>$post['brand']),'id,brand_id,model_name');

                                    foreach ($query->result() as $value) {?>

                                       <option value="<?php echo $value->id;?>" <?php echo ($value->id==$post['model'])?'selected':'';?>> <?php echo $value->model_name;?></option> 

                                    <?php }

                                ?>

                            </select>

                            <?php echo form_error('model'); ?>

                        </div>

                        <div class="col-md-4 mb-10 label-H">

                            <label for="year">Vehicle year<span class="text-danger">*</span></label>

                            <select class="form-control" name="year" id="year">

                                <option value=""> Select year </option>

                            <?php 

                              for ($i=2000; $i<=date('Y');$i++) {?>

                                <option value="<?php echo $i;?>" <?php echo ($i==$post['year'])?'selected':'';?>><?php echo $i;?></option>      

                            <?php }?>

                            </select>

                            <?php echo form_error('year'); ?>

                        </div>

                    

                    

                        <div class="col-md-4 mb-10 label-H">

                            <label for="vehicle_type">Vehicle type<span class="text-danger">*</span></label>

                            <select class="form-control" name="vehicle_type" id="vehicle_type">

                                <option value=""> Select vehicle type </option>

                            <?php if ($types->num_rows()>0) { 

                                    foreach ($types->result() as $type) {?>

                                <option value="<?php echo $type->id;?>" rate="<?php echo $type->rate;?>" <?php echo ($type->id==$post['vehicle_type'])?'selected':'';?>><?php echo $type->title;?></option>      

                            <?php }

                                }?>

                            </select>

                            <?php echo form_error('vehicle_type'); ?>

                        </div>

                         

                        <div class="col-md-4 mb-10 label-H">

                            <label for="rate">Service rate($)(/mile)<span class="text-danger">*</span></label>

                            <input type="text" class="form-control" id="rate" placeholder="" name="rate" value="<?php echo!empty($post['rate']) ? $post['rate'] : ''; ?>"> 

                            <?php echo form_error('rate'); ?>

                        </div>

                       

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label" >Vehicle number <span class="vd_red">*</span></label>

                            <div id="email-input-wrapper"  class="controls">

                                <input type="text" placeholder="Vehicle Number" class="width-120 required" required value="<?php echo!empty($post['vehicle_no']) ? $post['vehicle_no'] : ''; ?>" name="vehicle_no" id="vehicle_no">

                            </div>

                        </div>

                        <div class="col-md-4 mb-10 label-H">

                            <label for="mobile">Vehicle color<span class="text-danger">*</span></label>

                            <input type="text" class="form-control" id="color" placeholder="Vehicle Color" name="color" value="<?php echo!empty($post['color']) ? $post['color'] : ''; ?>"> 

                            <?php echo form_error('color'); ?>

                        </div>

         

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label">Status</label>

                            <div id="email-input-wrapper"  class="controls">

                                <div class="vd_radio radio-success">

                                    <input type="radio" <?php echo!empty($post['status']) ? $post['status'] == 1 ? 'checked' : ''  : '' ?> class="radiochk status" value="1" id="optionsRadios8" name="status">

                                    <label for="optionsRadios8"> Active</label>

                                    <input type="radio" <?php echo empty($post['status']) ? 'checked' : '' ?> value="0" class="radiochk status" id="optionsRadios9" name="status">

                                    <label for="optionsRadios9"> Deactive</label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label ">Avatar</label>

                            <div id="email-input-wrapper"  class="controls ">

                                <?php if (!empty($post['avatar'])) { ?>

                                    <div id="image-div">

                                        <img id="img" src="<?php echo $post['avatar'] ?>" style="height: 80px;width: 80px"/>

                                    </div>

                                <?php } else {

                                    ?>

                                    <img id="myno_img" style="width: 80px;height: 80px" src="<?= base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />

                                <?php }

                                ?>

                            </div>

                        </div>

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label ">License</label>

                            <input type="file" class="form-control" id="license" name="license" > 

                            <input type="hidden" class="form-control" id="license" name="update_license" value="<?php echo (!empty($post['license']))?$post['license']:'';?>"> 

                            <div id="email-input-wrapper"  class="controls ">

                                <?php if (!empty($post['license'])) { ?>

                                    <div id="image-div">

                                        <img id="img" src="<?php echo base_url('uploads/license_document/'.$post['user_id'].'/'. $post['license'])  ?>" style="height: 200px;width: 300px"/>

                                    </div>

                                <?php } else {

                                    ?>

                                    <img id="myno_img" style="width: 80px;height: 80px" src="<?= base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />

                                <?php }

                                ?>

                            </div>

                            <!-- <a href="<?php echo base_url('admin/download/license_document/license/'.$post['user_id']);?>" class="download1" data-folder="license_document" data-driver="<?php echo $post['user_id']?>" data-file="license">Download</a> -->

                        </div>

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label ">Insurance</label>

                            <input type="file" class="form-control" id="insurance"  name="insurance" > 

                            <input type="hidden" class="form-control" id="insurance"  name="update_insurance" value="<?php echo (!empty($post['insurance']))?$post['insurance']:'';?>">

                            <?php echo form_error('insurance'); ?>



                            <div id="email-input-wrapper"  class="controls ">

                                <?php if (!empty($post['insurance'])) { ?>

                                    <div id="image-div">

                                        <img id="img" src="<?php echo base_url('uploads/insurance_document/'.$post['user_id'].'/'. $post['insurance']); ?>" style="height: 300px;width: 200px"/>

                                    </div>

                                <?php } else {

                                    ?>

                                    <img id="myno_img" style="width: 80px;height: 80px" src="<?php echo base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />

                                <?php }

                                ?>

                            </div>

                            <!-- <a href="<?php echo base_url('admin/download/insurance_document/insurance/'.$post['user_id']);?>" class="download1" data-folder="insurance_document" data-driver="<?php echo $post['user_id']?>" data-file="insurance"> Download</a> -->

                        </div>

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label ">Permit</label>

                            <input type="file" class="form-control" id="permit" name="permit" > 

                            <input type="hidden" class="form-control" id="permit" name="update_permit" value="<?php echo (!empty($post['permit']))?$post['permit']:'';?>"> 

                            <?php echo form_error('permit'); ?>

                            <div id="email-input-wrapper"  class="controls ">

                                <?php if (!empty($post['permit'])) { ?>

                                    <div id="image-div">

                                        <img id="img" src="<?php echo base_url('uploads/permit_document/'.$post['user_id'].'/'. $post['permit']);?>" style="height: 200px;width: 200px"/>

                                    </div>

                                <?php } else {

                                    ?>

                                    <img id="myno_img" style="width: 80px;height: 80px" src="<?php echo base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />

                                <?php }

                                ?>

                            </div>

                           <!--  <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a> -->

                        </div>

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label ">Car pic</label>

                            <input type="file" class="form-control" id="car_pic" name="car_pic" > 

                            <input type="hidden" class="form-control" id="car_pic" name="update_car_pic" value="<?php echo (!empty($post['car_pic']))?$post['car_pic']:'';?>"> 

                            <?php echo form_error('car_pic'); ?>

                            <div id="email-input-wrapper"  class="controls ">

                                <?php if (!empty($post['car_pic'])) { ?>

                                    <div id="image-div">

                                        <img id="img" src="<?php echo base_url('uploads/car_pic/'.$post['user_id'].'/'. $post['car_pic']);?>" style="height: 200px;width: 200px"/>

                                    </div>

                                <?php } else {

                                    ?>

                                    <img id="myno_img" style="width: 80px;height: 80px" src="<?php echo base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />

                                <?php }

                                ?>

                            </div>

                           <!--  <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a> -->

                        </div>

                        <div class="mgtp-10 col-md-12">

                            <button class="btn vd_bg-green vd_white" type="button" id="submit-register" name="submit-register">Submit</button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

    $(document).on('click','#submit-register',function(){

        var name = $('#name').val();

        var mobile = $('#mobile').val();

        var email = $('#email').val();

        var vehicle_no = $('#vehicle_no').val();

        var user_id = $('#user_id').val();

        var status = $('.status:checked').val();

        var brand = $('#brand').val();

        var model = $('#set_option').val();

        var year = $('#year').val();

        var vehicle_type = $('#vehicle_type').val();

        var rate = $('#rate').val();

        var color = $('#color').val();

        $.ajax({

            url:base_url+'admin/update_user',

            type:'post',

            dataType:'json',

            data:{name:name,mobile:mobile,email:email,status:status,user_id:user_id,vehicle_no:vehicle_no,brand:brand,model:model,year:year,vehicle_type:vehicle_type,rate:rate,color:color},

            success:function(data){

                alert(data.message);

                location.reload();

            }

        });

    });



    $(document).on('change', '#brand', function () {

    var brand_id = $('#brand').val();

    

    $.ajax({

        url:base_url+'admin/get_brand_model',

        type:'post',

        dataType:'json',

        data:{brand_id:brand_id},

        success:function(data){

            if (data.status) {

                

                option='';

                $.each(data.data, function( index, value ) {

                    option+='<option value="'+value.id+'">'+value.model_name+'</option>';

                  

                });

                $('#set_option').html(option);

            }

        }

    })

    

});

$(document).on('change','#vehicle_type',function(){

    

    var rate = $(this).children("option:selected").attr('rate');

    $('#rate').val(rate);



});

</script>